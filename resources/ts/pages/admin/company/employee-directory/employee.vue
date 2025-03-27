<script setup lang="ts">
import EditEmployeeDialog from '@/pages/admin/company/employee-directory/edit-employee.vue'
import employee_info from '@/pages/admin/company/employee-directory/add-employee.vue';
import { formatDate } from '@/helper';
import { debounce } from 'lodash';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import type { VForm } from 'vuetify/components'
import { emailValidator, requiredValidator } from '@validators'

type FormSubmittedEvent = (value: boolean) => void;
interface Emit {
  (e: 'submitted', callback: FormSubmittedEvent): void;
}

const isDialogVisible = ref(false)
const refForm = ref<VForm>()
const emit = defineEmits<Emit>()
const isFormValid = ref(false)

const isEditEmployeeVisible = ref(false)
const perPages = [5, 10, 20, 50, 100, 500, 'All']
const itemsPerPage = ref(perPages[0])
const selectedPerPage = ref(itemsPerPage.value)
const selected = ref('5')
const successEdit = ref(false)
const employeesInfo = ref('');
const employeeData = ref(['']);
const rowPerPage = ref(10);
const currentPage = ref(1);
const currentSearchPage = ref(1);
const searchQuery = ref(null);
const employeesInfoData = ref('')
const itemsPerPageSearch = 10;
const loading = ref(false);
const gendervalue = ref();
const employee_name = ref(null)
const position = ref('')
const department = ref('')
const gender = ref('')

const emData = ref('')

// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = employeesInfo.value.length ? ((currentPage.value - 1) * itemsPerPage.value) + 1 : 0
  const lastIndex = itemsPerPage.value + ((currentPage.value - 1) * itemsPerPage.value)

  return `Showing ${firstIndex} to ${lastIndex} of ${employeesInfo.value.length} entries`
})

const paginatedData = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage.value
  const endIndex = startIndex + itemsPerPage.value
  return employeesInfo.value.slice(startIndex, endIndex)
})

let totalPages = computed(() => {
  if (employeesInfo.value.length > 0) {
    return Math.ceil(employeesInfo.value.length / itemsPerPage.value)
  } else {
    return 0
  }
})

const getEmployee = () => {
  axios.get('/api/user/employees/getEmployee')
    .then(response => {
      if (response.data.success) {
        emit('submitted', response.data.success);
        employeesInfo.value = response.data.employees
        // console.log(employeesInfo.value)
      }

    }).catch(error => {
      console.log(error);
    })
}

const def = ref([{ item: '--Select Departments--', value: null }])
const user_level = ref([{ item: '--Select Position--', value: null }])

const getUserLevel = () => {
  axios.get('/api/user/employees/getEmploymentOptions')
    .then((response) => {
      // User levels
      if (response.data.success) {
        if (response.data.levels) {
          for (var x = 1; x < response.data.levels.length; x++) {
            user_level.value.push(
              {
                item: response.data.levels[x].name,
                value: response.data.levels[x].id
              }
            )
          }
        }
      }
    })
}

const getDepartment = () => {
  axios.get('/api/user/employees/getEmploymentOptions')
    .then((response) => {
      // departments
      if (response.data.success) {
        if (response.data.departments) {
          for (var x = 0; x < response.data.departments.length; x++) {
            def.value.push(
              {
                item: response.data.departments[x].name,
                value: response.data.departments[x].id
              }
            )
          }
        }
      }
    })
}

