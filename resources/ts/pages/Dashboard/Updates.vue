<script setup lang="ts">
import MemoNew from '@/layouts/components/MemoNew.vue';
import axios from 'axios';
import moment from 'moment';

const ir_dt = ref([''])
const ir_account = ref([''])
const immediate_head = ref([''])
const incident = ref([''])
const ir_data = ref()
const today_BD = ref([''])
const todayBD_Name = ref([''])
const up_BD = ref([''])
const upBD_Name = ref([''])
const memo_subject = ref([''])
const memoDialog = ref(false)

const getIncidentData = () => {
  axios.get('/api/user/dashboard/updates/incident')
    .then((response) => {
      if (response.data.success) {
        if (response.data.incident) {
          ir_data.value = response.data
          ir_dt.value = []
          ir_account.value = []
          immediate_head.value = []
          incident.value = []
          for (let i = 0; i < response.data.incident.length; i++) {
            ir_dt.value.push(response.data.incident[i].dt_of_incident)
            ir_account.value.push(response.data.incident[i].account)
            immediate_head.value.push(response.data.incident[i].immediate_head)
            incident.value.push(response.data.incident[i].incident)
          }
        }
      }
    }).catch((error) => {
      console.log('error')
    })
}

const getEmp = () => {
  axios.get('api/user/employees/getEmployee')
    .then((response) => {
      if (response.data.success) {
        today_BD.value = []
        todayBD_Name.value = []
        up_BD.value = []
        upBD_Name.value = []
        if (response.data.employees) {
          for (let i = 0; i < response.data.employees.length; i++) {
            // getting all employee that has birthday today
            if (moment(response.data.employees[i].birthdate).format('MM/DD/YYYY') === moment(new Date()).format('MM/DD/YYYY')) {
              today_BD.value.push(response.data.employees[i].birthdate)
              const name = response.data.employees[i].first_name
              const lastname = response.data.employees[i].last_name
              todayBD_Name.value.push(name + " " + lastname)
            }
            // getting all employee that has upcoming birthday
            if (moment(response.data.employees[i].birthdate).format('MM/DD/YYYY') > moment(new Date()).format('MM/DD/YYYY')) {
              up_BD.value.push(response.data.employees[i].birthdate)
              const name = response.data.employees[i].first_name
              const lastname = response.data.employees[i].last_name
              upBD_Name.value.push(name + " " + lastname)
            }
          }
        }
      }
    }).catch((error) => {
      console.log('error')
    })
}

const memo_to_address = ref([''])
const memo_from_address = ref([''])
const memo_date = ref([''])
const latest_memo_ToAddress = ref()
const latest_memo_FromAddress = ref()
const latest_memo_subject = ref()
const latest_memo_date = ref()
const getMemos = () => {
  axios.get('api/user/memo/view')
    .then((response) => {
      if (response.data.success) {
        memo_to_address.value = []
        memo_from_address.value = []
        memo_subject.value = []
        memo_date.value = []
        if (response.data.memo_view) {
          for (let i = 0; i < response.data.memo_view.length; i++) {
            // getting all memo data
            memo_to_address.value.push(response.data.memo_view[i].to_address)
            memo_from_address.value.push(response.data.memo_view[i].from_address)
            memo_subject.value.push(response.data.memo_view[i].memo_subject)
            memo_date.value.push(response.data.memo_view[i].memo_date)

            // getting the latest memo data 
            latest_memo_ToAddress.value = response.data.memo_view[i].to_address
            latest_memo_FromAddress.value = response.data.memo_view[i].from_address
            latest_memo_subject.value = response.data.memo_view[i].memo_subject
            latest_memo_date.value = response.data.memo_view[i].memo_date
          }

        }
      }
    }).catch((error) => {
      console.log('error')
    })
}

const memoView = () => {
  memoDialog.value = true
}

onMounted(() => {
  getIncidentData()
  getEmp()
  getMemos()
})

const userRole = JSON.parse(localStorage.getItem('userRole') || 'null')


</script>

