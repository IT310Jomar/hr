<script setup lang="ts">
import AppDateTimePicker from '@core/components/AppDateTimePicker.vue'
import printOvertime from '@/pages/admin/tool/Overtime/print-overtime-list.vue'
import axios from 'axios';
import { formatDate } from '@/helper';
import { exportToExcel2 } from '@/excell2';
import { generatePdf2 } from '@/pdf2';
import { environment } from '@/environments/environment';

const searchQuery = ref(null)
const overtimeData = ref('');
const perPages = [5, 10, 20, 50, 100, 500, "All"];
const itemsPerPage = ref(perPages[0]);
const selectedPerPage = ref(itemsPerPage.value);
const rowPerPage = ref('5');
const currentPage = ref(1);
const printTable = ref(false);
const tableRef = ref();
const loading = ref(false);
const dateRange = ref(null);
const startDate = ref();
const endDate = ref();

const getOvertime = () => {
  axios.get(environment.API_URL +'user/employees/overtime_request')
    .then(response => {
      if (response.data.success) {
        overtimeData.value = response.data.overtime
      }
    })
}

// for pagination function
const paginatedovertimeData = computed(() => {
  if (overtimeData.value != null) {
    const datalogs = []
    datalogs.push(overtimeData.value)
    const startIndex = (currentPage.value - 1) * itemsPerPage
    const endIndex = startIndex + itemsPerPage
    return datalogs[0].slice(startIndex, endIndex)
  }
})

//function for print
const print = () => {
  printTable.value = true;
  if (printTable.value == true) {
    setTimeout(() => {
      window.print();
    }, 100); // Add a delay of 100 milliseconds
  }
  window.addEventListener('beforeprint', () => {
    // The print dialog is about to be displayed
  });
  window.addEventListener('afterprint', () => {
    // The print dialog has been closed
    printTable.value = false;
  });
}

//search Overtime
const search = () => {
  loading.value = true;
  axios.get(environment.API_URL +'user/overtimelist/search', {
    params: {
      query: searchQuery.value
    }
  })
    .then((response) => {
      if (response.data.success) {
        overtimeData.value = response.data.overtimeSearch
      }
    })
}

//Function for searching daterange
const searchRange = () => {
  if (dateRange.value != null) {
    const d: string[] = []
    d.push(dateRange.value)
    const range = d[0].split(' to ')
    axios.get(environment.API_URL +'user/overtime/searchRange', {
      params: {
        startDate: startDate.value = range[0],
        endDate: endDate.value = range[1],
      }
    })
      .then((response) => {
        console.log(response.data)
        if (response.data.success) {
          dateRange.value = null
          overtimeData.value = response.data.overtimeRange
        }
      })
  }
}

//function for changing the number of pages
function itemPerPage(selectedPerPageValue: number | string) {
    if (selectedPerPageValue === "All") {
        itemsPerPage.value = Number.MAX_SAFE_INTEGER; // set to a large number
        currentPage.value = 1;
    } else {
        const index = perPages.indexOf(selectedPerPageValue);

        if (index !== -1) {
            itemsPerPage.value = perPages[index];
            currentPage.value = 1;
        } else {
            console.log('Error: Invalid selectedPerPageValue');
        }
    }
}

function onChangeSelectedPerPage(selectedValue: number | string) {
  itemPerPage(selectedValue);
}

watch(searchQuery, () => {
  search()
})

onMounted(() => {
  initializeData();
});

const initializeData = () => {
  getOvertime();
}
</script>

<template>
  <section>
    <VCard>
      <VToolbar color="primary" title="Overtime Report" class="headline">

      </VToolbar>
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
      <VDivider />

      <VCardText class="d-flex flex-wrap py-4 px-4 gap-2">
        <div class="me-3" style="width: 10.5rem; display:flex; align-items:center;">
          <v-label style="font-size: small;" class="mr-1"><strong>Show</strong></v-label>
          <v-select
            v-model="rowPerPage"
            :items="perPages" item-value="itemsPerPage" item-title="selectedPerPage" @update:modelValue="onChangeSelectedPerPage">
          </v-select>
          <v-label style="font-size: small;" class="ml-1"><strong>entries</strong></v-label>
        </div>
        <v-spacer />
        <!-- 👉 Excel -->
        <VBtn @click="exportToExcel2(tableRef)">
          Excel
        </VBtn>

        <!-- 👉 PDF -->
        <VBtn @click="generatePdf2(tableRef)">
          PDF
        </VBtn>

        <!-- 👉 Print -->
        <VBtn @click="print">
          Print
        </VBtn>
        <v-spacer />
        <div class="app-user-search-filter d-flex align-center flex-wrap gap-4 justify-end">

          <!-- 👉 Search  -->
          <div style="width: 17rem; display:flex; align-items:center;">
            <v-label class="mr-2">Search:</v-label>
            <VTextField v-model="searchQuery" placeholder="Search" density="compact" />
          </div>

        </div>
      </VCardText>
      <VDivider class="mb-5" />
      <VTable class="px-5 mb-5" ref="tableRef">
        <thead>
          <tr>
            <th class="text-center">Employe ID</th>
            <th class="text-center">Full Name</th>
            <th class="text-center">Day</th>
            <th class="text-center">Shift Date</th>
            <th class="text-center">Shift From</th>
            <th class="text-center">Shift To</th>
            <th class="text-center">OT Start</th>
            <th class="text-center">OT End</th>
            <th class="text-center">Date Approved</th>
          </tr>
        </thead>
        <tbody v-if="paginatedovertimeData != ''">
          <tr v-for="(data, index) in paginatedovertimeData" :key="data">
            <td class="text-center">{{ data.id }}</td>
            <td class="text-center">
              {{ data.employee.first_name }}
              {{ data.employee.middle_name }}
              {{ data.employee.last_name }}
            </td>
            <td class="text-center">{{ data.day }}</td>
            <td class="text-center">{{ formatDate(data.shift_date) }}</td>
            <td class="text-center">{{ data.shift_from }}</td>
            <td class="text-center">{{ data.shift_to }}</td>
            <td class="text-center">{{ data.start }}</td>
            <td class="text-center">{{ data.end }}</td>
            <td class="text-center">{{ formatDate(data.updated_at) }}</td>
          </tr>
        </tbody>
        <!-- 👉 table footer  -->
        <tfoot v-else>
          <tr>
            <td colspan="9" class="text-center py-10">
              Nothing to see here
            </td>
          </tr>
        </tfoot>
      </VTable>
    </VCard>
    <VDialog fullscreen v-model="printTable" transition="dialog-bottom-transition">
      <printOvertime :Data="paginatedovertimeData" />
    </VDialog>
  </section>
</template>

