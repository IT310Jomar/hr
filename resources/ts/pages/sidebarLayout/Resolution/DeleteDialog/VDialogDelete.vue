<script setup lang="ts">
import { environment } from '@/environments/environment';
import axios from 'axios';

const props = defineProps(['dlete', 'dleteLeave', 'dleteOfficial', 'dleteOvertime', 'dleteSched', 'dleteUndtertime', 'allData']);
const emit = defineEmits(['toDeleteData', 'toCancel']);
const token = JSON.parse(localStorage.getItem('accessToken') || 'null');

const confirmAction = () => {
  if(props.dlete) {
    console.log('deleteCash')
    axios.get(environment.API_URL + 'user/resolution/resolution-center/delete-request-cash/' + props.dlete.id, { params : {token : token} })
    .then(response => {
      if (response.data.success) {
        if (response.data.deleteCashAd) {
            const indexs = props.allData.findIndex((cashAd: any) => cashAd.id === props.dlete.id);
            props.allData.splice(indexs, 1);
            emit('toDeleteData')
        }
      }
    })
  }

  if(props.dleteLeave) {
    axios.get(environment.API_URL + 'user/resolution/resolution-center/delete-request-leave/' + props.dleteLeave.id, { params : {token : token} })
    .then(response => {
      if (response.data.success) {
        if (response.data.deleteLeave) {
            const indexs = props.allData.findIndex((cashAd: any) => cashAd.id === props.dleteLeave.id);
            props.allData.splice(indexs, 1);
            emit('toDeleteData')
        }
      }
    })
  }

  if(props.dleteOfficial) {
    axios.get(environment.API_URL + 'user/resolution/resolution-center/delete-request-officialBuisness/' + props.dleteOfficial.id, { params : {token : token} })
    .then(response => {
      if (response.data.success) {
        if (response.data.deleteOffBussines) {
            const indexs = props.allData.findIndex((cashAd: any) => cashAd.id === props.dleteOfficial.id);
            props.allData.splice(indexs, 1);
            emit('toDeleteData')
        }
      }
    })
  }

  if(props.dleteOvertime) {
    axios.get(environment.API_URL + 'user/resolution/resolution-center/delete-request-overtime/' + props.dleteOvertime.id, { params : {token : token} })
    .then(response => {
      if (response.data.success) {
        if (response.data.deleteOvertime) {
            const indexs = props.allData.findIndex((cashAd: any) => cashAd.id === props.dleteOvertime.id);
            props.allData.splice(indexs, 1);
            emit('toDeleteData')
        }
      }
    })
  }

  if(props.dleteSched) {
    axios.get(environment.API_URL + 'user/resolution/resolution-center/delete-request/' + props.dleteSched.id, { params : {token : token} })
    .then(response => {
      if (response.data.success) {
        if (response.data.deleteSched) {
            const indexs = props.allData.findIndex((schedAd: any) => schedAd.id === props.dleteSched.id);
            props.allData.splice(indexs, 1);
            emit('toDeleteData')
        }
      }
    })
  }

  if(props.dleteUndtertime) {
    axios.get(environment.API_URL + 'user/resolution/resolution-center/delete-request-undtertime/' + props.dleteUndtertime.id, { params : {token : token} })
    .then(response => {
      if (response.data.success) {
        if (response.data.deleteUndertime) {
            const indexs = props.allData.findIndex((under: any) => under.id === props.dleteUndtertime.id);
            props.allData.splice(indexs, 1);
            emit('toDeleteData')
        }
      }
    })
  }
}

const closeDialog = () => {
  emit('toDeleteData')
}

// onMounted(() => {
//   console.log(props.allData,'all Data')

// })

</script>


<template>
  <v-card>
    <v-card-title>Confirmation</v-card-title>
    <v-card-text>Are you sure you want to proceed?</v-card-text>
    <v-card-actions>
      <v-btn color="primary" @click="confirmAction">Confirm</v-btn>
      <v-btn color="secondary" @click="closeDialog">Cancel</v-btn>
    </v-card-actions>
  </v-card>
</template>
