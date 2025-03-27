<script setup lang="ts">
import printEmployee from '@/pages/admin/tool/EmployeeList/print-employee-list.vue'
import axios from 'axios';
import { exportToExcel2 } from '@/excell2';
import { generatePdf2 } from '@/pdf2';
import { debounce } from 'lodash'
import { environment } from '@/environments/environment';

const loading = ref(false);
const perPages = [5, 10, 20, 50, 100, 500, "All"];
const itemsPerPage = ref(perPages[0]);
const selectedPerPage = ref(itemsPerPage.value);
const rowPerPage = ref('5');
const currentPage = ref(1);
const searchQuery = ref(null);
const employeelistData = ref('');
const tableRef = ref();
const printTable = ref(false);

const getEmployee = () => {
  axios.get(environment.API_URL +'user/employees/getEmployee')
    .then(response => {
      if (response.data.success) {
        employeelistData.value = response.data.employees
      }
    }).catch(error => {
      console.log(error);
    })
}
// for pagination function
const paginatedData = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage.value
  const endIndex = startIndex + itemsPerPage.value
  return employeelistData.value.slice(startIndex, endIndex)
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

//search employee
const search = () => {
    loading.value = true;
    axios.get(environment.API_URL +'user/employeelist/search', {
      params: {
        query: searchQuery.value
      }
    })
  .then((response) => {
    if(response.data.success){
      employeelistData.value = response.data.employees
    }
  })
}

//watch the input data in searchQuery and then calls the search()
watch(searchQuery, () => {
  search()
})

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

onMounted(() => {
  initializeData();
});

const initializeData = () => {
  getEmployee();
}
</script>

<template>
  <section>
    <VCard>
      <VToolbar color="primary" title="Employee List Report" class="headline">
      </VToolbar>
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
      <VTable class="px-5 mb-7" ref="tableRef">
        <thead>
          <tr>
            <th style="min-width: 150px; width: auto;" class="text-center">
              Employee ID No
            </th>
            <th class="text-center">
              Full Name
            </th>
            <th class="text-center">
              Department
            </th>
            <th class="text-center">
              Title
            </th>
            <th class="text-center">
              Date Hired
            </th>
            <th class="text-center">
              Date Regularization
            </th>
            <th class="text-center">
              Status
            </th>
          </tr>
        </thead>
        <tbody v-if="paginatedData != ''">
          <tr v-for="(data, index) in paginatedData" :key="data">
            <td class="text-center">{{ data.id }}</td>
            <td style="min-width: 300px; width: auto;" class="text-center">
              {{ data.first_name }}
              {{ data.middle_name }}
              {{ data.last_name }}
            </td>
            <td style="min-width: 150px; width: auto;" class="text-center">{{ data.employments.departments.name }}</td>
            <td style="min-width: 300px; width: auto;" class="text-center">{{ data.employments.title }}</td>
            <td style="min-width: 150px; width: auto;" class="text-center">{{ data.employments.date_hired }}</td>
            <td style="min-width: 150px; width: auto;" class="text-center">{{ data.employments.date_regularization }}</td>
            <td style="min-width: 180px; width: auto;" class="text-center">{{ data.employments.employmentstatus.name }}
            </td>
          </tr>
        </tbody>
        <!-- 👉 table footer  -->
        <tfoot v-else>
          <tr>
            <td colspan="8" class="text-center py-10">
              Nothing to see here
            </td>
          </tr>
        </tfoot>
      </VTable>
    </VCard>
    <VDialog fullscreen v-model="printTable" transition="dialog-bottom-transition">
      <printEmployee :Data="paginatedData" />
    </VDialog>
  </section>
</template>
