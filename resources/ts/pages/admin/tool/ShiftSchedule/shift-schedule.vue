<script setup lang="ts">
import create_schedule from '@/pages/admin/tool/ShiftSchedule/CreateScheduleDialog/create_schedule.vue';
import update_schedule from '@/pages/admin/tool/ShiftSchedule/CreateScheduleDialog/update_schedule.vue';
import delete_schedule from '@/pages/admin/tool/ShiftSchedule/CreateScheduleDialog/delete_schedule.vue';
import axios from 'axios'
import { onMounted, ref } from 'vue';
import moment from 'moment';
import { environment } from '@/environments/environment';

const scheduleData = ref([])
const employeesData = ref()

const getEmployee = () => {
  axios.get(environment.API_URL +'user/employees/getEmployee')
    .then(response => {
      if (response.data.success) {
        employeesData.value = response.data.employees
        // console.log(employeesData.value)
      }

    }).catch(error => {
      console.log(error);
    })
}

const getData = () => {
  axios.get(environment.API_URL +'user/schedule_categories/getscheduledata')
    .then(response => {
      if (response.data.success) {
        scheduleData.value = response.data.schedule_categories
        // console.log( scheduleData.value )
      }
    }).catch(error => {
      console.log(error);
    })
};
const handleSubmit = () => {
  getData();
}; 
onMounted(() => {
  getData();
  getEmployee();
});

const dateRange = ref('')
const searchQuery = ref('')
</script>

<template>
  <section>
    <v-row>
      <v-col lg="7">
        <VCard>
          <VToolbar color="primary" title="Employee Schedule Lists"></VToolbar>
          <section v-if="employeesData?.length == 0" class="py-5">
            <p class="text-center">No record found.</p>
          </section>
          <section v-else>
            <VTable v-for="(row, index) in employeesData" class="px-5 mb-5" :key="row">
              <tr>
                <td colspan="9"><strong>{{ row.first_name }} {{ row.last_name }}</strong></td>
              </tr>
              <tr>
                <td style="min-width: 90px; width: 100px;" v-for="day in row.schedule" v-bind:class="{ 'text-warning': day.day === 'Saturday' || day.day === 'Sunday' }" :key="day" class="text-center">
                  {{ day.day }}
                </td>
              </tr>
              <tr v-show="!row.schedule?.length" >
                  <td colspan="8" class="text-center py-10">
                    No schedule yet
                  </td>
                </tr>

              <tr>
                <!-- <td>
                  <ul v-if="row.users.length > 0">
                    <li v-for="(user, index) in row.users" :key="user.id">{{ index + 1 + '. ' + user }}</li>
                  </ul>
                </td> -->
                <td width="auto" v-for="(start, index) in row.schedule" :key="start.id" class="text-center">
                  <small>
                    <span>
                        <VChip color="error" v-if="start.rest_day == 1" >
                          Rest Day
                        </VChip>  
                      <ul style="margin-bottom: -15%; min-width: 130px; width: 120px;">
                        <VChip color="success" label v-if="start.rest_day == 0">
                          Start:
                        </VChip>
                        <span v-if="start.rest_day == 0">
                          {{ moment(start.shift_start, 'hh:mm A').format('hh:mm A') }}
                        </span>
                      </ul>
                    </span><br/>
                    <span>
                      <VChip color="error" label v-if="start.rest_day == 0">
                        End:
                      </VChip>
                      <span style="min-width: 180px; width: auto;" v-if="start.rest_day == 0">
                        {{ moment(start.shift_end, 'hh:mm A').format('hh:mm A') }}
                      </span>
                    </span>
                  </small>
                </td>
              </tr>
              <tr>
                <td colspan="9">
                  <v-btn class="btn btn-primary btn-sm pull-right">
                    <v-icon center>mdi-printer n   </v-icon>Print Schedule
                  </v-btn>
                </td>
              </tr>
            </VTable>
          </section>
        </VCard>
      </v-col>
      <v-col lg="5">
        <VCard>
          <VToolbar color="defualt" style="font-size: small;" class="headline">
            <template v-slot:title>
              <div class="toolbar-title" style="font-size: 18px;">Create New Schedule</div>
            </template>
            <div class="d-flex align-items-center mr-1">
              <create_schedule @submitted="handleSubmit" />
            </div>
          </VToolbar>
          <VDivider class="mb-5" />
          <VTable class="px-5 mb-5">
            <tr>
              <th>
                Name
              </th>
              <th>
                Actions
              </th>
            </tr>
            <tbody>
              <tr v-for="(data, index) in scheduleData" :key="data" style="height: 3.75rem;">
                <!-- 👉 name -->
                <td>{{ data.name }}</td>

                <!-- 👉 Actions -->
                <td style="width: 15rem;">
                  <div class="d-flex gap-2 text-center">
                    <!-- 👉 update assest button -->
                    <update_schedule :scheduleData="scheduleData" :data="data" :id="data.id" />
                    <!-- 👉 delete assest button -->
                    <delete_schedule @deleted="handleSubmit" :data="data" />
                  </div>
                </td>
              </tr>
            </tbody>

            <!-- 👉 table footer  -->
            <tfoot v-show="!scheduleData.length">
              <tr>
                <td colspan="8" class="text-center py-10">
                  Nothing to see here
                </td>
              </tr>
            </tfoot>
          </VTable>
      </VCard>
    </v-col>
  </v-row>
</section>
</template>
