<script setup lang="ts">
import AppDateTimePicker from '@core/components/AppDateTimePicker.vue'
import AddAttendance from '@/pages/admin/tool/Attendance/attendance-dialog/add-attendance.vue'
import EditAttendance from '@/pages/admin/tool/Attendance/attendance-dialog/edit-attendance.vue'
import printLogs from '@/pages/admin/tool/Attendance/attendance-dialog/print-attendance.vue'
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { exportToExcel } from '@/excell';
import { generatePdf } from '@/pdf';
import moment from 'moment';
import PasswordGenerator from 'password-generator';
import { environment } from '@/environments/environment';

const attendanceData = ref();
const perPages = [5, 10, 20, 50, 100, 500, "All"];
const itemsPerPage = ref(perPages[0]);
const selectedPerPage = ref(itemsPerPage.value);
const rowPerPage = ref('5');
const currentPage = ref(1);
const attendanceLogs = ref();
const openLogsDialog = ref(false)
const dataValues = ref();
const employee = ref();
const logId = ref();
const editdialog = ref(false);
const logsData = ref();
const tableRef = ref();
const printTable = ref(false);
const startDate = ref();
const endDate = ref();
const searchQuery = ref();
const dateRange = ref(null);

//get employee id
const getData = () => {
  axios.get(environment.API_URL +'user/attendance/view')
    .then((response) => {
      if (response.data.success) {
        attendanceData.value = response.data.attendance_view
      }
    }).catch(error => {
      console.log(error);
    })
}
//get employee data in the table
const getDataLogs = () => {
  axios.get(environment.API_URL +'user/attendancelogs/view')
    .then((response) => {
      if (response.data.success) {
        attendanceLogs.value = response.data.attendanceLogs
      }
    })
}
//get employee value and item
const getEmployee = () => {
  axios.get(environment.API_URL +'user/employees/get-employee-data')
    .then((response) => {
      // Get Employee
      if (response.data.success) {
        employee.value = response.data.attendance_view
        if (response.data.attendance_view) {
          const employeedata = [];
          for (var x = 0; x < response.data.attendance_view.length; x++) {
            let data = response.data.attendance_view[x].first_name + " " + response.data.attendance_view[x].last_name + " " + response.data.attendance_view[x].middle_name
            const employ = {
              item: data,
              value: response.data.attendance_view[x].id
              
            }
            employeedata.push(employ)
          }
          employee.value = employeedata
        }
      }
    }).catch((error) => {
      console.log('error')
    })
}
const handleSubmit = () => {
  getData();
  getDataLogs();
  getEmployee();
  search();
};
onMounted(() => {
  handleSubmit()
})

//submits employee data
const onSubmit = () => {
  axios.post(environment.API_URL +'user/attendancecreate/store', {
    dataValues: dataValues.value
  }).then((response) => {
    if (response.data.success) {
      handleSubmit()
    }
  }).catch((error) => {
    console.log('error')
  })
}
//open dialog for Add-attendance
const openDialog = () => {
  openLogsDialog.value = true;
}
//open dialog for Edit-attendance
const openEditdialog = (data: any, id: any) => {
  editdialog.value = true
  logsData.value = data
  logId.value = id
}
const handlesData = (values: any) => {
  dataValues.value = values;
}

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

//Function for searching daterange
const searchRange = () => {
  if (dateRange.value != null) {
    const d: string[] = []
    d.push(dateRange.value)
    const range = d[0].split(' to ')
    axios.get(environment.API_URL +'user/attendance/searchRange', {
      params: {
        startDate: startDate.value = range[0],
        endDate: endDate.value = range[1],
      }
    })
      .then((response) => {
        if (response.data.success) {
          dateRange.value = null
          attendanceLogs.value = response.data.attendanceLogs
        }
      })
  }
}

//watch the input data in searchQuery and then calls the search()
watch(searchQuery, () => {
  search()
})
//function for search
const search = () => {
  axios.get(environment.API_URL +'user/attendance/search', {
    params: {
      dataSearch: searchQuery.value
    }
  })
    .then((response) => {
      if (response.data.success) {
        attendanceLogs.value = response.data.attendanceLogs
      }
    })
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

</script>

<template>
  <section>
    <VCard>
      <VCardTitle class="py-8">
        Attendance Management
        <VRow>
          <VCol class="d-flex justify-end" style="margin-top: -2%;">
            <VBtn @click.prevent="openDialog">Add New Log</VBtn>
          </VCol>
        </VRow>
        <hr class="mt-5 " />
      </VCardTitle>
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
        <VBtn @click="exportToExcel(tableRef)">
          Excel
        </VBtn>

        <!-- 👉 PDF -->
        <VBtn @click="generatePdf(tableRef)">
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
            <th class="text-center">Employee ID</th>
            <th class="text-center">Full Name</th>
            <th class="text-center">Log In</th>
            <th class="text-center">Log Out</th>
            <th class="text-center">Total Hours</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody v-if="attendanceLogs != ''">
          <tr v-for="(data) in attendanceLogs" :key="data">
            <td class="text-center">{{ data.employee_id }}</td>
            <td class="text-center" >
              {{ data.employee.first_name }}
              {{ data.employee.middle_name }}
              {{ data.employee.last_name }}
            </td>
            <td>
              <ul style="min-width: 130px; width: 220px;">
                <span>
                  <VChip  color="success" label class="mb-1 mt-1">
                    Login Date:
                  </VChip>
                  {{  moment(data.login).format('MMMM DD, YYYY')  }}
                </span> 
              </ul>
              <ul>
                <VChip color="info" label>
                  Login Time:
                </VChip>
                {{ moment(data.timeIn, 'hh:mm A').format('hh:mm A')}}
              </ul>
            </td>
            <td>
              <ul style="min-width: 130px; width: 230px;">
                <VChip color="error" label class="mb-1 mt-1">
                  Logout Date:
                </VChip>
                {{  moment(data.logout).format('MMMM DD, YYYY') }}
              </ul>
              <ul>
                <VChip color="warning" label>
                  Logout Time:
                </VChip>
                {{ moment(data.timeOut, 'hh:mm A').format('hh:mm A') }}
              </ul>
            </td>
            <td class="text-center">{{ data.totalHours }}</td>
            <td class="text-center width: 10rem;">
              <VMenu open-on-hover activator="parent">
                <template v-slot:activator="{ props }">
                  <VBtn size="x-small" color="warning" prepend-icon="tabler-edit" v-bind="props"
                    @click.prevent="openEditdialog(data, data.id)">
                  </VBtn>
                </template>
              </VMenu>
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
    <VDialog v-model="openLogsDialog" max-width="600" max-height="600" class="scrollable-content" persistent :z-index="1051">
      <AddAttendance :employee="employee" :isDialogSubmit="onSubmit" @submitted="handleSubmit"
        :attendanceData="attendanceData" @close="openLogsDialog = false" @dataValues="handlesData" />
    </VDialog>
    <VDialog scrollable v-model="editdialog" max-width="600" persistent :z-index="1051">
      <EditAttendance :id="logId" :employee="employee" @close="editdialog = false" @updated="handleSubmit"
        :data="logsData" :attendanceLogs="attendanceLogs"/>
    </VDialog>
    <VDialog fullscreen v-model="printTable" transition="dialog-bottom-transition">
      <printLogs :Data="attendanceLogs" />
    </VDialog>
  </section>
</template>

