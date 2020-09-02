<template>
  <div>
    <br>
    <div>
      <div class="box">
        <div class="field d-i">arrival date:</div>
        <div class="d-i"><datepicker v-model="book.arrival_date"></datepicker></div>

        <div class="field d-i">departure date:</div>
        <div class="d-i"><datepicker v-model="book.departure_date"></datepicker></div>

        <button class="button-search" @click="reserve">submit</button>

      </div>
    </div>
  </div>
</template>

<script>
import {mapActions} from "vuex";
import actionTypes from '@/utils/store/actionTypes'
import Datepicker from 'vuejs-datepicker';
import moment from 'moment'

export default {
  data() {
    return {
      data: null,
      book: {
        arrival_date:null,
        departure_date:null
      }
    }
  },
  components:{
    Datepicker
  },
  methods: {
    ...mapActions({
      booking: actionTypes.item.BOOK
    }),
    async reserve() {
      let arrival = moment(this.book.arrival_date).format( 'YYYY-MM-DD')
      let departure = moment(this.book.departure_date).format( 'YYYY-MM-DD')
     let req = {
        arrival_date:arrival,
        departure_date:departure,
        item_id:this.$route.params.id
      }

      let {meta, data} = await this.booking(req)
        if(meta.status==='Success')
          this.$toast.success(meta.msg)
        else{
          if(meta.validation!= undefined && meta.validation.errors !=undefined)
            Object.values(meta.validation.errors).map((value)=>{
              this.$toast.error(value)
              }
            )
          else
            this.$toast.error(meta.msg)
        }
      this.data = data
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

.button-search {
  position: absolute;
  bottom: 10px;
  right: 30px;
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
