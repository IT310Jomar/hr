<script setup lang="ts">
import AppDateTimePicker from '@/@core/components/AppDateTimePicker.vue'
import axios from 'axios'
import {ref, onMounted } from 'vue'
import moment from 'moment';

const dateRange = ref('')
const isDialogVisible = ref(false)
const attendance = ref()
const daysOfAbsent = ref()
const dateAtt = ref()
const token = JSON.parse(localStorage.getItem('accessToken') || 'null');

const getAttendance  = () => {
  axios.get('/api/user/manage/manage-team/get-team-attendance', {params : {token : token, dateRange : dateRange.value}})
  .then(response => {
    if(response.data.success) {
      attendance.value = response.data.employee_attendance
    }
  })
}


watch(dateRange, () => {
  if(dateRange.value == '') {
    getAttendance()
  }
})

onMounted(() => {
  getAttendance()
})

</script>

<template>
    <VContainer>
      <ul>
        <li>
          <VBtn size="small" variant="text" link to="/sidebarlayout/manage/manage"><span>Manage Team</span></VBtn>
          / Team Attendance
        </li>
      </ul>
         <VCard>
            <VCardTitle class="headline">
                Team Attendance
            </VCardTitle>
            <VDivider />
            <VCardText>
                <VRow>
                    <VCol cols="6" offset="2">
                      <AppDateTimePicker
                        v-model="dateRange"
                        label="Select Date Range"
                        :config="{ mode: 'range' }"
                      />
                    </VCol>
                    <v-col cols="4">
                        <v-btn color="primary" @click="getAttendance">Generate</v-btn>
                    </v-col>
                </VRow>
            </VCardText>
            <VCard>
                <VTable>
                    <thead>
                        <tr>
                            <td>
                                Name
                            </td>
                            <td>
                                Days Present
                            </td>
                            <td>
                                Days Absent
                            </td>
                            <td>
                                Late Minutes
                            </td>
                            <td>
                                Undertime Minutes
                            </td>
                            <td>
                                Total Late / Undertime Min.
                            </td>
                            <td>
                                Total Hours
                            </td>
                        </tr>
                    </thead>
                    <tbody v-for="row in attendance" :key="row">
                      <tr>
                        <td>{{ row.employee.first_name }} {{ row.employee.middle_name }} {{ row.employee.last_name }}</td>
                        <td >{{ moment(row.login).format('MMMM DD, YYYY') }}</td>
                        <td class="text-center" >{{ row.absent_days[0] }}</td>
                        <td class="text-center" >{{ moment(row.diffInSeconds, 'mm').format('mm') }} minutes</td>
                        <td class="text-center" >{{ moment(row.underTime, 'mm').format('mm')}} minutes</td>
                        <td class="text-center" >{{ moment(row.totalTodif, 'mm').format('mm')}} minutes</td>
                        <td class="text-center" >{{ moment(row.totalHrs, 'hh').format('hh')}} hours</td>
                      </tr>
                    </tbody>
                </VTable>
            </VCard>
        </VCard>
    </VContainer>
</template>
