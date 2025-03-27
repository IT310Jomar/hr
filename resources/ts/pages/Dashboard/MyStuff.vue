
<script setup lang="ts">
import axios from 'axios';
import moment from 'moment';
import ApplyBtn from '@/layouts/components/ApplyBtn.vue'

const sick_leave_count = ref()
const vacation_leave_count = ref()
const activeTab = ref('0');
const cashPending = ref()
const leavePending = ref()
const attendancePending = ref()
const schedulePending = ref()
const overtimePending = ref()
const undertimePending = ref()
const businessPending = ref()
const items = ref([
  { title: 'Cash Advance', value: '0' },
  { title: 'Leave', value: '1' },
  { title: 'Certificate of Attendance', value: '2' },
  { title: 'Schedule Adjustment', value: '3' },
  { title: 'Overtime', value: '4' },
  { title: 'Undertime', value: '5' },
  { title: 'Official Business', value: '6' }
])

const token = JSON.parse(localStorage.getItem('accessToken') || 'null')

//Getting Leave Data && Leave Counts
const getData = () => {
  axios.get('/api/user/leave/request/getdata', {
    params: {
      token: token
    }
  }).then(response => {
    for (let i = 0; i < response.data.leaveRequest.length; i++) {
      for (let j = 0; j < response.data.leaveRequest[i].leave_credits.length; j++) {
        sick_leave_count.value = response.data.leaveRequest[i].leave_credits[j].sick_leave_credits
        vacation_leave_count.value = response.data.leaveRequest[i].leave_credits[j].vacation_leave_credits
      }
    }
  }).catch(error => {
    console.log('error')
  })
}

//Getting All Pending Request Per Employee
const getAllPending = () => {
  axios.get('/api/user/dashboard/mystuff/pending', {
    params: {
      token: token
    }
  }).then(response => {
    cashPending.value = response.data.cashAdvancePending
    leavePending.value = response.data.leavePending
    attendancePending.value = response.data.attendancePening
    schedulePending.value = response.data.schedulePending
    overtimePending.value = response.data.overtimePending
    undertimePending.value = response.data.undertimePedning
    businessPending.value = response.data.businessRequest
  })
}


onMounted(() => {
  getData()
  getAllPending()
})

const userRole = JSON.parse(localStorage.getItem('userRole') || 'null')


</script>