const getSearchEmployee = () => {
  axios.get('/api/user/employees/getEmployee')
    .then(response => {
      if (response.data.success) {
        emit('submitted', response.data.success);
        employeeData.value = response.data.employees
        // console.log(employeeData.value)
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

const EditEmployeeForm = (employeesData: any) => {
    emData.value = employeesData
    isEditEmployeeVisible.value = true
  }

  const closedFormEditDialog = () => {
    isEditEmployeeVisible.value = false
    initializeData()
  }

  function successEditEmployee() {
    isEditEmployeeVisible.value = false
    initializeData()
    successEdit.value = false
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
const estatus = ref([{ item: '--Select Employment Status--', value: null }])

const getTStatus = () => {
  axios.get('/api/user/tax_statuses/view').then((response) => {
    tstatus.value = response.data
  })
}

const getEStatus = () => {
  axios.get('/api/user/employees/getEmploymentOptions')
    .then((response) => {
      // EmPLOYMENT status
      if (response.data.success) {
        if (response.data.employment_statuses) {
          for (var x = 0; x < response.data.employment_statuses.length; x++) {
            estatus.value.push(
              {
                item: response.data.employment_statuses[x].name,
                value: response.data.employment_statuses[x].id
              }
            )
          }
        }
      }
    })
}

//government info

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
}//end of function

// for changing the item per page
function onChangeSelectedPerPage(selectedValue: number) {
  itemPerPage(selectedValue);
}

//  function for getting all data search for Employee Directory
const searchEmployee_directory = () => {
    axios.get('/api/user/employee_directory/search', {
        params: {
            query: searchQuery.value
        }

    }).then(response => {
      if (response.data.success) {
        employeesInfo.value = response.data.employee_directory
      }
    }).catch(error => {
        console.log('Error')
    })
};

watch(searchQuery, debounce(() => {
  searchEmployee_directory();
},500));

//onmounted
// 👉 Fetching
onMounted(() => {
  getTStatus();
  initializeData();
  getEStatus();
  getDepartment();
  getUserLevel();
});

const initializeData = () => {
    getEmployee();
    getSearchEmployee();
  }
    //onmounted end
</script>

<template>
  <section>
    <VCard title="Employee Directory" class="mt-2">

      <VDivider />

      <VCardText class="d-flex flex-wrap py-4 gap-4">
        <div class="me-3" style="width: 80px;">
          <v-select
            v-model="selected"
            :items="perPages" item-value="itemsPerPage" item-title="selectedPerPage" @update:modelValue="onChangeSelectedPerPage">
          </v-select>
        </div>

        <VSpacer />

        <div class="app-employeesInfo-search-filter d-flex align-center flex-wrap gap-4 justify-end">


          <div style="width: 15rem;">
            <VTextField v-model="searchQuery" placeholder="Search" density="compact" />
          </div>


          
          <VListItem @click="AddEmployeeForm" icon size="x-small" color="primary" varient="text">
            <template #prepend>
              <VIcon class="me-2" icon="tabler-plus" size="18" />
            </template>
            <VListItemTitle style="font-size: small">Add Employee</VListItemTitle>
          </VListItem>
        </div>
      </VCardText>


      <VTable class="text-no-wrap px-5 mb-5">

        <thead>
          <tr>
            <th scope="col">
              Employee ID
            </th>
            <th scope="col">
              Full Name
            </th>
            <th scope="col">
              Department
            </th>
            <th scope="col">
              Gender
            </th>

            <th scope="col">
              Actions
            </th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(data) in paginatedData" :key="data" style="height: 3.75rem;">

            <td>
              {{ data.id }}
            </td>

            <td>
              {{ data.first_name }} {{ data.middle_name }} {{ data.last_name }}
            </td>

            <td>
              <span v-if="data.employments != null">{{ data.employments.departments.name }}</span>
            </td>

            <td>
              {{ data.gender }}
            </td>

            <td>
              <VBtn icon size="x-small" color="default" variant="text">
                <VIcon size="22" icon="tabler-dots-vertical" />
                <VMenu activator="parent">
                  <VList>
                    <VListItem title="View Profile" 
                      :to="'/admin/company/employee-directory/viewProfileEmployee/' + data.id"/>
                    <VListItem title="Edit Profile" 
                      @click="EditEmployeeForm(data)" />
                    <VListItem title="Disable Account" />
                  </VList>
                </VMenu>
              </VBtn>
            </td>
          </tr>
        </tbody>

        <tfoot v-if="paginatedData?.length == 0">
          <tr>
            <td colspan="7" class="text-center">
              No data available
            </td>
          </tr>
        </tfoot>
      </VTable>

      <VCardText class="d-flex align-center flex-wrap justify-space-between gap-4 py-3 px-5">
        <span class="text-sm text-disabled">
          {{ paginationData }}
        </span>

        <VPagination v-model="currentPage" size="small" :total-visible="5" :length="totalPages" />
      </VCardText>
    </VCard>

    <VDialog
    scrollable
    v-model="isDialogVisible"
    width="120vh"
    >
    <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />
        <!-- 👉 Add employeesInfo button -->
    <employee_info @employee-submitted="initializeData" @errorAddEmployee="errorAddEmployee" :employeesData="emData" :tstatus="tstatus" @get-ID="getID_Stype"
      @AddEmployee="successAddEmployee" @closeDialog="closedFormAddDialog" :getID="getID" />

    </VDialog>

    <VDialog
    scrollable
    v-model="isEditEmployeeVisible"
    width="120vh"
    >
    <DialogCloseBtn @click="isEditEmployeeVisible = !isEditEmployeeVisible" />
        <!-- 👉 Edit employeesInfo button -->
    <EditEmployeeDialog :employeesData="emData" @errorAddEmployee="errorAddEmployee" @editEmployeeDetail="successEditEmployee" @closeDialog="closedFormEditDialog" />

    </VDialog>

    <VSnackbar
      v-model="successAdd"
      :timeout="2000"
      variant="flat"
      color="success"
    >
      <VIcon>mdi-check-bold</VIcon>&nbsp; Successfully Added record
    </VSnackbar>

    <VSnackbar
      v-model="successEdit"
      :timeout="2000"
      variant="flat"
      color="success"
    >
      <VIcon>mdi-check-bold</VIcon>&nbsp; Successfully updated record
    </VSnackbar>

    <VSnackbar
      v-model="errorEdit"
      :timeout="2000"
      variant="flat"
      color="error"
    >
      <VIcon>mdi-alert-circle-outline</VIcon>&nbsp; Oops! Please check your fields!
    </VSnackbar>

  </section>
</template>
