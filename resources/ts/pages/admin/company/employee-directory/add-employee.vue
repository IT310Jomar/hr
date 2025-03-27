<script setup lang="ts">
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import axios from 'axios'
import { useToastr } from '@/toastr'
import { emailValidator, requiredValidator } from '@validators'
import type { VForm } from 'vuetify/components'
import { ref } from 'vue';
import { Options } from 'flatpickr/dist/types/options'

const refEmployee = ref<VForm>()
const toastr = useToastr()
//close dialog
const isDialogVisible = ref(false)
//close dialog end

//basic info
const employee_id = ref()
const first_name = ref()
const last_name = ref()
const middle_name = ref()
const gender = ref()
const civil_status = ref()
const birthdate = ref()
const gen = [{ title: 'Male', value: 'Male' }, { title: 'Female', value: 'Female' }];

const c_status = [
  'Single',
  'Married',
  'Widowed',
  'Separated',
]
//end basic info
//work info 
const department = ref()
const location = ref()
const billability = ref()
const employee_type = ref()
const hired_date = ref()
const regularization_date = ref()
const employee_status = ref()
const employee_remarks = ref()
const title = ref()
const payroll_type = ref()
const biometric_id = ref()
const employee = ref()
//work info end
//work schedule
const schedule_type = ref()
const hours_work = ref('9')
const emit = defineEmits(['submitted','employee-submitted','get-ID','closeDialog', 'AddEmployee', 'errorAddEmployee'])
const props = defineProps(['employeesData'])
const day = ref()
const shift_start = ref()
const shift_end = ref()
const break_start = ref()
const break_end = ref()
const rest_day = ref()
//work schedule end
//Access Level
const isPasswordVisible = ref(false)
const email = ref()
const password = ref()
const selectedRole = ref()

const loading = ref(false); 

// type FormSubmittedEvent = (value: boolean) => void;
// interface Emit {
//   (e: 'employee-submitted', callback: FormSubmittedEvent): void;
// }

//props
interface Props {
  def: Array<any>
  locate: Array<any>
  estatus: Array<any>
  tstatus: Array<any>
  getID: any
  educationData: any
  contactData: any
  phoneNumberData: any
  emailsData: any
}
//props end

const dateConfig = computed(() => {
  const config: Options = {dateFormat: 'd/m/Y'}
  return config
})

const dateRegConfig = computed(() => {
  const config: Options = {dateFormat: 'd/m/Y'}
  return config
})

const dateHiredConfig = computed(() => {
  const config: Options = {dateFormat: 'd/m/Y'}
  return config
})


//work schedule
const sched_id = ref()

// const scheduledata = ref({

//   rows : [{ day : '', shift_start : '', shift_end : '', break_start : '', break_end  : '',  rest_day : null}]
// })

const scheduledata = ref()

const schedOptions = ref([{ item: '--Select Schdule type--', value: null }])
const user_level = ref([{ item: '--Select User Role--', value: null }])

