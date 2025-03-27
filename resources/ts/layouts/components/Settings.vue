<script setup lang="ts">
import avatar1 from '@images/avatars/avatar-2.png'
import employee_info from '@/pages/admin/company/employee-directory/add-employee.vue';
import { formatDate } from '@/helper';
import { debounce } from 'lodash';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import type { VForm } from 'vuetify/components'
import { emailValidator, requiredValidator } from '@validators'

const isDialogVisible = ref(false)
const refForm = ref<VForm>()
const isFormValid = ref(false)

const isEditEmployeeVisible = ref(false)
const successEdit = ref(false)
const employeesInfo = ref('');
const rowPerPage = ref(10);
const currentPage = ref(1);
const searchQuery = ref(null);
const employeesInfoData = ref('')
const itemsPerPage = 10;
const loading = ref(false);

const employee_name = ref('')
const position = ref('')
const department = ref('')
const selectedOption = ref('')
const employeesInfotatus = ref('')
const company = ref('')
// const department = ref('')
const searchsort = ref('')
const emData = ref('')


// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = employeesInfo.value.length ? ((currentPage.value - 1) * itemsPerPage) + 1 : 0
  const lastIndex = itemsPerPage + ((currentPage.value - 1) * itemsPerPage)

  return `Showing ${firstIndex} to ${lastIndex} of ${employeesInfo.value.length} entries`
})

const paginatedData = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage
  const endIndex = startIndex + itemsPerPage
  return employeesInfo.value.slice(startIndex, endIndex)
})

let totalPages = computed(() => {
  if (employeesInfo.value.length > 0) {
    return Math.ceil(employeesInfo.value.length / itemsPerPage)
  } else {
    return 0
  }
})

const getEmployee = () => {
  axios.get('/api/user/employees/getEmployee')
    .then(response => {
      if (response.data.success) {
        employeesInfo.value = response.data.employees
        // console.log(employeesInfo.value)
      }

    }).catch(error => {
      console.log(error);
    })
}

//work information
const getID = ref([''])

const getID_Stype = (id: any) => {
  axios.get(`/api/user/schedule_config/getID/${id}`)
    .then((response) => {
      if (response.data.success) {
        getID.value = response.data.getID
        // console.log(getID.value)
      }
    })
}

const AddEmployeeForm = () => {
  isDialogVisible.value = true
}

  const closedFormAddDialog = () => {
    isDialogVisible.value = false
    initializeData()
  }
  
  const successAdd = ref(false)
  function successAddEmployee() {
    isDialogVisible.value = false
    initializeData()
    successAdd.value = false
  }

  const errorEdit = ref(false)
  function errorAddEmployee() {
    isEditEmployeeVisible.value = false
    initializeData()
    errorEdit.value = true
  }

//work info end

//government info
const tstatus = ref([''])

const getTStatus = () => {
  axios.get('/api/user/tax_statuses/view').then((response) => {
    tstatus.value = response.data
  })
}
//government info

//onmounted
// 👉 Fetching
onMounted(() => {
  getTStatus();
  initializeData();
});

const initializeData = () => {
    getEmployee()
  }
    //onmounted end

  const userRole = JSON.parse(localStorage.getItem('userRole') || 'null')

</script>

<template>
  <VBadge
    dot
    location="bottom right"
    offset-x="3"
    offset-y="3"
    bordered
    color="success"
    class="mr-5 ml-3"
  >
  
  <VBtn
    variant="text"
    color="default"
    icon
    size="x-small"
  >
    <VIcon
      size="24"
      icon="tabler-settings"
    />

      <!-- SECTION Menu -->
      <VMenu
        activator="parent"
        width="258"
        location="bottom end"
        offset="15px"
      >
        <VList>
          <!-- 👉 Add Employee -->

          <VListItem @click="AddEmployeeForm" icon size="x-small" color="primary" varient="text" v-if="userRole == 'God Mode' || userRole == 'Administrator'">
            <template #prepend>
              <VIcon class="me-2" icon="tabler-plus" size="18" />
            </template>
            <VListItemTitle style="font-size: 15px">Add Employee</VListItemTitle>
          </VListItem>

          <!-- 👉 Incident Report -->
          <VListItem link to="/admin/tool/incident/incident-report" v-if="userRole == 'God Mode' || userRole == 'Administrator'">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-alert-triangle"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Incident Report</VListItemTitle>
          </VListItem>

          <!-- 👉 Leave Report -->
          <VListItem link to="/admin/tool/Leave/leave-report" v-if="userRole == 'God Mode' || userRole == 'Administrator'">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-road-sign"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Leave Report</VListItemTitle>
          </VListItem>

          <!-- 👉 Request Approval -->
          <VListItem link to="/admin/tool/Request/approval" v-if="userRole == 'God Mode' || userRole == 'Administrator' || userRole == 'Supervisor / Manager'">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-check"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Request Approval</VListItemTitle>
          </VListItem>

          <!-- 👉 Overtime Report -->
          <VListItem link to="/admin/tool/Overtime/overtime-report" v-if="userRole == 'God Mode' || userRole == 'Administrator'">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-brand-days-counter"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Overtime Report</VListItemTitle>
          </VListItem>

          <!-- 👉 Undertime Report -->
          <VListItem link to="/admin/tool/Undertime/undertime-report" v-if="userRole == 'God Mode' || userRole == 'Administrator'">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-clock-2"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Undertime Report</VListItemTitle>
          </VListItem>

          <!-- 👉 Memo -->
          <VListItem link to="/admin/tool/Memo/memo-search" v-if="userRole == 'God Mode' || userRole == 'Administrator'">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-zoom-exclamation"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Memo</VListItemTitle>
          </VListItem>

          <!-- 👉 Employee List Report -->
          <VListItem link to="/admin/tool/EmployeeList/employee-report" v-if="userRole == 'God Mode' || userRole == 'Administrator'">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-checklist"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Employee List Report</VListItemTitle>
          </VListItem>

          <!-- 👉 Attendance Management -->
          <VListItem link to="/admin/tool/Attendance/attendance-manage" v-if="userRole == 'God Mode' || userRole == 'Administrator'">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-clipboard-check"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Attendance Management</VListItemTitle>
          </VListItem>

          <!-- 👉 Shift Schedule -->
          <VListItem link to="/admin/tool/ShiftSchedule/shift-schedule" v-if="userRole == 'God Mode' || userRole == 'Administrator'">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-calendar-time"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Shift Schedule</VListItemTitle>
          </VListItem>

          <!-- 👉 Email Blast -->
          <VListItem link to="/admin/tool/Email/email-blast" v-if="userRole == 'God Mode' || userRole == 'Administrator'">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-mail-fast"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Email Blast</VListItemTitle>
          </VListItem>
          
        </VList>
      </VMenu>
      <!-- !SECTION -->
    </VBtn>
  </VBadge>

  <VDialog
    scrollable
    v-model="isDialogVisible"
    width="120vh"
    >
    <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />
        <!-- 👉 Add employeesInfo button -->
    <employee_info @submitted="initializeData" @employee-submitted="initializeData" @errorAddEmployee="errorAddEmployee" :employeesData="emData" :tstatus="tstatus" @get-ID="getID_Stype"
      @AddEmployee="successAddEmployee" @closeDialog="closedFormAddDialog" :getID="getID" />

    </VDialog>

    <VSnackbar
      v-model="successAdd"
      :timeout="2000"
      variant="flat"
      color="success"
    >
      <VIcon>mdi-check-bold</VIcon>&nbsp; Successfully Added record
    </VSnackbar>
</template>
