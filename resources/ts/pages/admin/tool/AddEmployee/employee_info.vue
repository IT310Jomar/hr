<script setup lang="ts">
import Editsickleave from '@/pages/admin/tool/SickLeave/Editsickleave.vue';
import Viewsickleave from '@/pages/admin/tool/SickLeave/Viewsickleave.vue';
import Editvacation from '@/pages/admin/tool/VacationLeave/Editvacation.vue';
import Viewvacation from '@/pages/admin/tool/VacationLeave/Viewvacation.vue';
import axios from 'axios'
import { environment } from '@/environments/environment';
import {
  useToastr
} from '@/toastr'
import {
  emailValidator,
  requiredValidator
} from '@validators'
import type {
  VForm
} from 'vuetify/components'


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
const submit = ref(false)
const gen = [
  'Male',
  'Female',
]
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
const emit = defineEmits(['employee-submitted','get-ID'])
const props = defineProps<Props>()
const day = ref()
const shift_start = ref()
const shift_end = ref()
const break_start = ref()
const break_end = ref()
const rest_day = ref()
//work schedule end
//Access Level
const showFields = ref(false)
const scheduleFields = ref(false)
const email = ref('')
const password = ref()
const selectedRole = ref()
const user_level = [{
  title: 'God Mode',
  values: 1
}, {
  title: 'Administrator',
  values: 2
}, {
  title: 'Supervisor / Manager',
  values: 3
}, {
  title: 'Employee'
}]
//Access Level end
//Government Access
const sss = ref()
const tin = ref()
const philhealth = ref()
const pagibig = ref()
const prclicense = ref()
const passport = ref()
const tax_status = ref()

//Government Access end
//Educational Background
const educational_type = ref()
const school = ref()
const datefrom = ref()
const dateto = ref()
const degree = ref()
const educationtype = [
  'Elementary',
  'Highschool',
  'College',
  'Vocational Course',
  'Graduate School',
  'Others',
]
//Educational Access end
//contact information
const localtrunkline = ref()
const pin = ref()
const skypeid = ref()
const phone = ref()
const contact = ref()
const relationship = ref()
const address = ref()
const title1 = ref()
const email1 = ref()
const Title = [
  'Mobile',
  'Landline',
  'Home',
  'Work',
  'Others',
]
//contact information end
//dependents
const fname = ref()
const mname = ref()
const lname = ref()
const relationship1 = ref()
const dob1 = ref()
const gender1 = ref()
const Notes = ref()
const Gender = [
  'Male',
  'Female',
]
//dependents end
//benefits
const type2 = ref()
const effecteddate = ref()
const enrolldate = ref()
const plan = ref()
const beneficiary = ref()
const notes = ref()
const payment_type = ref()
const Type2 = [
  'Leave Credits',
  'HMO after 6 months',
  'HMO after probationary period',
  'HMO',
  'Life Insurance ',
  'Accident Insurance',
  'Other Benefits',
]
const paymentType = [
  'N / A',
  'Salary Deduction',
  'Shouldered by Client',
]
//benefits end
//salary
const bank = ref()
const bankaccount = ref()
const dfrom = ref()
const basesalary = ref()
const othertype = ref()
const othersupplies = ref()
const monthgross = ref()
const percentageincrease = ref()
const raiseamount = ref()
const raise = ref()
const commision = ref()
const actionform = ref()
const clothing = ref()
const communication = ref()
const discretionary = ref()
const laudry = ref()
const meal = ref()
const medical = ref()
const productivity = ref()
const rice = ref()
const transportation = ref()
const travel = ref()
const others = ref()
const action_form = [
  'Promotion',
  'Transfer',
  'Salary Increase',
  'Hiring Anniversary',
  'Regularization',
  'Probationary',
]
//end salary
//assets
const item = ref()
const category = ref()
const condition = ref()
const purchaseprice = ref()
const serialnumber = ref()
const acquireddate = ref()
const dateissued = ref()
const datereturned = ref()
const notes1 = ref()
const Category = [
  'Laptop,',
  'Cellphone',
  'Printer',
  'Desktop',
]
const Condition = [
  'Greate',
  'Good',
  'Satisfactory',
  'Bad',
  'Poor',
  'Other',
]
//assets end
//memo
const officiallevel = ref()
const datype = ref()
const infraction = ref()
const dateservereceive = ref()
const slidedate = ref()
const notes2 = ref()
const Officiallevel = [
  'First Offense',
  'Second Offense',
  'Third Offense',
  'Fourth Offense',
  'Fifth Offense',
]
const DAtype = [
  'Verbal Reprimand',
  'Written Warning',
  'Final Written Warning',
  'Suspension',
  'Termination',
]
//memo end
//employment record
const position = ref()
const company = ref()
const industry = ref()
const dFrom = ref()
const dTo = ref()
//employment record end
//movement
const dFrom1 = ref()
const dTo1 = ref()
const position1 = ref()
const departmentaccount = ref()
const employmenttype = ref()
const employmentstatus = ref()
const actionfor = ref()
const notes3 = ref()
const EmploymentType = [
  'Intern',
  'Full Time',
  'Part Time',
  'actionfor',
  'notes',
]
const EmploymentStatus = [
  'Regular',
  'Maternity',
  'Paternity',
  'Sabbatical',
  'Terminated',
  'Resigned',
  'AWOL',
  'Probationary',
  'Part-Time',
  'Extended Part-Time',
  'Contractual / Project Based',
  'On PIP',
  'End of Contract',
]
//movement end

