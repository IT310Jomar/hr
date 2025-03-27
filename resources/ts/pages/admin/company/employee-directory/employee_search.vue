<script setup lang="ts">
import axios from 'axios';
import { onMounted, ref } from 'vue';

type FormSubmittedEvent = (value: boolean) => void;
interface Emit {
  (e: 'submitted', callback: FormSubmittedEvent): void;
}
const emit = defineEmits<Emit>()

const employeesInfo = ref('');
const employeeData = ref(['']);
const currentSearchPage = ref(1);
const itemsPerPage = 10;
const itemsPerPageSearch = 10;
const employee_name = ref(null)
const position = ref('')
const department = ref('')
const gender = ref('')
const employeesInfotatus = ref('')
const company = ref([{ item: 'Specialized Outsource Partners, Inc.', value: 'Specialized Outsource Partners, Inc.' }])
// const department = ref('')
const searchsorta_d = ref()
const sortby_name_depart = ref()
const searchsortby = ref(
[ 
  { item: 'Name', value: 'last_name' }, 
  { item: 'Department', value: 'id'}
])
const sortby_asc_desc = ref(
[ 
  { item: 'Ascending', value: 'asc' }, 
  { item: 'Decending', value: 'desc'}
])

const emData = ref('')

// 👉 Computing pagination data 
const paginationDataSearchEmployee = computed(() => {
  const firstIndex = employeeData.value.length ? ((currentSearchPage.value - 1) * itemsPerPageSearch) + 1 : 0
  const lastIndex = itemsPerPageSearch + ((currentSearchPage.value - 1) * itemsPerPageSearch)

  return `Showing ${firstIndex} of ${employeeData.value.length}`
})

