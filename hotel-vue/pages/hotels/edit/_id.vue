<template>
  <div>
    <div>
      <div class="box-edit">
        <div class="field d-i">Name:</div>
        <div class="d-i"><input type="text" v-model="hotel.name"></div>
        <div class="field  d-i">rating:</div>
        <div class="d-i"><input type="text" v-model="hotel.rating"></div>
        <div class="field d-i">category:</div>
        <div class="d-i"><input type="text" v-model="hotel.category"></div>
        <div class="field d-i">image:</div>
        <div class="d-i"><input type="text" v-model="hotel.image"></div>
        <div class="field d-i">reputation:</div>
        <div class="d-i"><input type="text" v-model="hotel.reputation"></div>

        <div class="field d-i">price:</div>
        <div class="d-i"><input type="text" v-model="hotel.price"></div>

        <div class="field d-i">availability:</div>
        <div class="d-i"><input type="text" v-model="hotel.availability"></div>

        <div class="field d-i">city:</div>
        <div class="d-i"><input type="text" v-model="hotel.location.city"></div>

        <div class="field d-i">state:</div>
        <div class="d-i"><input type="text" v-model="hotel.location.state"></div>

        <div class="field d-i">country:</div>
        <div class="d-i"><input type="text" v-model="hotel.location.country"></div>

        <div class="field d-i">zip code:</div>
        <div class="d-i"><input type="text" v-model="hotel.location.zip_code"></div>

        <div class="field d-i">address:</div>
        <div class="d-i"><input type="text" v-model="hotel.location.address"></div>

        <button class="button" @click="edit">submit</button>

      </div>
    </div>
  </div>
</template>

<script>
import {mapActions} from "vuex";
import actionTypes from '@/utils/store/actionTypes'

export default {
  data() {
    return {
      data: null,
      hotel: {
        location: {}
      }
    }
  },
  mounted() {
    this.get()
  },
  methods: {
    ...mapActions({
      editItem: actionTypes.item.EDIT_ITEM,
      item: actionTypes.item.GET_ITEM

    }),
    async edit() {
      let {meta, data} = await this.editItem(this.hotel)
      this.data = data
    },
    async get() {
      let {meta, data} = await this.item(this.$route.params.id)
      if (meta.status !== 'Success')
        this.$toast.error(meta.msg)
      this.hotel = data
    }
  }
}
</script>

<style>
.field {
  width: 130px;
}

input {
  width: 160px;
  margin: 9px;
}

.d-i {
  display: inline-block;
}

.button {
  position: absolute;
  bottom: 50px;
  right: 30px;
}

.box-edit {
  position: relative;
  padding: 8px;
  border: 3px solid rgba(19, 74, 110, 0.58);
  border-radius: 0px 16px 17px 0px;
  height: 400px;
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
  font-family: 'Quicksand',
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
