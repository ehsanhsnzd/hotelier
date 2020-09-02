<template>
  <div>
    <br>
    <button class="fa fa-plus" @click="$router.push('hotels/create')">create new</button>
    <div v-for="hotel in data">
      <div class="box">
        <div class="fa fa-hospital fa-2x"></div>
        <div class="d-i"><b>Name: {{hotel.name}}</b></div>
        <div><small>Rating :{{hotel.rating}}</small></div>
        <div><small>Price :${{hotel.price}}</small></div>
        <div class="button">
          <button class="fa fa-check" @click="$router.push('hotels/book/'+hotel.id)">book</button>
          <button class="fa fa-pen" @click="$router.push('hotels/edit/'+hotel.id)">edit</button>
          <button class="fa fa-info" @click="$router.push('hotels/info/'+hotel.id)">more info</button>
          <button class="fa fa-trash" @click="remove(hotel.id)">delete</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions} from "vuex";
import actionTypes from '~/utils/store/actionTypes'

export default {
  data() {
    return {
      data:null
    }
  },
  mounted() {
  this.getAll()
    },
  methods:{
    ...mapActions({
      items:  actionTypes.item.ALL_ITEMS,
      deleteItem:  actionTypes.item.DELETE_ITEM,

    }),
    async getAll(){
      let {meta,data} = await this.items()
      this.data = data
    },
    async remove(id){
      let {meta,data} = await this.deleteItem(id)
      this.data = data
      if(meta.status==='Success')
        this.$toast.success(meta.msg)
      else{
          this.$toast.error(meta.msg)
      }
      await this.getAll()
    }
  }
}
</script>

<style>
.d-i{
  display: inline-block;
}
.button{
  position: absolute;
  right: 5px;
}
.box{
  position: relative;
  padding: 8px;
  border: 3px solid rgba(19,74,110,0.58);
  border-radius: 0px 16px 17px 0px;
  height: 120px;
  margin: 15px;
}
.container {
  margin: 0 auto;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.title {
  font-family:
    'Quicksand',
    'Source Sans Pro',
    -apple-system,
    BlinkMacSystemFont,
    'Segoe UI',
    Roboto,
    'Helvetica Neue',
    Arial,
    sans-serif;
  display: block;
  font-weight: 300;
  font-size: 100px;
  color: #35495e;
  letter-spacing: 1px;
}

.subtitle {
  font-weight: 300;
  font-size: 42px;
  color: #526488;
  word-spacing: 5px;
  padding-bottom: 15px;
}

.links {
  padding-top: 15px;
}
</style>
