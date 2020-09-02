import axios from 'axios'

export function  isJson(str) {
  let parsedJson
  try {
    parsedJson = JSON.parse(str)
  }catch (e) {
    return false
  }
  return parsedJson
}



export function execute(method, resource, data, params) {
  return axios({
      method,
      url: 'http://localhost:82'+resource,
      data,
      params
    })
    .then((res) => {
      if (res) return res.data
    })
    .catch(err=>{
      return err.response.data
    })
}