//SearchEmployee
let totalSearchPages = computed(() => {
  if (employeeData.value.length > 0) {
    return Math.ceil(employeeData.value.length / itemsPerPageSearch)
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


//search employee
const employee_search = () => {
    // loading.value = true;
    axios.get('/api/user/employees/employee-search', {
      params: {
        employee_name: employee_name.value,
        genders: gender.value,
        employeesInfotatus: employeesInfotatus.value,
        department: department.value,
        position: position.value,
        sortby_name_depart: sortby_name_depart.value,
        sortby_asc_desc: searchsorta_d.value
      }
    })
  .then((response) => {
    if(response.data){
      employeeData.value = response.data.employees;
      totalSearch.value = response.data.count;
    }
  })
}

const paginatedDataSearchEmployee = computed(() => {
  const startIndex = (currentSearchPage.value - 1) * itemsPerPageSearch
  const endIndex = startIndex + itemsPerPageSearch
  return employeeData.value.slice(startIndex, endIndex)
})

const totalSearch = ref();

const getSearch = () => {
  if (employee_name.value === '' && gender.value === '' && employeesInfotatus.value === '' && sortby_name_depart.value === '' && position.value === '' && searchsorta_d.value === '') {
    // Reset the data to the original values
    initializeData();
  } else {
    employee_search();
  }
};


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
    <VCard title="Employee Search">
      <VCardText>
        <VRow>
          <VCol cols="12" sm="6" md="4">
            <VTextField v-model="employee_name" label="Employee Name" />
          </VCol>
          <VCol cols="12" sm="6" md="4">
            <VSelect v-model="employeesInfotatus" :items="estatus" item-title="item"
              item-value="value" label="Employee Status" type="text" />
          </VCol>

          <VCol cols="12" sm="6" md="4" style="margin-top: -3%;">
            <VLabel>Gender</VLabel>
            <v-radio-group inline v-model="gender">
              <v-radio value="" label="All"></v-radio>
              <v-radio value="Male" label="Male"></v-radio>
              <v-radio value="Female" label="Female"></v-radio>
            </v-radio-group>
          </VCol>

          <VCol cols="12" sm="6" md="4">
            <VSelect v-model="company" :items="['Specialized Outsource Partners, Inc.']" item-title="item"
              item-value="value" label="Company" />
          </VCol>

          <VCol cols="12" sm="6" md="4">
            <VSelect v-model="department" :items="def" item-title="item"
              item-value="value" label="Department/ Line of Business" type="text" width="auto" />
          </VCol>

          <VCol cols="12" sm="6" md="4">
            <VSelect v-model="position" label="Position" type="text" :items="user_level" item-title="item"
              item-value="value">
            </VSelect>
          </VCol>

          <VCol cols="12" sm="6">
            <VSelect v-model="sortby_name_depart" :items="searchsortby" item-value="value" item-title="item" label="Sort by" />
          </VCol>
          <VCol cols="12" sm="6">
            <VSelect v-model="searchsorta_d" :items="sortby_asc_desc" item-value="value" item-title="item" label="Sort by" />
          </VCol>
        </VRow>
      </VCardText>

      <VCardText class="d-flex justify-end flex-wrap gap-3">
        <VBtn @click.prevent="getSearch">
          Search
        </VBtn>
      </VCardText>
      <VCardText v-if="totalSearch">
        <div class="col-12">
          <p>
            <strong>Search Results: {{ totalSearch }}</strong>
          </p>

        <VTable class="text-no-wrap px-5 mb-5">
          <!-- 👉 table head -->
          <thead>
            <tr>
              <th scope="col">
                Employee ID
              </th>
              <th scope="col">
                Full Name
              </th>
              <th scope="col">
                Gender
              </th>
              <th scope="col">
                Department
              </th>
              <th scope="col">
                Employment Status
              </th>
              <th scope="col">
                Position
              </th>
            </tr>
          </thead>
          <!-- 👉 table body -->
          <tbody>
            <tr v-for="(data, index) in paginatedDataSearchEmployee" :key="data" style="height: 3.75rem;">
              <!-- 👉 employee id -->
              <td>
                {{ data.id }}
              </td>

              <!-- 👉 full name of employee -->
              <td>
                {{ data.first_name }} {{ data.middle_name }} {{ data.last_name }}
              </td>

              <!-- 👉 gender -->
              <td>
                {{ data.gender }}
              </td>

              <!-- 👉 department -->
              <td>
                <span v-if="data.employments != null">{{ data.employments.departments.name }}</span>
              </td>

              <td>
                {{ data.employments.employmentstatus.name }}
              </td>

              <td>
                {{ data.employments.user.user_levels.name }}
              </td>

            </tr>
          </tbody>

          <!-- 👉 table footer  -->
          <tfoot v-if="paginatedDataSearchEmployee?.length == 0">
            <tr>
              <td colspan="7" class="text-center">
                No data available
              </td>
            </tr>
          </tfoot>
        </VTable>

          <div class="row mt-3"></div>
          <div class="separator mb-10"></div>

          <!-- <VDivider /> -->

          <VCardText class="d-flex align-center flex-wrap justify-space-between gap-4 py-3 px-5">
            <strong>
              {{ paginationDataSearchEmployee }}
            </strong>

            <VPagination v-model="currentSearchPage" size="small" :total-visible="5" :length="totalSearchPages" />
          </VCardText>

          <div class="clearfix"></div>
        </div>
      </VCardText>
      <v-card-text v-else>
        <p>
          <strong>Search Results: {{ totalSearch }}</strong>
        </p>
        <VTable class="text-no-wrap px-5 mb-5">
          <!-- 👉 table footer  -->
          <tfoot v-if="employeeData?.length == 0">
            <tr>
              <td colspan="7" class="text-center py-10">
                No data available
              </td>
            </tr>
          </tfoot>
        </VTable>
          <!-- <div class="row mt-3"></div>
          <div class="separator mb-10"></div>

          <VCardText class="d-flex align-center flex-wrap justify-space-between gap-4 py-3 px-5">
            <strong>
              {{ paginationDataSearchEmployee }}
            </strong>

            <VPagination v-model="currentSearchPage" size="small" :length="totalSearchPages" />
          </VCardText>

          <div class="clearfix"></div> -->
      </v-card-text>
    </VCard>

  </section>
</template>
