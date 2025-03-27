<script setup lang="ts">
import AppDateTimePicker from '@core/components/AppDateTimePicker.vue'
import axios from 'axios';
import { initialize } from 'esbuild';
import { formatDate } from '@/helper';
import { environment } from '@/environments/environment';

const dateRange = ref(null);
const leaveData = ref('');
const items = [1, 2, 3, 15, 50, 75, 100, 500];
const itemsPerPage = 10;
const rowPerPage = ref(25);
const currentPage = ref(1);
const startDate = ref();
const endDate = ref();

const getLeave = () => {
  axios.get(environment.API_URL +'user/employees/leave_report')
    .then(response => {
      if (response.data.success) {
        leaveData.value = response.data.leave
      }
    })
}
//Function for searching daterange
const searchRange = () => {
  if (dateRange.value != null) {
    const d: string[] = []
    d.push(dateRange.value)
    const range = d[0].split(' to ')
    axios.get(environment.API_URL +'user/leave/searchRange', {
      params: {
        startDate: startDate.value = range[0],
        endDate: endDate.value = range[1],
      }
    })
      .then((response) => {
        if (response.data.success) {
          dateRange.value = null
          leaveData.value = response.data.leaveRange
          console.log(leaveData.value)
        }
      })
  }
}

const paginatedleaveData = computed(() => {
  if (leaveData.value != null) {
    const datalogs = []
    datalogs.push(leaveData.value)
    const startIndex = (currentPage.value - 1) * itemsPerPage
    const endIndex = startIndex + itemsPerPage
    return datalogs[0].slice(startIndex, endIndex)
  }
})

onMounted(() => {
  initializeData();
});

const initializeData = () => {
  getLeave();
}
</script>

<template>
  <section>
    <VCard>
      <VToolbar color="primary" title="Leave Report" class="headline"></VToolbar>
      <VDivider />
      <VCardText class="mb-3">
        <VRow>
          <VCol cols="6" offset="2" style="display:flex; align-items:center; margin-left: 25%;">
            <AppDateTimePicker label="Date Range" v-model="dateRange" :config="{ mode: 'range' }" />
            <VBtn @click.prevent="searchRange" class="ml-2">Search</VBtn>
          </VCol>
        </VRow>
        <hr class="mt-10" />
      </VCardText>
      <VTable class="px-2 mb-5">
        <thead>
          <tr>
            <th class="text-center">Employe ID</th>
            <th class="text-center">Full Name</th>
            <th class="text-center">Department</th>
            <th class="text-center">Date From - To</th>
            <th class="text-center">Leave Days</th>
            <th class="text-center">Leave Type</th>
            <th class="text-center">Date Approved</th>
          </tr>
        </thead>
        <tbody v-if="paginatedleaveData != ''">
          <tr v-for="(data, index) in paginatedleaveData" :key="data">
            <td class="text-center">{{ data.id }}</td>
            <td class="text-center">
              {{ data.employee.first_name }}
              {{ data.employee.middle_name }}
              {{ data.employee.last_name }}
            </td>
            <td class="text-center">{{ data.employee.employments.departments.name }}</td>
            <td class="text-center">
              {{ formatDate(data.date_from) }} - {{ formatDate(data.date_to) }}
            </td>
            <td class="text-center">{{ data.leaveDays }}</td>
            <td class="text-center">{{ data.leave_type }}</td>
            <td class="text-center">{{ formatDate(data.updated_at) }}</td>
          </tr>
        </tbody>
        <tfoot v-else>
          <tr>
            <td colspan="8" class="text-center py-10">
              Nothing to see here
            </td>
          </tr>
        </tfoot>
      </VTable>
    </VCard>
  </section>
</template>
