<template>
  <div>
    <br>
    <div v-if="data">
      <div class="box-detail">
        <div class="info-title d-i">Name:</div>
        <div class="d-i">
          {{data.name}}
        </div>
        <br>
        <div class="info-title d-i">Rating:</div>
        <div class="d-i">
          {{data.rating}}
        </div>
        <br>
        <div class="info-title d-i">category:</div>
        <div class="d-i">
          {{data.category}}
        </div>
        <br>
        <div class="info-title d-i">image:</div>
        <div class="d-i">
          {{data.image}}
        </div>
        <br>
        <div class="info-title d-i">reputation:</div>
        <div class="d-i" :style="'background-color:'+data.reputationBadge ">
          {{data.reputation}}
        </div>
        <br>
        <div class="info-title d-i">price:</div>
        <div class="d-i">
          {{data.price}}
        </div>
        <br>
        <div class="info-title d-i">availability:</div>
        <div class="d-i">
          {{data.availability}}
        </div>
        <br>
        <br>
        <h3>location</h3>
        <br>
        <div class="info-title d-i">city:</div>
        <div class="d-i">
          {{data.location.city}}
        </div>
        <br>
        <div class="info-title d-i">state:</div>
        <div class="d-i">
          {{data.location.state}}
        </div>
        <br>
        <div class="info-title d-i">country:</div>
        <div class="d-i">
          {{data.location.country}}
        </div>
        <br>
        <div class="info-title d-i">zip code:</div>
        <div class="d-i">
          {{data.location.zip_code}}
        </div>
        <br>
        <div class="info-title d-i">address:</div>
        <div class="d-i">
          {{data.location.address}}
        </div>


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

    }
  },
  components: {
    Datepicker
  },
  mounted() {
    this.get()
  },
  methods: {
    ...mapActions({
      item: actionTypes.item.GET_ITEM
    }),
    async get() {
      let {meta, data} = await this.item(this.$route.params.id)
      if (meta.status !== 'Success')
        this.$toast.error(meta.msg)
      this.data = data
    }
  }
}
</script>

<style>
.info-title {
  font-weight: 300;
  font-size: 16px;
  color: #526488;
  word-spacing: 5px;
  padding-bottom: 15px;
}

.box-detail{
  position: relative;
  padding: 8px;
  border: 3px solid rgba(19,74,110,0.58);
  border-radius: 0px 16px 17px 0px;
  margin: 15px;
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
  font-size: 9px;
  color: #526488;
  word-spacing: 5px;
  padding-bottom: 15px;
}

.links {
  padding-top: 15px;
}
</style>