//props
interface Props {
  def: Array<any>
  locate: Array<any>
  estatus: Array<any>
  scheduletype: any
  tstatus: Array<any>
  getID: any
  educationData: any
  contactData: any
  phoneNumberData: any
  emailsData: any
}
//props end


    //work schedule
    const scheduledata = ref({
      
      rows : [{ day : '', shift_start : '', shift_end : '', break_start : '', break_end  : '',  rest_day : null}]
    })


  const scheduleData = () => {
    axios.get(environment.API_URL +'user/schedule_config')
      .then(response => {
        // if (response.data.success) {
        //   if (response.data.schedule_configuration && response.data.schedule_configuration.schedule_type_id) {
        //     schedule_type.value = response.data.schedule_configuration.schedule_type_id;
        //   }
        // }
        watch(schedule_type, (newVal) => {
          if (newVal) {
            // console.log(response.data.data[newVal])
            scheduledata.value.rows = []
            for (var i = 0; i < response.data.data[newVal].length; i++) {
              for(var j = 0 ; j < response.data.data[newVal][i].length; j++) {
                scheduledata.value.rows.push({
                    day : day.value = [response.data.data[newVal][i]][j][0].day,
                    shift_start : shift_start.value = [response.data.data[newVal][i]][j][0].shift_start,
                    shift_end : shift_end.value = [response.data.data[newVal][i]][j][0].shift_end,
                    break_start : break_start.value = [response.data.data[newVal][i]][j][0].break_start,
                    break_end : break_end.value = [response.data.data[newVal][i]][j][0].break_end,
                    rest_day : rest_day.value = [response.data.data[newVal][i]][j][0].rest_day,                
                  })
                // console.log([response.data.data[newVal][i]][j][0].shift_start)
                // console.log([response.data.data[newVal][i]][j][0].day)
              }
            }
          } 
        });
      });
    }


    // 👉 Add item function EDUCATION BACKGROUND
    const addItem = () => {
        props.educationData.education.push({

        })
    }

    // 👉 Remove section EDUCATION BACKGROUND
    const removeItem = (id: number) => {
        props.educationData.education.splice(id, 1)

    }

    // 👉 Add item function Emergency Contact
    const AddItemContact = () => {
        props.contactData.emer_contact.push({

        })
    }

    // 👉 Remove section Emergency Contact
    const removeContact = (id: number) => {
        props.contactData.emer_contact.splice(id, 1)

    }

    // 👉 Add item function Phone Number
    const addItemPhone = () => {
        props.phoneNumberData.phoneNum.push({

        })
    }

    // 👉 Remove section Phone Number
    const removePhone = (id: number) => {
        props.phoneNumberData.phoneNum.splice(id, 1)

    }


    // 👉 Add item function Phone Number
    const addItemEmails = () => {
        props.emailsData.emails.push({

        })
    }

    // 👉 Remove section Phone Number
    const removeEmails = (id: number) => {
        props.emailsData.emails.splice(id, 1)

    }


//submit forms
const submitbasicinfo = () => {
  axios.post(environment.API_URL +'user/employees/store', {
    shift_start: shift_start.value,
    shift_end: shift_end.value,
    break_start: break_start.value,
    break_end: break_end.value,
  })
    .then((response) => {
      toastr.success('Successfully Added Employee')
      emit('employee-submitted', response.data)
      nextTick(() => {
        refEmployee.value?.reset()
        refEmployee.value?.resetValidation()
      })
    })
    .catch((error) => {
      console.log();
    });
};

onMounted(() => {
    scheduleData();
});

</script>

