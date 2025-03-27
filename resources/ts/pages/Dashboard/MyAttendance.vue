<script setup lang="ts">
import axios from 'axios';
import TakeABreak from '@/layouts/components/TakeABreak.vue'


const attendancelog = ref()
const breakDialog = ref(false)

const token = JSON.parse(localStorage.getItem('accessToken') || 'null')

const getData = () => {
  axios.get('api/user/attendancelogs/view', {
    params: {
      token: token
    }
  }).then(response => {
    attendancelog.value = response.data.attendanceLogs
  })
}

const breakView = () =>{
  breakDialog.value = true
}

onMounted(() => {
  getData()

})

const userRole = JSON.parse(localStorage.getItem('userRole') || 'null')


</script>


<template>
  <v-col cols="12" sm="6" md="4" v-if="userRole == 'God Mode' || userRole == 'Administrator' || userRole == 'Supervisor / Manager'">
    <V-Card height="400px" title="My Attendance" width="auto" class="d-flex flex-column mb-4">
      <div class="d-flex justify-end mb-2">
        <VBtn inset size="small" class="align-self-end mr-2" style="margin-top: -5%;" @click="breakView()" >Take a Break</VBtn>
      </div>
      <VDivider />
      <VCardText class="flex-grow-1 overflow-auto">
        <div>
          <div class="card-block h-100 vb-content">
            <VTable class="table table-responsive" style="text-align: center; " >
              <!-- 👉 table head -->
              <thead>
                <tr>
                  <th width="70px" style="font-size: medium;">Status</th>
                  <th style="font-size: medium;">Date &amp; Time</th>
                </tr>
              </thead>
              <tbody v-for="data in attendancelog" :key="data">
                <tr>
                  <td>{{ data.state }}</td>
                  <td>{{ data.login }} / {{ data.timeIn }}</td>
                </tr>
              </tbody>
              <tr v-if="attendancelog?.length == 0">
                <td colspan="12" class="text-center">
                  No Data Found!
                </td>
              </tr>
            </VTable>
          </div>
          <div class="vb-dragger" style="position: absolute; height: 0px; top: 0px;">
            <div class="vb-dragger-styler"></div>
          </div>
        </div>
      </VCardText>
    </V-Card>
  </v-col>
  
  <v-col v-else>
    <V-Card height="400px" title="My Attendance" width="auto" class="d-flex flex-column mb-4">
      <div class="d-flex justify-end mb-2">
        <VBtn inset size="small" class="align-self-end mr-2" style="margin-top: -5%;" @click="breakView()" >Take a Break</VBtn>
      </div>
      <VDivider />
      <VCardText class="flex-grow-1 overflow-auto">
        <div>
          <div class="card-block h-100 vb-content">
            <VTable class="table table-responsive" style="text-align: center; " >
              <!-- 👉 table head -->
              <thead>
                <tr>
                  <th style="font-size: medium;">Status</th>
                  <th style="font-size: medium;">Date &amp; Time</th>
                </tr>
              </thead>
              <tbody v-for="data in attendancelog" :key="data">
                <tr>
                  <td>{{ data.state }}</td>
                  <td>{{ data.login }} / {{ data.timeIn }}</td>
                </tr>
              </tbody>
              <tr v-if="attendancelog?.length == 0">
                <td colspan="12" class="text-center">
                  No Data Found!
                </td>
              </tr>
            </VTable>
          </div>
          <div class="vb-dragger" style="position: absolute; height: 0px; top: 0px;">
            <div class="vb-dragger-styler"></div>
          </div>
        </div>
      </VCardText>
    </V-Card>
  </v-col>

  <!-- For viewing break Dialog -->
  <VDialog v-model="breakDialog" max-width="600px" :persistent="true">
    <TakeABreak @closedialog="breakDialog = false" />
  </VDialog>
</template>


<style>
.overflow-auto::-webkit-scrollbar {
  block-size: 0;
  inline-size: 0;
}

.overflow-auto:hover::-webkit-scrollbar {
  block-size: 6px;
  inline-size: 6px;
}

.overflow-auto::-webkit-scrollbar-thumb {
  border-radius: 3px;
  background-color: #3a7fc9;
  transition: background-color 0.2s ease-in-out;
}

.overflow-auto::-webkit-scrollbar-thumb:hover {
  background-color: #255da8;
}

.scrollbar {
  overflow-y: auto;
  scrollbar-width: thin;
}
</style>