<template>
  <VCol v-if="userRole == 'Employee'">
    <V-Card height="400px" title="My Stuff" class="d-flex flex-column">
        <div class="d-flex justify-end">
          <ApplyBtn />
        </div>
        <VDivider />
        <v-card-text class="flex-grow-1 overflow-auto">
          <div>
            <div>
              <div class="card-block vb-content">
                <p class="card-text"><strong>Pending Requests</strong></p>
                <VTabs v-model="activeTab">
                  <VTab v-for="item in items" :key="item.title" :value="item.value">
                    {{ item.title }}
                  </VTab>
                </VTabs>
                <VWindow v-model="activeTab">
                  <!-- Cash Advance Request Pending -->
                  <VWindowItem :value="'0'">
                    <VTable>
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Requested Date</th>
                        </tr>
                      </thead>
                      <tbody v-for="data in cashPending" :key="data">
                        <tr>
                          <td>{{ data.id }}</td>
                          <td>{{ moment(data.requested_date).format('MMMM DD, YYYY') }}</td>
                        </tr>
                      </tbody>
                      <tr v-if="cashPending?.length == 0">
                        <td colspan="12" class="text-center">
                          All your requests are approved.
                        </td>
                      </tr>
                    </VTable>
                  </VWindowItem>
                  <!-- Leave Request Pending -->
                  <VWindowItem :value="'1'">
                    <VTable>
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Requested Date</th>
                        </tr>
                      </thead>
                      <tbody v-for="data in leavePending" :key="data">
                        <tr>
                          <td>{{ data.id }}</td>
                          <td>{{ moment(data.created_at).format('MMMM DD, YYYY') }}</td>
                        </tr>
                      </tbody>
                      <tr v-if="leavePending?.length == 0">
                        <td colspan="12" class="text-center">
                          All your requests are approved.
                        </td>
                      </tr>
                    </VTable>
                  </VWindowItem>
                  <!-- Certificate Of Attendance Request Pending -->
                  <VWindowItem :value="'2'">
                    <VTable>
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Requested Date</th>
                        </tr>
                      </thead>
                      <tbody v-for="data in attendancePending">
                        <tr>
                          <td>{{ data.id }}</td>
                          <td>{{ moment(data.created_at).format('MMMM DD, YYYY') }}</td>
                        </tr>
                      </tbody>
                      <tr v-if="attendancePending?.length == 0">
                        <td colspan="12" class="text-center">
                          All your requests are approved.
                        </td>
                      </tr>
                    </VTable>
                  </VWindowItem>
                  <!-- Schedule Adjustment Request Pending -->
                  <VWindowItem :value="'3'">
                    <VTable>
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Requested Date</th>
                        </tr>
                      </thead>
                      <tbody v-for="data in schedulePending">
                        <tr>
                          <td>{{ data.id }}</td>
                          <td>{{ moment(data.created_at).format('MMMM DD, YYYY') }}</td>
                        </tr>
                      </tbody>
                      <tr v-if="schedulePending?.length == 0">
                        <td colspan="12" class="text-center">
                          All your requests are approved.
                        </td>
                      </tr>
                    </VTable>
                  </VWindowItem>
                  <!-- Overtime Request Pending -->
                  <VWindowItem :value="'4'">
                    <VTable>
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Requested Date</th>
                        </tr>
                      </thead>
                      <tbody v-for="data in overtimePending">
                        <tr>
                          <td>{{ data.id }}</td>
                          <td>{{ moment(data.created_at).format('MMMM DD, YYYY') }}</td>
                        </tr>
                      </tbody>
                      <tr v-if="schedulePending?.length == 0">
                        <td colspan="12" class="text-center">
                          All your requests are approved.
                        </td>
                      </tr>
                    </VTable>
                  </VWindowItem>
                  <!-- Undertime Request Pending -->
                  <VWindowItem :value="'5'">
                    <VTable>
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Requested Date</th>
                        </tr>
                      </thead>
                      <tbody v-for="data in undertimePending" :key="data">
                        <tr>
                          <td>{{ data.id }}</td>
                          <td>{{ moment(data.created_at).format('MMMM DD, YYYY') }}</td>
                        </tr>
                      </tbody>
                      <tr v-if="undertimePending?.length == 0">
                        <td colspan="12" class="text-center">
                          All your requests are approved.
                        </td>
                      </tr>
                    </VTable>
                  </VWindowItem>
                  <!-- Official Business Request Pending -->
                  <VWindowItem :value="'6'">
                    <VTable>
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Requested Date</th>
                        </tr>
                      </thead>
                      <tbody v-for="data in businessPending" :key="data">
                        <tr>
                          <td>{{ data.id }}</td>
                          <td>{{ moment(data.created_at).format('MMMM DD, YYYY') }}</td>
                        </tr>
                      </tbody>
                      <tr v-if="businessPending?.length == 0">
                        <td colspan="12" class="text-center">
                          All your requests are approved.
                        </td>
                      </tr>
                    </VTable>
                  </VWindowItem>
                </VWindow>
                <div class="separator"></div>
                <p class="card-text"><strong>Leave Credits</strong></p>
                <VDivider />
                <VTable class="text-no-wrap mb-8">
                  <tbody>
                    <tr>
                      <td>Sick</td>
                      <td>{{ sick_leave_count }}</td>
                    </tr>
                    <tr>
                      <td>Vacation</td>
                      <td>{{ vacation_leave_count }}</td>
                    </tr>
                  </tbody>
                </VTable>
                <div class="separator"></div>
                <p class="card-text"><strong>Stats</strong></p>
                <VDivider />
                <VTable class="table table-responsive">
                  <tbody>
                    <tr>
                      <td>Overtime</td>
                      <td>0 minutes</td>
                    </tr>
                    <tr>
                      <td>Undertime</td>
                      <td>0 minutes</td>
                    </tr>
                    <tr>
                      <td>Official Business</td>
                      <td>0 trip/s</td>
                    </tr>
                    <tr>
                      <td>Late</td>
                      <td>0 minutes</td>
                    </tr>
                  </tbody>
                </VTable>
              </div>
            </div>
          </div>
        </v-card-text>
      </V-Card>
  </VCol>

  <VCol cols="12" sm="6" md="4" v-else>
    <V-Card height="400px" title="My Stuff" class="d-flex flex-column">
      <div class="d-flex justify-end">
        <ApplyBtn />
      </div>
      <VDivider />
      <v-card-text class="flex-grow-1 overflow-auto">
        <div>
          <div>
            <div class="card-block vb-content">
              <p class="card-text"><strong>Pending Requests</strong></p>
              <VTabs v-model="activeTab">
                <VTab v-for="item in items" :key="item.title" :value="item.value">
                  {{ item.title }}
                </VTab>
              </VTabs>
              <VWindow v-model="activeTab">
                <!-- Cash Advance Request Pending -->
                <VWindowItem :value="'0'">
                  <VTable>
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Requested Date</th>
                      </tr>
                    </thead>
                    <tbody v-for="data in cashPending" :key="data">
                      <tr>
                        <td>{{ data.id }}</td>
                        <td>{{ moment(data.requested_date).format('MMMM DD, YYYY') }}</td>
                      </tr>
                    </tbody>
                    <tr v-if="cashPending?.length == 0">
                      <td colspan="12" class="text-center">
                        All your requests are approved.
                      </td>
                    </tr>
                  </VTable>
                </VWindowItem>
                <!-- Leave Request Pending -->
                <VWindowItem :value="'1'">
                  <VTable>
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Requested Date</th>
                      </tr>
                    </thead>
                    <tbody v-for="data in leavePending" :key="data">
                      <tr>
                        <td>{{ data.id }}</td>
                        <td>{{ moment(data.created_at).format('MMMM DD, YYYY') }}</td>
                      </tr>
                    </tbody>
                    <tr v-if="leavePending?.length == 0">
                      <td colspan="12" class="text-center">
                        All your requests are approved.
                      </td>
                    </tr>
                  </VTable>
                </VWindowItem>
                <!-- Certificate Of Attendance Request Pending -->
                <VWindowItem :value="'2'">
                  <VTable>
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Requested Date</th>
                      </tr>
                    </thead>
                    <tbody v-for="data in attendancePending">
                      <tr>
                        <td>{{ data.id }}</td>
                        <td>{{ moment(data.created_at).format('MMMM DD, YYYY') }}</td>
                      </tr>
                    </tbody>
                    <tr v-if="attendancePending?.length == 0">
                      <td colspan="12" class="text-center">
                        All your requests are approved.
                      </td>
                    </tr>
                  </VTable>
                </VWindowItem>
                <!-- Schedule Adjustment Request Pending -->
                <VWindowItem :value="'3'">
                  <VTable>
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Requested Date</th>
                      </tr>
                    </thead>
                    <tbody v-for="data in schedulePending">
                      <tr>
                        <td>{{ data.id }}</td>
                        <td>{{ moment(data.created_at).format('MMMM DD, YYYY') }}</td>
                      </tr>
                    </tbody>
                    <tr v-if="schedulePending?.length == 0">
                      <td colspan="12" class="text-center">
                        All your requests are approved.
                      </td>
                    </tr>
                  </VTable>
                </VWindowItem>
                <!-- Overtime Request Pending -->
                <VWindowItem :value="'4'">
                  <VTable>
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Requested Date</th>
                      </tr>
                    </thead>
                    <tbody v-for="data in overtimePending">
                      <tr>
                        <td>{{ data.id }}</td>
                        <td>{{ moment(data.created_at).format('MMMM DD, YYYY') }}</td>
                      </tr>
                    </tbody>
                    <tr v-if="schedulePending?.length == 0">
                      <td colspan="12" class="text-center">
                        All your requests are approved.
                      </td>
                    </tr>
                  </VTable>
                </VWindowItem>
                <!-- Undertime Request Pending -->
                <VWindowItem :value="'5'">
                  <VTable>
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Requested Date</th>
                      </tr>
                    </thead>
                    <tbody v-for="data in undertimePending" :key="data">
                      <tr>
                        <td>{{ data.id }}</td>
                        <td>{{ moment(data.created_at).format('MMMM DD, YYYY') }}</td>
                      </tr>
                    </tbody>
                    <tr v-if="undertimePending?.length == 0">
                      <td colspan="12" class="text-center">
                        All your requests are approved.
                      </td>
                    </tr>
                  </VTable>
                </VWindowItem>
                <!-- Official Business Request Pending -->
                <VWindowItem :value="'6'">
                  <VTable>
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Requested Date</th>
                      </tr>
                    </thead>
                    <tbody v-for="data in businessPending" :key="data">
                      <tr>
                        <td>{{ data.id }}</td>
                        <td>{{ moment(data.created_at).format('MMMM DD, YYYY') }}</td>
                      </tr>
                    </tbody>
                    <tr v-if="businessPending?.length == 0">
                      <td colspan="12" class="text-center">
                        All your requests are approved.
                      </td>
                    </tr>
                  </VTable>
                </VWindowItem>
              </VWindow>
              <div class="separator"></div>
              <p class="card-text"><strong>Leave Credits</strong></p>
              <VDivider />
              <VTable class="text-no-wrap mb-8">
                <tbody>
                  <tr>
                    <td>Sick</td>
                    <td>{{ sick_leave_count }}</td>
                  </tr>
                  <tr>
                    <td>Vacation</td>
                    <td>{{ vacation_leave_count }}</td>
                  </tr>
                </tbody>
              </VTable>
              <div class="separator"></div>
              <p class="card-text"><strong>Stats</strong></p>
              <VDivider />
              <VTable class="table table-responsive">
                <tbody>
                  <tr>
                    <td>Overtime</td>
                    <td>0 minutes</td>
                  </tr>
                  <tr>
                    <td>Undertime</td>
                    <td>0 minutes</td>
                  </tr>
                  <tr>
                    <td>Official Business</td>
                    <td>0 trip/s</td>
                  </tr>
                  <tr>
                    <td>Late</td>
                    <td>0 minutes</td>
                  </tr>
                </tbody>
              </VTable>
            </div>
          </div>
        </div>
      </v-card-text>
    </V-Card>
  </VCol>
</template>