<template>
  <section>

    <!-- Dialog for Editing -->
    <VDialog v-model="isDialogVisible" width="auto">
      <!-- Dialog Activator -->
      <template #activator="{ props }">
        <VListItem v-bind="props" icon size="x-small" color="default" varient="text">
          <template #prepend>
            <VIcon class="me-2" icon="tabler-plus" size="18" />
          </template>
          <VListItemTitle style="font-size: small">Add Employee</VListItemTitle>
        </VListItem>
      </template>
      <!-- Dialog Content -->
      <VCard width="95vw">
        <VCardText>
          <VToolbar title="Add Employee" />
          <VDivider />
          <VScrollable style="max-height: 80vh;">

            <VForm ref="refEmployee" @submit.prevent="submitbasicinfo">
              <!-- Basic Information here -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Basic Information" />
                <VCardText class="flex-grow-1 overflow-auto">
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
                      <VTextField v-model="middle_name" :rules="[requiredValidator]" label="Middle Name" type="text" />
                    </VCol>

                    <VCol sm="3.5" md="3.5">
                      <VSelect v-model="gender" :rules="[requiredValidator]" :items="gen"
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
                      <VSelect v-model="department" :rules="[requiredValidator]" :items="def" item-title="name"
                        item-value="id" :menu-props="{ transition: 'scroll-y-transition' }"
                        label="Department/ Line of Business" type="text" width="auto" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VSelect v-model="location" :rules="[requiredValidator]" :items="locate" item-title="name"
                        item-value="id" :menu-props="{ transition: 'scroll-y-transition' }" label="Location" type="text"
                        width="auto" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VSelect v-model="billability" :rules="[requiredValidator]" :items="[{ title: 'Billability', value: 'billable' }, {
                        title: 'Non-Billability',
                        value: 'non-billable',
                      }]" :menu-props="{ transition: 'scroll-y-transition' }" label="Billability"
                        type="text" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VSelect v-model="employee_type" :rules="[requiredValidator]" :items="[{ title: 'Rank and File', value: 'rank-and-file' }, {
                        title: 'Manager', value: 'manager'
                      },
                      { title: 'Officer', value: 'officer' }]"
                        :menu-props="{ transition: 'scroll-y-transition' }" label="Employee Type" type="text" />
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
                    </VCol>

                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="regularization_date" :rules="[requiredValidator]" label="Regularization Date"
                        type="date" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VSelect v-model="employee_status" :rules="[requiredValidator]" :items="estatus" item-title="name"
                        item-value="id" :menu-props="{ transition: 'scroll-y-transition' }" label="Employment Status"
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
                      ]" :menu-props="{ transition: 'scroll-y-transition' }" label="Payroll Type"
                        type="text" />
                    </VCol>
                  </VRow>
                </VCardText>
              </VCard>
              <!-- Work Information ends here -->
              <!-- Work Schedule here -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Work Schedule" />
                <VCardText>
                  <VRow>
                    <VCol>
                      <VSelect v-model="schedule_type" :rules="[requiredValidator]" :items="scheduletype"
                        item-title="name" item-value="id" :menu-props="{ transition: 'scroll-y-transition' }" type="text"
                        width="auto" label="Schedule Type" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="hours_work" :rules="[requiredValidator]"
                        label="No of hours to work including break hours" type="number" />
                    </VCol>
                  </VRow>
                  <VCard class="mt-4">
                    <VTable>
                      <!-- 👉 table head -->
                      <thead>
                        <tr>
                          <th class="text-Left" scope="col">
                            Day
                          </th>
                          <th class="text-Left" scope="col">
                            Shift Start
                          </th>
                          <th class="text-Left" scope="col">
                            Shift End
                          </th>
                          <th class="text-Left" scope="col">
                            Break Start
                          </th>
                          <th class="text-Left" scope="col">
                            Break End
                          </th>
                          <th class="text-Left" scope="col">
                            Rest Day
                          </th>
                        </tr>
                      </thead>
                      <!-- 👉 table body -->
                      <tbody>
                        <tr v-for="(data, index) in scheduledata.rows" :key="data.day">
                          <td class="text-Left">
                            {{ data.day }}
                          </td>
                          <td class="text-Left">
                            <VTextField :disabled="data.rest_day == 1 ? true: false" v-model="data.shift_start" type="time" variant="underlined" />
                          </td>
                          <td class="text-center">
                            <VTextField :disabled="data.rest_day == 1 ? true: false" v-model="data.shift_end" type="time" variant="underlined" />
                          </td>
                          <td class="text-center">
                            <v-text-field :disabled="data.rest_day == 1 ? true: false" v-model="data.break_start" type="time" variant="underlined" />
                          </td>
                          <td class="text-Left">
                            <v-text-field :disabled="data.rest_day == 1 ? true: false" v-model="data.break_end" type="time" variant="underlined" />
                          </td>
                          <td class="text-center">
                            <v-checkbox v-model="data.rest_day" />
                          </td>
                        </tr>
                      </tbody>
                    </VTable>
                  </VCard>
                </VCardText>
              </VCard>
              <!-- Work Schedule end -->
              
              <!-- User Access Level -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Access Level" />
                <VCardText>
                  <div>
                    <VCheckbox v-model="showFields" label="User Access Level" />
                    <div v-if="showFields" style="background: transparent;">
                      <VRow>
                        <VCol sm="3.5" md="3.5">
                          <VTextField v-model="email" label="Email" type="text" />
                        </VCol>
                      </VRow>

                      <VRow>
                        <VCol sm="3.5" md="3.5">
                          <VSelect v-model="selectedRole" label="User Level" type="text" :items="user_level"
                            :item-text="user_level">
                          </VSelect>
                        </VCol>
                      </VRow>

                      <VRow>
                        <VCol sm="3.5" md="3.5">
                          <VTextField v-model="password" label="Password" type="password" required />
                        </VCol>
                      </VRow>
                    </div>
                  </div>
                </VCardText>
              </VCard>
              <!-- User Access Level ends here -->
              <!-- Government Information -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Government Information" />
                <VCardText>
                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="sss" :rules="[requiredValidator]" label="SSS" type="text" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="tin" :rules="[requiredValidator]" label="TIN" type="text" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="philhealth" :rules="[requiredValidator]" label="Phil Health" type="text" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="pagibig" :rules="[requiredValidator]" label="PAG IBIG" type="text" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="prclicense" :rules="[requiredValidator]" label="PRC License No." type="text" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="passport" :rules="[requiredValidator]" label="Passport No." type="text" />
                    </VCol>
                  </VRow>

                  <VRow>
                    <VCol>
                      <VSelect v-model="tax_status" :rules="[requiredValidator]" :items="tstatus" item-title="name"
                        item-value="id" :menu-props="{ transition: 'scroll-y-transition' }" type="text" width="auto"
                        label="Tax Status" />
                    </VCol>
                  </VRow>
                </VCardText>
              </VCard>
              <!-- Government Information ends here -->
              <!-- Educational Background -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Educational Background" />
                <VCardText>
                  <VCard>
                    <VTable>
                      <!-- 👉 table head -->
                      <thead>
                        <tr>
                          <th class="text-Left" scope="col">
                            Education Type
                          </th>
                          <th class="text-left" scope="col">
                            School
                          </th>
                          <th class="text-Left" scope="col">
                            From
                          </th>
                          <th class="text-Left" scope="col">
                            To
                          </th>
                          <th class="text-center" scope="col">
                            Degree
                          </th>
                          <th class="text-Left" scope="col">
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <!-- 👉 table body -->
                      <tbody class="clearfix">
                        <tr v-for="(education, index) in props.educationData.education" :key="education.title">
                          <td class="text-Left" scope="col" width="20%">
                            <VSelect v-model="educational_type" :items="educationtype"
                              :menu-props="{ transition: 'scroll-y-transition' }" type="text" width="auto"
                              variant="underlined" />
                          </td>
                          <td class="text-Left" scope="col" width="20%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="education.school" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col">
                            <VTextField v-model="education.datefrom" label="dd/mm/yyyy" type="date" />
                          </td>
                          <td class="text-Left" scope="col">
                            <VTextField v-model="education.dateto" label="dd/mm/yyyy" type="date" />
                          </td>
                          <td class="text-Left" scope="col" width="15%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="education.degree" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col">
                            <VBtn icon size="x-small" color="error" variant="text">
                              <VIcon size="22" icon="tabler-trash" @click="removeItem(index)" />
                            </VBtn>
                          </td>
                        </tr>
                      </tbody>
                    </VTable>
                  </VCard>
                </VCardText>
                <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
                  <VCol class="text-right clearfix">
                    <VBtn @click="addItem" size="small">
                      Add Educational Background
                    </VBtn>
                  </VCol>
                </VCardText>
              </VCard>
              <!-- Educational Background ends here -->
              <!-- Contact Information -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Contact Information" />
                <VCardText>
                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="localtrunkline" label="Local Trunk Line" type="text" />
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="pin" label="PIN" type="text" />
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="skypeid" label="Skype ID" type="text" />
                    </VCol>
                  </VRow>
                </VCardText>
                <!--- Emergency Contact Number ---->
                <VToolbar color="primary" title="Emergency Contact Number" />
                <VCardText class="d-flex justify-end flex-wrap gap-3 py-1 ">
                  <VCol class="text-right clearfix">
                    <VBtn @click="AddItemContact" size="small">
                      Add New Number
                    </VBtn>
                  </VCol>
                </VCardText>
                <VCardText>
                  <VCard>
                    <VTable>
                      <thead>
                        <tr>
                          <th class="text-center" scope="col">
                            Phone No
                          </th>
                          <th class="text-center" scope="col">
                            Contact Person
                          </th>
                          <th class="text-center" scope="col">
                            Relationship
                          </th>
                          <th class="text-center" scope="col">
                            Address
                          </th>
                          <th class="text-center" scope="col">
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <!-- 👉 table body -->
                      <tbody class="clearfix">
                        <tr v-for="(emer_contact, index) in props.contactData.emer_contact" :key="emer_contact.title">
                          <td class="text-Left" scope="col" width="25%">
                            <VCol>
                              <VTextField v-model="phone" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-center" scope="col" width="25%">
                            <VCol>
                              <VTextField v-model="contact" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-center" scope="col" width="25%">
                            <VCol>
                              <VTextField v-model="relationship" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-center" scope="col" width="25%">
                            <VCol>
                              <VTextField v-model="address" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-center" scope="col">
                            <VBtn icon size="x-small" color="error" variant="text">
                              <VIcon size="22" icon="tabler-trash" @click="removeContact(index)"/>
                            </VBtn>
                          </td>
                        </tr>
                      </tbody>
                    </VTable>
                  </VCard>
                </VCardText>
                <!--- Emergency Contact Number end ---->

                <!--- Alternative Phone Number ---->
                <VToolbar color="primary" title="Alternative Phone Number" />
                <VCardText class="d-flex justify-end flex-wrap gap-3 py-1 ">
                  <VCol class="text-right clearfix">
                    <VBtn @click="addItemPhone" size="small">
                      Add New Number
                    </VBtn>
                  </VCol>
                </VCardText>
                <VCardText>
                  <VCard>
                    <VTable>
                      <thead>
                        <tr>
                          <th class="text-center" scope="col">
                            Title
                          </th>
                          <th class="text-center" scope="col">
                            Phone No
                          </th>
                          <th class="text-center" scope="col">
                            Contact Person
                          </th>
                          <th class="text-center" scope="col">
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <!-- 👉 table body -->
                      <tbody class="clearfix">
                        <tr v-for="(phoneNum, index) in props.phoneNumberData.phoneNum" :key="phoneNum.title" >
                          <td class="text-Left" scope="col" width="30%">
                            <VCol>
                              <VSelect v-model="title1" :items="Title" :menu-props="{ transition: 'scroll-y-transition' }"
                                type="text" width="auto" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-center" scope="col" width="30%">
                            <VCol>
                              <VTextField v-model="relationship" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-center" scope="col" width="30%">
                            <VCol>
                              <VTextField v-model="address" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-center" scope="col">
                            <VBtn icon size="x-small" color="error" variant="text">
                              <VIcon size="22" icon="tabler-trash" @click="removePhone(index)"/>
                            </VBtn>
                          </td>
                        </tr>
                      </tbody>
                    </VTable>
                  </VCard>
                </VCardText>
                <!--- Alternative Phone Number end ---->

                <!--- Emails ---->
                <VToolbar color="primary" title="Emails" />
                <VCardText class="d-flex justify-end flex-wrap gap-3 py-1 ">
                  <VCol class="text-right clearfix">
                    <VBtn @click.prevent="addItemEmails" size="small">
                      Add New Email
                    </VBtn>
                  </VCol>
                </VCardText>
                <VCardText>
                  <VCard>
                    <VTable>
                      <thead>
                        <tr>
                          <th class="text-center" scope="col">
                            Email Address
                          </th>
                          <th class="text-center" scope="col">
                            Primary
                          </th>
                          <th class="text-center" scope="col">
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <!-- 👉 table body -->
                      <tbody class="clearfix">
                        <tr v-for="(emails, index) in props.emailsData.emails" :key="emails.title">
                          <td class="text-center" scope="col" width="70%">
                            <VCol>
                              <VTextField v-model="email1" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-center" scope="col">
                            <v-row>
                                <v-col class='d-flex justify-center'>
                                    <v-checkbox></v-checkbox>
                                </v-col>
                            </v-row>
                          </td>
                          <td class="text-center" scope="col">
                            <VBtn icon size="x-small" color="error" variant="text">
                              <VIcon size="22" icon="tabler-trash" @click="removeEmails(index)"/>
                            </VBtn>
                          </td>
                        </tr>
                      </tbody>
                    </VTable>
                  </VCard>
                </VCardText>
                <!--- Emails end ---->
              </VCard>
              <!-- Contact Information end -->
              <!-- Dependents -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Dependents" />
                <VCardText>
                  <VCard>
                    <VTable>
                      <!-- 👉 table head -->
                      <thead>
                        <tr>
                          <th class="text-Left" scope="col">
                            First Name
                          </th>
                          <th class="text-center" scope="col">
                            Middle Name
                          </th>
                          <th class="text-center" scope="col">
                            Last Name
                          </th>
                          <th class="text-center" scope="col">
                            Relationship
                          </th>
                          <th class="text-center" scope="col">
                            Date of Birth
                          </th>
                          <th class="text-center" scope="col">
                            Notes
                          </th>
                          <th class="text-Left" scope="col">
                            Gender
                          </th>
                          <th class="text-center" scope="col">
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <!-- 👉 table body -->
                      <tbody class="clearfix">
                        <tr>
                          <td class="text-Left" scope="col" width="20%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="fname" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="20%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="mname" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="17%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="lname" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="17%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="relationship1" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="13%">
                            <VTextField v-model="dob1" label="dd/mm/yyyy" type="date" />
                          </td>
                          <td class="text-Left" scope="col" width="26%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="Notes" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="20%">
                            <VSelect v-model="gender1" :items="Gender" :menu-props="{ transition: 'scroll-y-transition' }"
                              type="text" width="auto" variant="underlined" />
                          </td>
                          <td class="text-center" scope="col">
                            <VBtn icon size="x-small" color="error" variant="text">
                              <VIcon size="22" icon="tabler-trash" />
                            </VBtn>
                          </td>
                        </tr>
                      </tbody>
                    </VTable>
                  </VCard>
                </VCardText>
                <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
                  <VCol class="text-right clearfix">
                    <VBtn type="submit" @click.prevent="submitbasicinfo" size="small">
                      Add Dependents
                    </VBtn>
                  </VCol>
                </VCardText>
              </VCard>
              <!-- Dependents ends here -->
              <!-- Benefits -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Benefits" />
                <VCardText>
                  <VCard>
                    <VTable>
                      <!-- 👉 table head -->
                      <thead>
                        <tr>
                          <th class="text-Left" scope="col">
                            Type
                          </th>
                          <th class="text-center" scope="col">
                            Active
                          </th>
                          <th class="text-center" scope="col">
                            Effective Date
                          </th>
                          <th class="text-center" scope="col">
                            Enrollment Date
                          </th>
                          <th class="text-center" scope="col">
                            plan
                          </th>
                          <th class="text-center" scope="col">
                            Beneficiary
                          </th>
                          <th class="text-center" scope="col">
                            Notes
                          </th>
                          <th class="text-center" scope="col">
                            Payment Type
                          </th>
                          <th class="text-center" scope="col">
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <!-- 👉 table body -->
                      <tbody class="clearfix">
                        <tr>
                          <td class="text-Left" scope="col" width="20%">
                            <VSelect v-model="type2" :items="Type2" :menu-props="{ transition: 'scroll-y-transition' }"
                              type="text" width="auto" variant="underlined" />
                          </td>
                          <td class="text-Left" scope="col">
                            <VCol sm="3.5" md="3.5">
                              <v-checkbox></v-checkbox>
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="14%">
                            <VTextField v-model="effecteddate" label="dd/mm/yyyy" type="date" />
                          </td>
                          <td class="text-Left" scope="col" width="14%">
                            <VTextField v-model="enrolldate" label="dd/mm/yyyy" type="date" />
                          </td>
                          <td class="text-Left" scope="col" width="14%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="plan" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="14%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="beneficiary" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="14%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="notes" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="17%">
                            <VSelect v-model="payment_type" :items="paymentType"
                              :menu-props="{ transition: 'scroll-y-transition' }" type="text" width="auto"
                              variant="underlined" />
                          </td>
                          <td class="text-center" scope="col">
                            <VBtn icon size="x-small" color="error" variant="text">
                              <VIcon size="22" icon="tabler-trash" />
                            </VBtn>
                          </td>
                        </tr>
                      </tbody>
                    </VTable>
                  </VCard>
                </VCardText>
                <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
                  <VCol class="text-right clearfix">
                    <VBtn type="submit" @click.prevent="submitbasicinfo" size="small">
                      Add Benefits
                    </VBtn>
                  </VCol>
                </VCardText>
              </VCard>
              <!-- Benefits ends here -->
              <!-- Leave Plans and Usage -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Leave Plans and Usage" />
                <VCardTitle>
                  Leave Plans and Usage
                  <br><small>This is a summary of your leave plans.</small>
                </VCardTitle>
                <VDivider />
                <VCardTitle>
                  Sick : Default Sick leave
                  <br><small>0 available credits</small>
                  <VRow>
                    <VCol class="d-flex justify-end mr-6 mb-6 gap-3 " style="margin-top: -3%;">
                      <Editsickleave />
                      <Viewsickleave />
                    </VCol>
                  </VRow>
                </VCardTitle>
                <VDivider />
                <VCardTitle>
                  Vacation : Default Vacation leave
                  <br><small>0 available credits</small>
                  <VRow>
                    <VCol class="d-flex justify-end mr-6 mb-6 gap-3 " style="margin-top: -3%;">
                      <Editvacation />
                      <Viewvacation />
                    </VCol>
                  </VRow>
                </VCardTitle>
              </VCard>
              <!-- Leave plans and usage ends here -->
              <!-- Salary bank detail -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Salary" />
                <VCardTitle class="py-5">
                  Bank Details
                  <VRow>
                    <VCol class="d-flex justify-end mr-6 mb-5 " style="margin-top: -2%;">
                      <VBtn type="submit" @click.prevent="submitbasicinfo" size="small">
                        Add New Number
                      </VBtn>
                    </VCol>
                  </VRow>
                  <VDivider />
                </VCardTitle>
                <VCardText>
                  <VCard>
                    <VTable>
                      <thead>
                        <tr>
                          <th class="text-center" scope="col">
                            Bank
                          </th>
                          <th class="text-center" scope="col">
                            Bank Account No
                          </th>
                          <th class="text-center" scope="col">
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <!-- 👉 table body -->
                      <tbody class="clearfix">
                        <tr>
                          <td class="text-center" scope="col" width="50%">
                            <VCol>
                              <VTextField v-model="bank" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-center" scope="col" width="50%">
                            <VCol>
                              <VTextField v-model="bankaccount" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-center" scope="col">
                            <VBtn icon size="x-small" color="error" variant="text">
                              <VIcon size="22" icon="tabler-trash" />
                            </VBtn>
                          </td>
                        </tr>
                      </tbody>
                    </VTable>
                  </VCard>
                </VCardText>
                <!--- Salary ---->
                <VToolbar color="primary" title="Salary" />
                <VCardText>
                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="dfrom" label="Date From" type="date" />
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="basesalary" label="Base Salary" type="text" />
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="othertype" label="Others Type" type="text" />
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="othersupplies" label="Other Supplies" type="text" />
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="monthgross" label="Monthly Gross" type="text" />
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="percentageincrease" label="Percentage Increase" type="text" />
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="raiseamount" label="Raise Amount" type="text" />
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="raise" label="Raise %" type="text" />
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="commision" label="Commision" type="text" />
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol>
                      <VSelect v-model="actionform" :items="action_form"
                        :menu-props="{ transition: 'scroll-y-transition' }" type="text" width="auto"
                        label="Action Form" />
                    </VCol>
                  </VRow>
                  <VRow>
                    <VCol sm="3.5" md="3.5">
                      <VTextField v-model="tin" label="Notes" type="text" />
                    </VCol>
                  </VRow>
                </VCardText>
                <!--- salary end ---->
                <!--- Allowances ---->
                <VToolbar color="primary" title="Allowances" />
                <VCardText>
                  <VForm ref="refEmployee" @submit.prevent="submitbasicinfo">
                    <VCard>
                      <VTable>
                        <thead>
                          <tr>
                            <th class="text-center" scope="col">
                              Allowance
                            </th>
                            <th class="text-center" scope="col">
                              Ammount
                            </th>
                          </tr>
                        </thead>
                        <!-- 👉 table body -->
                        <tbody class="clearfix">
                          <tr>
                            <td class="text-Left" scope="col" width="30%">
                              <VCol>
                                <VCardTitle>
                                  Clothing
                                </VCardTitle>
                              </VCol>
                            </td>
                            <td class="text-center" scope="col" width="30%">
                              <VCol>
                                <VTextField v-model="clothing" type="text" variant="underlined" />
                              </VCol>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-Left" scope="col" width="30%">
                              <VCol>
                                <VCardTitle>
                                  Communication
                                </VCardTitle>
                              </VCol>
                            </td>
                            <td class="text-center" scope="col" width="30%">
                              <VCol>
                                <VTextField v-model="communication" type="text" variant="underlined" />
                              </VCol>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-Left" scope="col" width="30%">
                              <VCol>
                                <VCardTitle>
                                  Discresionary
                                </VCardTitle>
                              </VCol>
                            </td>
                            <td class="text-center" scope="col" width="30%">
                              <VCol>
                                <VTextField v-model="discretionary" type="text" variant="underlined" />
                              </VCol>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-Left" scope="col" width="30%">
                              <VCol>
                                <VCardTitle>
                                  Laundry
                                </VCardTitle>
                              </VCol>
                            </td>
                            <td class="text-center" scope="col" width="30%">
                              <VCol>
                                <VTextField v-model="laudry" type="text" variant="underlined" />
                              </VCol>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-Left" scope="col" width="30%">
                              <VCol>
                                <VCardTitle>
                                  Meal
                                </VCardTitle>
                              </VCol>
                            </td>
                            <td class="text-center" scope="col" width="30%">
                              <VCol>
                                <VTextField v-model="meal" type="text" variant="underlined" />
                              </VCol>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-Left" scope="col" width="30%">
                              <VCol>
                                <VCardTitle>
                                  Medical
                                </VCardTitle>
                              </VCol>
                            </td>
                            <td class="text-center" scope="col" width="30%">
                              <VCol>
                                <VTextField v-model="medical" type="text" variant="underlined" />
                              </VCol>
                            </td>
                          </tr>

                          <tr>
                            <td class="text-Left" scope="col" width="30%">
                              <VCol>
                                <VCardTitle>
                                  Productivity
                                </VCardTitle>
                              </VCol>
                            </td>
                            <td class="text-center" scope="col" width="30%">
                              <VCol>
                                <VTextField v-model="productivity" type="text" variant="underlined" />
                              </VCol>
                            </td>
                          </tr>

                          <tr>
                            <td class="text-Left" scope="col" width="30%">
                              <VCol>
                                <VCardTitle>
                                  Rice
                                </VCardTitle>
                              </VCol>
                            </td>
                            <td class="text-center" scope="col" width="30%">
                              <VCol>
                                <VTextField v-model="rice" type="text" variant="underlined" />
                              </VCol>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-Left" scope="col" width="30%">
                              <VCol>
                                <VCardTitle>
                                  Transportation
                                </VCardTitle>
                              </VCol>
                            </td>
                            <td class="text-center" scope="col" width="30%">
                              <VCol>
                                <VTextField v-model="transportation" type="text" variant="underlined" />
                              </VCol>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-Left" scope="col" width="30%">
                              <VCol>
                                <VCardTitle>
                                  Travel
                                </VCardTitle>
                              </VCol>
                            </td>
                            <td class="text-center" scope="col" width="30%">
                              <VCol>
                                <VTextField v-model="travel" type="text" variant="underlined" />
                              </VCol>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-Left" scope="col" width="30%">
                              <VCol>
                                <VCardTitle>
                                  Others
                                </VCardTitle>
                              </VCol>
                            </td>
                            <td class="text-center" scope="col" width="30%">
                              <VCol>
                                <VTextField v-model="others" type="text" variant="underlined" />
                              </VCol>
                            </td>
                          </tr>
                        </tbody>
                      </VTable>
                    </VCard>
                  </VForm>
                </VCardText>
                <!--- Allowance end ---->
              </VCard>
              <!-- Salary bank detail end -->
              <!-- Assets -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Assets" />
                <VCardText>
                  <VCard>
                    <VTable>
                      <!-- 👉 table head -->
                      <thead>
                        <tr>
                          <th class="text-Left" scope="col">
                            Item
                          </th>
                          <th class="text-center" scope="col">
                            Category
                          </th>
                          <th class="text-center" scope="col">
                            Condition
                          </th>
                          <th class="text-center" scope="col">
                            Purchase Price
                          </th>
                          <th class="text-center" scope="col">
                            Serial Number
                          </th>
                          <th class="text-center" scope="col">
                            Acquired Date
                          </th>
                          <th class="text-center" scope="col">
                            Date Issued
                          </th>
                          <th class="text-center" scope="col">
                            Date Returned
                          </th>
                          <th class="text-center" scope="col">
                            Notes
                          </th>
                          <th class="text-center" scope="col">
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <!-- 👉 table body -->
                      <tbody class="clearfix">
                        <tr>
                          <td class="text-Left" scope="col" width="20%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="item" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col">
                            <VSelect v-model="category" :items="Category"
                              :menu-props="{ transition: 'scroll-y-transition' }" type="text" width="auto"
                              variant="underlined" />
                          </td>
                          <td class="text-Left" scope="col" width="14%">
                            <VSelect v-model="condition" :items="Condition"
                              :menu-props="{ transition: 'scroll-y-transition' }" type="text" width="auto"
                              variant="underlined" />
                          </td>
                          <td class="text-Left" scope="col" width="14%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="purchaseprice" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="14%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="serialnumber" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="14%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="acquireddate" label="dd/mm/yyyy" type="date" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="14%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="dateissued" label="dd/mm/yyyy" type="date" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="17%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="datereturned" label="dd/mm/yyyy" type="date" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="14%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="notes1" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-center" scope="col">
                            <VBtn icon size="x-small" color="error" variant="text">
                              <VIcon size="22" icon="tabler-trash" />
                            </VBtn>
                          </td>
                        </tr>
                      </tbody>
                    </VTable>
                  </VCard>
                </VCardText>
                <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
                  <VCol class="text-right clearfix">
                    <VBtn type="submit" @click.prevent="submitbasicinfo" size="small">
                      Add Asset
                    </VBtn>
                  </VCol>
                </VCardText>
              </VCard>
              <!-- Assets ends here -->
              <!-- Memo -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Memo" />
                <VCardText>
                  <VCard>
                    <VTable>
                      <!-- 👉 table head -->
                      <thead>
                        <tr>
                          <th class="text-center" scope="col">
                            Offensive Level
                          </th>
                          <th class="text-center" scope="col">
                            DA Type
                          </th>
                          <th class="text-center" scope="col">
                            Infraction / Violation Category
                          </th>
                          <th class="text-center" scope="col">
                            Date Served & Received
                          </th>
                          <th class="text-center" scope="col">
                            Slide Date
                          </th>
                          <th class="text-center" scope="col">
                            Notes
                          </th>
                          <th class="text-center" scope="col">
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <!-- 👉 table body -->
                      <tbody class="clearfix">
                        <tr>
                          <td class="text-Left" scope="col" width="15%">
                            <VSelect v-model="officiallevel" :items="Officiallevel"
                              :menu-props="{ transition: 'scroll-y-transition' }" type="text" width="auto"
                              variant="underlined" />
                          </td>
                          <td class="text-Left" scope="col" width="14%">
                            <VSelect v-model="datype" :items="DAtype" :menu-props="{ transition: 'scroll-y-transition' }"
                              type="text" width="auto" variant="underlined" />
                          </td>
                          <td class="text-Left" scope="col" width="14%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="infraction" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="14%">
                            <VTextField v-model="dateservereceive" label="dd/mm/yyyy" type="date" />
                          </td>
                          <td class="text-Left" scope="col" width="14%">
                            <VTextField v-model="slidedate" label="dd/mm/yyyy" type="date" />
                          </td>
                          <td class="text-Left" scope="col" width="14%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="notes2" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-center" scope="col">
                            <VBtn icon size="x-small" color="error" variant="text">
                              <VIcon size="22" icon="tabler-trash" />
                            </VBtn>
                          </td>
                        </tr>
                      </tbody>
                    </VTable>
                  </VCard>
                </VCardText>
                <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
                  <VCol class="text-right clearfix">
                    <VBtn type="submit" @click.prevent="submitbasicinfo" size="small">
                      Add Memo
                    </VBtn>
                  </VCol>
                </VCardText>
              </VCard>
              <!-- Memo ends here -->
              <!-- Employment Record -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Employment Record" />
                <VCardText>
                  <VCard>
                    <VTable>
                      <!-- 👉 table head -->
                      <thead>
                        <tr>
                          <th class="text-center" scope="col">
                            Position
                          </th>
                          <th class="text-center" scope="col">
                            company
                          </th>
                          <th class="text-center" scope="col">
                            Industry
                          </th>
                          <th class="text-center" scope="col">
                            From
                          </th>
                          <th class="text-center" scope="col">
                            To
                          </th>
                          <th class="text-center" scope="col">
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <!-- 👉 table body -->
                      <tbody class="clearfix">
                        <tr>
                          <td class="text-Left" scope="col" width="14%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="position" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="16%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="company" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="16%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="industry" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="20%">
                            <VTextField v-model="dFrom" label="dd/mm/yyyy" type="date" />
                          </td>
                          <td class="text-Left" scope="col" width="20%">
                            <VTextField v-model="dTo" label="dd/mm/yyyy" type="date" />
                          </td>
                          <td class="text-center" scope="col">
                            <VBtn icon size="x-small" color="error" variant="text">
                              <VIcon size="22" icon="tabler-trash" />
                            </VBtn>
                          </td>
                        </tr>
                      </tbody>
                    </VTable>
                  </VCard>
                </VCardText>
                <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
                  <VCol class="text-right clearfix">
                    <VBtn type="submit" @click.prevent="submitbasicinfo" size="small">
                      Add Record
                    </VBtn>
                  </VCol>
                </VCardText>
              </VCard>
              <!-- Employment Record ends here -->

              <!-- Movement -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Movement" />
                <VCardText>
                  <VCard>
                    <VTable>
                      <!-- 👉 table head -->
                      <thead>
                        <tr>
                          <th class="text-center" scope="col">
                            From
                          </th>
                          <th class="text-center" scope="col">
                            To
                          </th>
                          <th class="text-center" scope="col">
                            Position
                          </th>
                          <th class="text-center" scope="col">
                            Department/account
                          </th>
                          <th class="text-center" scope="col">
                            Employment Type
                          </th>
                          <th class="text-center" scope="col">
                            Employment Status
                          </th>
                          <th class="text-center" scope="col">
                            Action For
                          </th>
                          <th class="text-center" scope="col">
                            Notes
                          </th>
                          <th class="text-center" scope="col">
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <!-- 👉 table body -->
                      <tbody class="clearfix">
                        <tr>
                          <td class="text-Left" scope="col" width="13%">
                            <VTextField v-model="dFrom1" label="dd/mm/yyyy" type="date" />
                          </td>
                          <td class="text-Left" scope="col" width="13%">
                            <VTextField v-model="dTo1" label="dd/mm/yyyy" type="date" />
                          </td>
                          <td class="text-Left" scope="col" width="13%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="position1" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="12%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="departmentaccount" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="13%">
                            <VSelect v-model="employmenttype" :items="EmploymentType"
                              :menu-props="{ transition: 'scroll-y-transition' }" type="text" width="auto"
                              variant="underlined" />
                          </td>
                          <td class="text-Left" scope="col" width="12%">
                            <VSelect v-model="employmentstatus" :items="EmploymentStatus"
                              :menu-props="{ transition: 'scroll-y-transition' }" type="text" width="auto"
                              variant="underlined" />
                          </td>
                          <td class="text-Left" scope="col" width="12%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="actionfor" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-Left" scope="col" width="15%">
                            <VCol sm="3.5" md="3.5">
                              <VTextField v-model="notes3" type="text" variant="underlined" />
                            </VCol>
                          </td>
                          <td class="text-center" scope="col">
                            <VBtn icon size="x-small" color="error" variant="text">
                              <VIcon size="22" icon="tabler-trash" />
                            </VBtn>
                          </td>
                        </tr>
                      </tbody>
                    </VTable>
                  </VCard>
                </VCardText>
                <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
                  <VCol class="text-right clearfix">
                    <VBtn type="submit" @click.prevent="submitbasicinfo" size="small">
                      Add Label
                    </VBtn>
                  </VCol>
                </VCardText>
              </VCard>
              <!-- Movement ends here -->
              <!-- Documents -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Documents" />
                <VCardText>
                  <VCard>
                    <VTable>
                      <!-- 👉 table head -->
                      <thead>
                        <tr>
                          <th class="text-Center" scope="col">
                            File Name
                          </th>
                          <th class="text-center" scope="col">
                            Creation Time
                          </th>
                          <th class="text-center" scope="col">
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>

                          </td>
                        </tr>
                      </tbody>
                    </VTable>
                  </VCard>
                </VCardText>
              </VCard>
              <!-- Documents ends here -->
              <!-- Medical Record -->
              <VCard style="margin:2vh;">
                <VToolbar color="primary" title="Medical record" />
                <VCardText>
                  <VCard>
                    <VTable>
                      <!-- 👉 table head -->
                      <thead>
                        <tr>
                          <th class="text-Center" scope="col">
                            File Name
                          </th>
                          <th class="text-center" scope="col">
                            Creation Time
                          </th>
                          <th class="text-center" scope="col">
                            Classification
                          </th>
                          <th class="text-center" scope="col">
                            Notes
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>

                          </td>
                        </tr>
                      </tbody>
                    </VTable>
                  </VCard>
                </VCardText>
              </VCard>
              <!-- Medical Record ends here -->
              <!--- Requirements ---->
              <VToolbar color="primary" title="Requirements" />
              <VCardText>
                <VCard>
                  <VTable>
                    <thead>
                      <tr>
                        <th class="text-center" scope="col">
                          Completed
                        </th>
                        <th class="text-center" scope="col">
                          Requirement Name
                        </th>
                        <th class="text-center" scope="col">
                          Notes
                        </th>
                      </tr>
                    </thead>
                    <!-- 👉 table body -->
                    <tbody class="clearfix">
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol class="d-flex justify-center">
                            <v-checkbox></v-checkbox>
                          </VCol>
                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Copy of Resume
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-left" scope="col" width="30%">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol class="d-flex justify-center">
                            <v-checkbox></v-checkbox>
                          </VCol>
                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Employment requirements Form (signed and checked)
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col" width="30%">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              2pcs of 1x1 picture
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col" width="30%">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Photocopy of Birth certificate
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Photocopy of Birth certificate
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Photocopy of Marriage Contract
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Photocopy of Marriage Contract
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Photocopy of Marriage Contract
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Photocopy of Philhealth ID
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Photocopy of TIN ID
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Photocopy of Pag-ibig ID/number
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Photocopy of Pag-ibig ID/number
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              NBI Clerance
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Copies of Certificate of Employment
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Copy of Transcript of Records
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Copy of Diploma
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Copy of License (PRC, etc)
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Copy of Passport
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Copy of ACR/AEP/VISA
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Pre-employment medical examination
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Employee Information Sheet
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              ATM application
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Philhealth form (PMRF)
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Pag-ibig MDF printout from ONLINE
                              MEMBERSHIP
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Pag-ibig RTMRLD form (merging form)
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              BIR 1902 (without TIN #)
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              BIR 2305 & 1905 forms
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Employment Contract
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              ID application form
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Orientation Module
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              New Hire First Day Checklist
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Waiver for non submission of BIR 2316
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Promissory Note
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-center" scope="col">
                          <VCol>
                            <v-checkbox></v-checkbox>
                          </VCol>

                        </td>
                        <td class="text-left" scope="col">
                          <VCol>
                            <VCardTitle>
                              Employment requirements Form (signed and
                              checked)
                            </VCardTitle>
                          </VCol>
                        </td>
                        <td class="text-center" scope="col">
                          <VCol>
                            <VTextField v-model="clothing" type="text" variant="underlined" />
                          </VCol>
                        </td>
                      </tr>
                    </tbody>
                  </VTable>
                </VCard>
                <!--submit and close-->
                <VCardText class="d-flex justify-end flex-wrap gap-3">
                  <VRow>
                    <VCol class="d-flex justify-end flex-wrap gap-3">
                      <VBtn variant="tonal" color="error" @click="isDialogVisible = false">
                        Close
                      </VBtn>
                      <VBtn type="submit" @click="isDialogVisible = false">
                        Submit
                      </VBtn>
                    </VCol>
                  </VRow>
                </VCardText>
                <!--submit and close end-->
              </VCardText>
              <!--- Requirements end ---->
            </VForm>


          </VScrollable>
        </VCardText>
      </VCard>
    </VDialog>



  </section>
</template>


<style>
.overflow-auto::-webkit-scrollbar {
  block-size: 0;
  inline-size: 0;
}

.overflow-auto:hover::-webkit-scrollbar {
  block-size: 6px;
  inline-size: 6px;
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

.clearfix::before,
.clearfix::after {
  display: table;
  content: "";
  clear: both;
}
</style>