const def = ref([{ item: '--Select Departments--', value: null }])
const locate = ref([{ item: '--Select Locations--', value: null }])
const estatus = ref([{ item: '--Select Employment Status--', value: null }])
// const scheduletype = ref([''])


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
const getLocation = () => {
  axios.get('/api/user/employees/getEmploymentOptions')
    .then((response) => {
      // Location
      if (response.data.success) {
        if (response.data.locations) {
          for (var x = 0; x < response.data.locations.length; x++) {
            locate.value.push(
              {
                item: response.data.locations[x].name,
                value: response.data.locations[x].id
              }
            )
          }
        }
      }
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

const getSType = () => {
  axios.get('/api/user/employees/getEmploymentOptions')
    .then((response) => {
      // schedule type
      if (response.data.success) {
        if (response.data.sched_type) {
          for (var x = 0; x < response.data.sched_type.length; x++) {
            schedOptions.value.push(
              {
                item: response.data.sched_type[x].name,
                value: response.data.sched_type[x].id
              }
            )
          }
        }
      }

    })
}


const scheduleData = () => {
  axios.get('/api/user/schedule_config')
    .then(response => {
      // if (response.data.success) {
      //   if (response.data.schedule_configuration && response.data.schedule_configuration.schedule_type_id) {
      //     schedule_type.value = response.data.schedule_configuration.schedule_type_id;
      //   }
      // }
      watch(schedule_type, (newVal) => {
        if (newVal) {
          const schedules = [];
          // loop over each item in the array to extract schedule data
          for (let i = 0; i < response.data.data[newVal].length; i++) {
            for (var j = 0; j < response.data.data[newVal][i].length; j++) {
              if (props.employeesData.schedule_types[i] == null) {
                const schedule = { // create a new object with the relevant properties
                  sched_id: sched_id.value = '',
                  day: response.data.data[newVal][i][j].day,
                  shift_start: response.data.data[newVal][i][j].shift_start,
                  shift_end: response.data.data[newVal][i][j].shift_end,
                  break_start: response.data.data[newVal][i][j].break_start,
                  break_end: response.data.data[newVal][i][j].break_end,
                  rest_day: response.data.data[newVal][i][j].rest_day
                };

                schedules.push(schedule); // add the new object to the schedules array

              } else {
                const schedule = { // create a new object with the relevant properties
                  sched_id: sched_id.value = props.employeesData.schedule_types[i].id,
                  day: response.data.data[newVal][i][j].day,
                  shift_start: response.data.data[newVal][i][j].shift_start,
                  shift_end: response.data.data[newVal][i][j].shift_end,
                  break_start: response.data.data[newVal][i][j].break_start,
                  break_end: response.data.data[newVal][i][j].break_end,
                  rest_day: response.data.data[newVal][i][j].rest_day
                };

                schedules.push(schedule); // add the new object to the schedules array
              }
            }
            scheduledata.value = schedules; // update the datas.value with the extracted schedules
          }
        }
      });

    });
}

function closeForm() {
  emit('closeDialog')
}

function successForm() {
  // console.log()
  emit('AddEmployee')
}

function errorAdd() {
  emit('errorAddEmployee')
}

const submitEmployee = () => {
  refEmployee.value?.validate()
    .then(({ valid: isValid }) => {
      if (isValid)
      {
        submitbasicinfo()
      } else {
        toast("Please double check your fields", {
          autoClose: 4000,
          type: 'error',
          theme: 'colored'
        })
      }
    })
}

//submit forms
const submitbasicinfo = () => {
  axios.post('/api/user/employees/store', {

    //User Add
    email: email.value,
    selectedRole: selectedRole.value,
    password: password.value,

    //basic info
    // employee_id: id.value,
    first_name: first_name.value,
    last_name: last_name.value,
    middle_name: middle_name.value,
    gender: gender.value,
    civil_status: civil_status.value,
    birthdate: birthdate.value,

    //work info and schedule
    department: department.value,
    location: location.value,
    billability: billability.value,
    employee_type: employee_type.value,
    title: title.value,
    hired_date: hired_date.value,
    regularization_date: regularization_date.value,
    employee_status: employee_status.value,
    employee_remarks: employee_remarks.value,
    biometric_id: biometric_id.value,
    payroll_type: payroll_type.value, // <--- added a value assignment here
    schedule_type: schedule_type.value,
    hours_work: hours_work.value,

  })
  .then((response) => {
    // console.log(employee_id.value)
    if (response.data) {
      emit('employee-submitted', response.data);
      emit('submitted', response.data);
      loading.value = false
      successForm()
      toast("Success! Employee Recorded Add!", {
        autoClose: 4000,
        type: 'success',
        theme: 'colored',
        style: {
          width: '350px' // Set the width to 400 pixels
        }
      })
      closeForm()
    } else {
      errorAdd()
      toast("Error! Please check your fields!", {
        autoClose: 4000,
        type: 'error',
        theme: 'colored',
        style: {
          width: '350px' // Set the width to 400 pixels
        }
      })
      closeForm()
    }
  })
  
};

//end submit form

//onmounted
onMounted(() => {
  getUserLevel();
  scheduleData();
  getSType();
  getEStatus();
  getLocation();
  getDepartment();

  if (props.employeesData.schedule_types != null) {
    const schedules = []
    for (var i = 0; i < props.employeesData.schedule_types.length; i++) {
      const schedule = {
        sched_id: sched_id.value = props.employeesData.schedule_types[i].id,
        day: day.value = props.employeesData.schedule_types[i].day,
        shift_start: shift_start.value = props.employeesData.schedule_types[i].shift_start,
        shift_end: shift_end.value = props.employeesData.schedule_types[i].shift_end,
        break_start: break_start.value = props.employeesData.schedule_types[i].break_start,
        break_end: break_end.value = props.employeesData.schedule_types[i].break_end,
        rest_day: rest_day.value = props.employeesData.schedule_types[i].rest_day

      }

      schedules.push(schedule)

    }
    scheduledata.value = schedules;

  }

});

</script>

<template>
  <section>
      <!-- Dialog Content -->
      <VCard class="flex-grow-1 overflow-auto" style="overflow: scroll;max-height: 750px;">
        <VCardText>
          <VToolbar title="Add Employee" />
          <VDivider />
            <VForm ref="refEmployee" @submit.prevent="submitEmployee">
              <!-- Basic Information here -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Basic Information" />
                <VCardText>
                  <VRow>
                    <VCol>
                      <VTextField v-model="employee_id" :rules="[requiredValidator]" label="Employee ID" type="number"
                        width="auto" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="first_name" :rules="[requiredValidator]" label="First Name" type="text" />
                    </VCol>

                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="last_name" :rules="[requiredValidator]" label="Last Name" type="text" />
                    </VCol>
                  </VRow>
                  <!-- 2nd Row -->
                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="middle_name" label="Middle Name" type="text" />
                    </VCol>

                    <VCol sm="3.5" md="3.5">
                      <VSelect v-model="gender" :rules="[requiredValidator]" :items="gen" item-value="value" item-title="title"
                        :menu-props="{ transition: 'scroll-y-transition' }" label="Gender" type="text" />
                    </VCol>
                  </VRow>

                  <!-- 3rd Row -->
                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VSelect v-model="civil_status" :rules="[requiredValidator]" :items="c_status"
                        :menu-props="{ transition: 'scroll-y-transition' }" label="Civil Status" type="text" />
                    </VCol>

                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="birthdate" :rules="[requiredValidator]" label="Date of Birth" type="date" />
                      <!-- <AppDateTimePicker
                        :rules="[requiredValidator]"
                          v-model="birthdate"
                          label="dd/mm/yyyy"
                          :config="dateConfig"
                        /> -->
                    </VCol>
                  </VRow>
                </VCardText>
              </VCard>
              <!-- Basic Information end -->

              <!-- Work Information here -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Work Information" />
                <VCardText>
                  <VRow>
                    <VCol>
                      <VSelect v-model="department" :rules="[requiredValidator]" :items="def" item-title="item"
                        item-value="value" :menu-props="{ transition: 'scroll-y-transition' }"
                        label="Department/ Line of Business" type="text" width="auto" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VSelect v-model="location" :rules="[requiredValidator]" :items="locate" item-title="item"
                        item-value="value" :menu-props="{ transition: 'scroll-y-transition' }" label="Location"
                        type="text" width="auto" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VSelect v-model="billability" :rules="[requiredValidator]" :items="[{ title: 'Billable', value: 'Billable' }, {
                        title: 'Non-Billable',
                        value: 'Non-Billable',
                      }]" :menu-props="{ transition: 'scroll-y-transition' }" label="Billability"></VSelect>
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VSelect v-model="employee_type" :rules="[requiredValidator]" :items="[{ title: 'Rank and File', value: 'rank-and-file' }, {
                        title: 'Manager', value: 'manager'
                      },
                      { title: 'Officer', value: 'officer' }]" :menu-props="{ transition: 'scroll-y-transition' }"
                        label="Employee Type" type="text" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="title" :rules="[requiredValidator]" label="Title" type="text" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="hired_date" :rules="[requiredValidator]" label="Hired Date" type="date" />

                      <!-- <AppDateTimePicker
                        :rules="[requiredValidator]"
                          v-model="hired_date"
                          label="dd/mm/yyyy"
                          :config="dateHiredConfig"
                          :style="{ zIndex: 1001 }"
                        /> -->
                    </VCol>

                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="regularization_date" :rules="[requiredValidator]" label="Regularization Date"
                        type="date" />

                        <!-- <AppDateTimePicker
                        :rules="[requiredValidator]"
                          v-model="regularization_date"
                          label="dd/mm/yyyy"
                          :config="dateRegConfig"
                          :style="{ zIndex: 1001 }"
                        /> -->
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VSelect v-model="employee_status" :rules="[requiredValidator]" :items="estatus" item-title="item"
                        item-value="value" :menu-props="{ transition: 'scroll-y-transition' }" label="Employment Status"
                        type="text" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextarea v-model="employee_remarks" :rules="[requiredValidator]" label="Employee Remarks"
                        type="text" />
                    </VCol>
                  </VRow>

                  <VDivider style="margin:2vh" />

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="biometric_id" :rules="[requiredValidator]" label="Biometric ID"
                        type="number" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VSelect v-model="payroll_type" :rules="[requiredValidator]" :items="[{ title: 'Hourly', value: 'hourly' }, { title: 'Daily', value: 'daily' },
                      { title: 'Semi Monthly', value: 'semi-monthly' }, {
                        title: 'Monthly',
                        value: 'monthly',
                      }
                      ]" :menu-props="{ transition: 'scroll-y-transition' }" label="Payroll Type" type="text" />
                    </VCol>
                  </VRow>
                </VCardText>
              </VCard>
              <!-- Work Information ends here -->

              <!-- User Access Level -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Access Level" />
                <VCardText>
                  <div>
                    <!-- <VCheckbox v-model="showFields" label="User Access Level" /> -->
                    <div>
                      <VRow>
                        <VCol sm="3.5" md="3.5">
                          <VTextField v-model="email" label="Email" type="text" :rules="[emailValidator, requiredValidator]"/>
                        </VCol>
                      </VRow>

                      <VRow>
                        <VCol sm="3.5" md="3.5">
                          <VSelect v-model="selectedRole" label="User Level" type="text" :items="user_level"
                            item-title="item" item-value="value" :rules="[requiredValidator]">
                          </VSelect>
                        </VCol>
                      </VRow>

                      <VRow>
                        <VCol sm="3.5" md="3.5">
                          <VTextField v-model="password" label="Password"
                            :rules="[requiredValidator, (v) => (v && v.length >= 8) || 'Password must be at least 8 characters long']"
                            :type="isPasswordVisible ? 'text' : 'password'"
                            :append-inner-icon="isPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
                            @click:append-inner="isPasswordVisible = !isPasswordVisible" />
                        </VCol>
                      </VRow>
                    </div>
                  </div>
                </VCardText>
              </VCard>
              <!-- User Access Level ends here -->

              <!--submit and close-->
              <VCardText class="d-flex justify-end flex-wrap gap-3">
                <VRow>
                  <VCol class="d-flex justify-end flex-wrap gap-3">
                    <VBtn variant="tonal" color="error" @click="closeForm()">
                      Close
                    </VBtn>
                    <VBtn type="submit">
                      Submit
                    </VBtn>
                  </VCol>
                </VRow>
              </VCardText>
              <!--submit and close end-->

            </VForm>
        </VCardText>
      </VCard>

    <v-overlay v-model="loading" id="container">
      <VProgressCircular indeterminate color="primary" id="loader"
        class="d-flex align-items-center justify-content-center" />
    </v-overlay>

  </section>
</template>

<style lang="scss">

.overflow-auto::-webkit-scrollbar {
    block-size: 0;
    inline-size: 0;
  }

  .overflow-auto:hover::-webkit-scrollbar {
    block-size: 10px;
    inline-size: 10px;
  }

  .overflow-auto::-webkit-scrollbar-thumb {
    border-radius: 3px;
    background-color: #3a7fc9;
    transition: background-color 0.2s ease-in-out;
  }

  .overflow-auto::-webkit-scrollbar-thumb:hover {
    background-color: #255da8;
  }

  .scrollbar {
    overflow-y: auto;
    scrollbar-width: thin;
  }

#loader {
  position: fixed;
  z-index: 11;
  margin: auto;
  color: white;
  inset: 0;
}

  // /* Adjust the VCard style for screens smaller than 768px */
  // @media screen and (max-width: 768px) {
  //   VCard {
  //     max-height: none; /* Remove the max-height limit */
  //     overflow-y: auto; /* Add vertical scroll if needed */
  //   }
  // }

  .v-picker__body {
  right: 0;
  left: auto;
  margin-left: 0;
}

.my-element {
  position: relative;
  z-index: 1000;
}
</style>
