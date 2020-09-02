import axios from 'axios'
import types from '~/utils/store/moduleTypes'
const CancelToken = axios.CancelToken
let cancelObj = {}
export default function(ctx) {
  let { app, $axios, redirect, store, route } = ctx
  let cacheConfig = []
  let onRefreshToken = false
  let index = 0

  $axios.onRequest(
    (config) => {
      try {
        let similarReq = Object.values(cacheConfig).find((e) => {
          let staticUrl = config.url
          if (e.staticUrl == staticUrl) return e
        })

        let routePath = window ? window.location.pathname : route.path
        let userType = routePath.startsWith('/admin') ? 'admin' : 'agent'
        let userFullData = store.getters.getAuthData[userType]

        if (similarReq && cancelObj['index' + similarReq.index]) {
          cancelObj['index' + similarReq.index]('')
          delete cancelObj['index' + similarReq.index]
          let configIndex = cacheConfig.filter((e, i) => {
            if (e.staticUrl == similarReq.staticUrl) return i
          })
          cacheConfig.splice(configIndex, 1)
        }
        if (config.url != userFullData.urlSuffix + '/refresh') {
          config.cancelToken = new CancelToken((cancel) => {
            cancelObj['index' + index] = cancel
          })
          cacheConfig.push({ ...config, index, staticUrl: config.url })
        }

        if (config.params) {
          config.url = config.url + '/' + config.params
          delete config.params
        }
        config.headers.common['Content-Type'] = 'application/json'
        config.headers.common.Accept = 'application/json;'
        const token = userFullData.token
        config.headers.Authorization = `Bearer ${token}`
        config.index = index
        config.staticUrl = config.url

        // NProgress.start();
        // return config;
        index++
        return config
      } catch (error) {
      }
    },
    (error) => Promise.reject({ meta: error, data: null })
  )
  $axios.onResponse((res) => {
    let routePath = window ? window.location.pathname : route.path
    let userType = routePath.startsWith('/admin') ? 'admin' : 'agent'
    let userFullData = store.getters.getAuthData[userType]
    let baseURL= res.config.baseURL.substring(0, res.config.baseURL.length - 1)
    if (res.config.url != baseURL+userFullData.urlSuffix + '/refresh') {
        let configIndex = cacheConfig.filter((e, i) => {
            if (e.staticUrl == res.staticUrl) return i
        })
        if (cancelObj['index' + res.config.index])
        delete cancelObj['index' + res.config.index]
        if (configIndex) cacheConfig.splice(configIndex, 1)
    }
  })

    $axios.onError(async error => {

    let routePath = window ? window.location.pathname : route.path
    let userType = routePath.startsWith('/admin') ? 'admin' : 'agent'
    let mainUserType = store.getters.getAuthData.mainUserType


    const code = parseInt(error.response && error.response.status)
    if (code === 401) {
      let configStaticUrl = error.response.config.staticUrl
      if(configStaticUrl && ['/user/auth/refresh', '/agent/refresh'].includes(configStaticUrl)){
        let redirectPath =configStaticUrl ==  '/user/auth/refresh' ? '/admin-agent': '/'
        if(mainUserType == 'admin' && configStaticUrl=='/agent/refresh')
          store.dispatch('auth/agentLogout')
        else
          store.dispatch('auth/logout')
        app.$toast.error('Your Session Is Expired')

        return redirect(redirectPath)
      }
      else{

      const statusCode = error.response.data.meta
        ? parseInt(error.response.data.meta.statusCode)
        : 0
      // user pass wrong
      if (statusCode == 1401) app.$toast.error(error.response.data.meta.msg)
      else if (!onRefreshToken) {
        onRefreshToken = true
        let isAuth = await store.dispatch('auth/refreshToken', userType)
        onRefreshToken = false

        if (isAuth && isAuth.meta.status == 'Success') {
          let { meta, data } = isAuth

          await store.dispatch('auth/saveData', {
            accessToken: data.access_token,
            mainUserType: userType,
            adminAsAgent: mainUserType == 'admin' && userType == 'agent',
            balance: data.balance
          })
          for (let i = 0; i < cacheConfig.length; i++) {
            return window.$nuxt.$axios.request(cacheConfig[i])
          }
          cacheConfig = []
          cancelObj={}
        } else {
          if (mainUserType == 'admin' && userType == 'agent') {
          store.dispatch('auth/agentLogout')
            app.$toast.error('You Logged Out As Agent')
            // return redirect('/admin/agent')
          } else {
            store.dispatch('auth/logout')
            app.$toast.error('You logged out')
          }
          let redirectPath = userType == 'agent' ? '/' : '/admin-login'
          return redirect(redirectPath)
          // app.$auth.logout()
        }
      }
    }
    } else {
      if(error.response || error.message)
        app.$toast.show(error.response? `${error.response.data.meta.msg} (${error.response.data.meta.statusCode})` : error.message , {
          type: 'error',
          icon: 'error_outline'
        })
    }
    return error
    // if (code === 400) {
    //   redirect('/400')
    // }
  })
}