<template>
  <v-col cols="12" sm="6" md="4" v-if="userRole == 'God Mode' || userRole == 'Administrator' || userRole == 'Supervisor / Manager'">
    <v-card height="400px" title="Updates" class="d-flex flex-column mb-4">
      <v-divider />
      <v-card-text class="flex-grow-1 overflow-auto">
        <!-- Memos -->
        <p class="card-text mb-4"><strong>MEMO</strong></p>
        <div v-for="(data, i) in memo_subject" :key="i">
          <strong> <span class="no-wrap">{{ memo_subject[i] }}</span></strong>
          <div>
            <label><strong>TO:</strong> <span>{{ memo_to_address[i] }}</span></label>
          </div>
          <div>
            <label><strong>FROM:</strong> <span>{{ memo_from_address[i] }}</span></label>
          </div>
          <div>
            <label><strong>SUBJECT:</strong> <span>{{ memo_subject[i] }}</span></label>
          </div>
          <div>
            <label><strong>DATE:</strong> <span>{{ memo_date[i] }}</span></label>
          </div>
          <div class="separator mb-4"></div>
        </div>
        <div class="text-right">
          <VBtn size="x-small" color="primary" rounded="pill" @click="memoView()"><span>new</span>
          </VBtn>
        </div>
        <span v-if="memo_subject?.length === 0">memo</span>
        <!-- Memo End -->

        <hr class="my-4">

        <div class="separator mb-4"></div>
        <!-- Incident Report -->
        <p class="card-text"><strong>INCIDENT REPORT</strong></p>
        <div v-for="(data, i) in ir_dt" :key="i">
          <div class="cols-12">
            <label><strong>Date of incident:</strong> <span>{{ moment(ir_dt[i]).format('MMMM DD, YYYY') }}</span></label>
          </div>
          <div>
            <label><strong>Time of incident:</strong><span> {{ moment(ir_dt[i], 'hh:mm A').format('hh:mm A') }}
              </span></label>
          </div>
          <div>
            <label><strong>Account:</strong> <span>{{ ir_account[i] }}</span></label>
          </div>
          <div>
            <label><strong>Immediate Head:</strong> <span>{{ immediate_head[i] }}</span></label>
          </div>
          <div class="col-12">
            <span>{{ incident[i] }}</span>
          </div>
          <div class="separator mb-4"></div>
        </div>
        <span v-if="ir_dt?.length === 0">No Incident report</span>
        <!-- Incident Report End -->

        <div class="separator mb-4"></div>
        <hr class="my-4">
        <!-- Today's BirthDay -->
        <p class="card-text"><strong>BIRTHDAY'S</strong></p>
        <VTable>
          <tbody>
            <tr v-for="(data, i) in today_BD" :key="i">
              <td>
                <strong> {{ todayBD_Name[i] }} </strong>
              </td>
              <td>
                <strong>{{ moment(today_BD[i]).format('MM/DD/YYYY') }}</strong>
              </td>
            </tr>
          </tbody>
        </VTable>
        <span v-if="today_BD?.length === 0">No Birthday Today</span>
        <!-- Today's BirthDay End -->

        <hr class="my-4">

        <!-- Upcoming BirthDay -->
        <p class="card-text"><strong>UPCOMING BIRTHDAY'S</strong></p>
        <VTable>
          <tbody>
            <tr v-for="(data, i) in up_BD" :key="i">
              <td>
                <strong> {{ upBD_Name[i] }} </strong>
              </td>
              <td>
                <strong>{{ moment(up_BD[i]).format('MM/DD/YYYY') }}</strong>
              </td>
            </tr>
          </tbody>
        </VTable>
        <span v-if="up_BD?.length === 0">No Upcoming Birthday's This Month</span>
        <!-- Upcoming BirthDay -->
      </v-card-text>
    </v-card>
  </v-col>
  <!-- Dialog for Viewing Memo  -->
  <VDialog v-model="memoDialog" max-width="600">
    <MemoNew @closedialog="memoDialog = false" :latest_memo_ToAddress="latest_memo_ToAddress" :latest_memo_FromAddress="latest_memo_FromAddress"
    :latest_memo_subject="latest_memo_subject" :latest_memo_date="latest_memo_date"/>
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

::v-deep .v-dialog {
  z-index: 1051;
}

</style>



