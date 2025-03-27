<script setup lang="ts">
import Editsickleave from '@/pages/admin/tool/SickLeave/Editsickleave.vue';
import Viewsickleave from '@/pages/admin/tool/SickLeave/Viewsickleave.vue';
import Editvacation from '@/pages/admin/tool/VacationLeave/Editvacation.vue';
import Viewvacation from '@/pages/admin/tool/VacationLeave/Viewvacation.vue';

import adjustLeaveCreadits from '@/pages/admin/company/employee-directory/multiple-add/AdjustLeaveCreadits/AdjustLeaveCreadits.vue'
import viewLeaveAcrual from '@/pages/admin/company/employee-directory/multiple-add/AdjustLeaveCreadits/viewLeaveAcrual.vue';
import adjustLeaveVacation from '@/pages/admin/company/employee-directory/multiple-add/AdjustLeaveCreadits/AdjustLeaveVacation.vue'
import viewLeaveAccuralVacation from '@/pages/admin/company/employee-directory/multiple-add/AdjustLeaveCreadits/viewLeaveAccrualVacation.vue';

import EducationBackground from '@/pages/admin/company/employee-directory/multiple-add/addEducation.vue';
import ContactInfo from '@/pages/admin/company/employee-directory/multiple-add/addContactInfo.vue';
import Dependents from '@/pages/admin/company/employee-directory/multiple-add/addDependents.vue';
import Benefits from '@/pages/admin/company/employee-directory/multiple-add/addBenefits.vue';
import Banks from '@/pages/admin/company/employee-directory/multiple-add/addBanks.vue';
import Assets from '@/pages/admin/company/employee-directory/multiple-add/addAsset.vue';
import EmployementRecord from '@/pages/admin/company/employee-directory/multiple-add/addEducationRecord.vue';
import Movements from '@/pages/admin/company/employee-directory/multiple-add/addMovement.vue';
import Memo from '@/pages/admin/company/employee-directory/multiple-add/addMemo.vue';
import Documents from '@/pages/admin/company/employee-directory/multiple-add/addDocuments.vue';
import MedicalRecord from '@/pages/admin/company/employee-directory/multiple-add/addMedicalRecord.vue';

import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

import axios from 'axios'
import { useToastr } from '@/toastr'
import { emailValidator, requiredValidator } from '@validators'
import type { VForm } from 'vuetify/components'

const refEmployee = ref<VForm>()
const toastr = useToastr()
//close dialog
const isPasswordVisible = ref(false)
const loading = ref(false)
//close dialog end

//basic info
const employee_id = ref()
const first_name = ref()
const last_name = ref()
const middle_name = ref()
const gender = ref()
const civil_status = ref()
const user_id = ref()
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
const date_of_birth = ref()
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
const emit = defineEmits(['employee-submitted', 'get-ID', 'closeDialog', 'editEmployeeDetail', 'errorAddEmployee'])
const props = defineProps(['employeesData'])
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
// const user_level = [{
//   title: 'God Mode',
//   values: 1
// }, {
//   title: 'Administrator',
//   values: 2
// }, {
//   title: 'Supervisor / Manager',
//   values: 3
// }, {
//   title: 'Employee'
// }]
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
const commission = ref()
const actionform = ref()
const note = ref()
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

}
//props end

function closeForm() {
  emit('closeDialog')
}

function successForm() {
  // console.log()
  emit('editEmployeeDetail')
}

function errorEdit() {
  emit('errorAddEmployee')
}

const errorToastr = ref(false)
const adjustLeaveCreaditsVacation = ref(false)
const adjustLeaveCreaditsDialog = ref(false)
const viewLeaveAcrualDialog = ref(false)
const viewLeaveVacation = ref(false)

//work schedule
const sched_id = ref()

const scheduledata = ref()

const schedOptions = ref([{ item: '--Select Schdule type--', value: null }])
const tstatus = ref([{ item: '--Select Tax Type--', value: null }])
const user_level = ref([{ item: '--Select User Role--', value: null }])
const salaryActions = ref([{ item: '--Select Option--', value: null }])


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

const getTax = () => {
  axios.get('/api/user/employees/getEmploymentOptions')
    .then((response) => {
      // Tax type
      if (response.data.success) {
        if (response.data.tax_statuses) {
          for (var x = 0; x < response.data.tax_statuses.length; x++) {
            tstatus.value.push(
              {
                item: response.data.tax_statuses[x].name,
                value: response.data.tax_statuses[x].id
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

const getSalary = () => {
  axios.get('/api/user/employees/getEmploymentOptions')
    .then((response) => {
      // Salary Actions
      if (response.data.salary_actions) {
        for (var x = 0; x < response.data.salary_actions.length; x++) {
          salaryActions.value.push(
            {
              item: response.data.salary_actions[x].name,
              value: response.data.salary_actions[x].id
            }
          )
        }
      }

    })
}

const getRequirement = () => {
  axios.get('/api/user/employees/getEmploymentOptions')
    .then(response => {
      // Requirements Data
      const requirements_data = []
      for (var i = 0; i < response.data.reqs.length; i++) {
        if (props.employeesData.requirements[i] == null) {
          const require = {
            req_id: req_id.value = '',
            name: response.data.reqs[i].name,
            notes: response.data.reqs[i].notes,
          }
          requirements_data.push(require)
        } else {
          const require = {
            req_id: req_id.value = props.employeesData.requirements[i].id,
            name: response.data.reqs[i].name,
            notes: notes.value = props.employeesData.requirements[i].notes,
            selectedCheckbox: selectedCheckbox.value = props.employeesData.requirements[i].completed
          }
          requirements_data.push(require)
        }
        requirements.value = requirements_data
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
              if (props.employeesData.schedule[i] == null) {
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
                  sched_id: sched_id.value = props.employeesData.schedule[i].id,
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

const req_id = ref();
const selectedCheckbox = ref();

const contactData = ref();
const emergencyContacts = ref();
const alternateContacts = ref();
const alternateEmail = ref();
const allMemoData = ref();
const requirements = ref();
const SickCreditData = ref();
const VacationCreditData = ref();


//handle the inputed data from child component add emergency contact
const contact = ref([]);
const handleChanged = (formValues: any) => {
  contact.value = formValues

}

//handle the inputted data from child component leave credits sick
const creditsSick = ref();
const handleLeaveCreditsData = (values: any) => {
  creditsSick.value = values
}
//handle the inputted data from child component leave credits vacation
const creditVacation = ref();
const handleDataVacation = (values: any) => {
   creditVacation.value = values
}

//FUNCTION FOR OPENING ADJUST CREDITS SICK DIALOG
const openAddLeaveCredits = () => {
  adjustLeaveCreaditsDialog.value = true
}
//FUNCTION FOR OPENING VIEW ACRUAL DIALOG SICK
const openViewLeaveAcural = () => {
  viewLeaveAcrualDialog.value = true
}
//FUNCTION FOR OPENING ADJUST CREDITS VACATION DIALOG
const openAddLeaveVacation = () => {
  adjustLeaveCreaditsVacation.value = true
}
//FUNCTION FOR OPENING VIEW ACRUAL DIALOG Vacation
const openViewAccrualVacation = () => {
  viewLeaveVacation.value = true
}

const Data = ref({
  // 👉 Add item function DATA!!
  education: [],
  emergency_contacts: [],
  alternate_phone_no: [],
  emails: [],
  dependents: [],
  benefits: [],
  banks: [],
  documents: [],
  medical_record: [],
  assets: [],
  memo: [],
  movements: [],
  employments_record: [],
  getDatas: [],
  edu_list: props.employeesData.educations,
  contactData: props.employeesData.contacts,
  allMemoData: props.employeesData.memo,
  emergencyContacts: props.employeesData.emergency,
  alternateContacts: props.employeesData.alternate,
  alternateEmail: props.employeesData.email,
  dependent_list: props.employeesData.dependents,
  benefit_list: props.employeesData.benefits,
  bank_list: props.employeesData.banks,
  document_records: props.employeesData.documents,
  medical_records: props.employeesData.medical_record,
  assets_list: props.employeesData.assets,
  employment_rec_list: props.employeesData.employee_rec,
  movements_list: props.employeesData.movements,
  SickCreditData: props.employeesData.leave_credits_sick
})

const ed_Data: Array<{ education: any }> = Data.value.education;
const ed_Dependents: Array<{ dependents: any }> = Data.value.dependents;
const ed_Benifits: Array<{ benefits: any }> = Data.value.benefits;
const ed_Banks: Array<{ banks: any }> = Data.value.banks;
const ed_Documents: Array<{ documents: any }> = Data.value.documents;
const ed_Medical: Array<{ medical_record: any }> = Data.value.medical_record;
const ed_Assets: Array<{ assets: any }> = Data.value.assets;
const ed_EmployeeRecord: Array<{ employments_record: any }> = Data.value.employments_record;
const ed_Movement: Array<{ movements: any }> = Data.value.movements;

let educationData;
let dependentsData;
let benefitsData;
let banksData;
let documentData;
let medicalData;
let assetsData;
let employeeRecords;
let movementsData;
for (var i = 0; i < ed_Data.length; i++) {
  const edu = ref(ed_Data[i]);
  educationData = edu.value
}
for (var x = 0; x < ed_Dependents.length; x++) {
  const dep = ref(ed_Dependents[x]);
  dependentsData = dep.value
}
for (var j = 0; j < ed_Benifits.length; j++) {
  const ben = ref(ed_Benifits[j]);
  benefitsData = ben.value
}
for (var y = 0; y < ed_Banks.length; y++) {
  const bank = ref(ed_Banks[y]);
  banksData = bank.value
}
for (var l = 0; l < ed_Documents.length; l++) {
  const docs = ref(ed_Documents[l]);
  documentData = docs.value
}
for (var p = 0; p < ed_Medical.length; p++) {
  const meds = ref(ed_Medical[p]);
  medicalData = meds.value
}
for (var a = 0; a < ed_Assets.length; a++) {
  const asset = ref(ed_Assets[a]);
  assetsData = asset.value
}
for (var e = 0; e < ed_EmployeeRecord.length; e++) {
  const em_records = ref(ed_EmployeeRecord[e]);
  employeeRecords = em_records.value
}
for (var m = 0; m < ed_Movement.length; m++) {
  const movement = ref(ed_Movement[m]);
  movementsData = movement.value
}


const UpdateEmployee = () => {
  refEmployee.value?.validate()
    .then(({ valid: isValid }) => {
      if (isValid) {
        EditedEmployee()
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
const EditedEmployee = () => {
  axios.put('/api/user/employees/edit/' + employee_id.value,
    {
      first_name: first_name.value,
      last_name: last_name.value,
      middle_name: middle_name.value,
      gender: gender.value,
      date_of_birth: date_of_birth.value,
      address: address.value,
      department: department.value,
      billability: billability.value,
      employee_type: employee_type.value,
      title: title.value,
      employee_remarks: employee_remarks.value,
      biometric_id: biometric_id.value,
      payroll_type: payroll_type.value,
      hired_date: hired_date.value,
      regularization_date: regularization_date.value,
      civil_status: civil_status.value,
      location: location.value,
      employee_status: employee_status.value,
      schedule_type: schedule_type.value,
      hours_work: hours_work.value,
      // government info
      sss: sss.value,
      tin: tin.value,
      philhealth: philhealth.value,
      pagibig: pagibig.value,
      prclicense: prclicense.value,
      passport: passport.value,
      tax_status: tax_status.value,
      // access level info
      user_id: user_id.value,
      email: email.value,
      selectedRole: selectedRole.value,
      password: password.value,
      contact: contact.value,
      emergencyContactsData: Data.value.emergency_contacts,
      alternativeContact: Data.value.alternate_phone_no,
      alternativeEmails: Data.value.emails,
      dfrom: dfrom.value,
      basesalary: basesalary.value,
      othertype: othertype.value,
      othersupplies: othersupplies.value,
      monthgross: monthgross.value,
      percentageincrease: percentageincrease.value,
      raiseamount: raiseamount.value,
      raise: raise.value,
      commission: commission.value,
      actionform: actionform.value,
      note: note.value,

      clothing: clothing.value,
      communication: communication.value,
      discretionary: discretionary.value,
      laudry: laudry.value,
      meal: meal.value,
      medical: medical.value,
      productivity: productivity.value,
      rice: rice.value,
      transportation: transportation.value,
      travel: travel.value,
      others: others.value,

      educationData: Data.value.education,
      dependentsData: Data.value.dependents,
      benefitsData: Data.value.benefits,
      banksData: Data.value.banks,
      documentData: Data.value.documents,
      medicalData: Data.value.medical_record,
      assetsData: Data.value.assets,
      memoData: Data.value.memo,
      employeeRecords: Data.value.employments_record,
      movementsData: Data.value.movements,
      scheduledata: scheduledata.value,
      requirements: requirements.value,
      creditsSick: creditsSick.value,
      creditVacation: creditVacation.value,
    }
  ).then((response) => {
    // console.log(employee_id.value)
    if (response.data.success) {
      loading.value = false
      successForm()
      toast("Success! Employee record updated!", {
        autoClose: 4000,
        type: 'success',
        theme: 'colored',
        style: {
          width: '350px' // Set the width to 400 pixels
        }
      })
      closeForm()
    } else {
      errorEdit()
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
}
//submit forms end


type FormSubmittedEvent = (value: boolean) => void;
interface Emit {
  (e: 'employee-submitted', callback: FormSubmittedEvent): void;
}
//end submit form

//onmounted
onMounted(() => {
  getUserLevel();
  scheduleData();
  getSType();
  getEStatus();
  getLocation();
  getDepartment();
  getTax();
  getSalary();
  getRequirement();

  employee_id.value = props.employeesData.id
  first_name.value = props.employeesData.first_name
  last_name.value = props.employeesData.last_name
  middle_name.value = props.employeesData.middle_name
  gender.value = props.employeesData.gender
  date_of_birth.value = props.employeesData.birthdate
  user_id.value = props.employeesData.user_id
  address.value = props.employeesData.address
  if (props.employeesData.employments.departments != null) {
    department.value = props.employeesData.employments.departments.id
  }
  civil_status.value = props.employeesData.civil_status
  billability.value = props.employeesData.employments.billability
  if (props.employeesData.employments.locations != null) {
    location.value = props.employeesData.employments.locations.id
  }
  hired_date.value = props.employeesData.employments.date_hired
  regularization_date.value = props.employeesData.employments.date_regularization
  employee_type.value = props.employeesData.employments.type
  title.value = props.employeesData.employments.title
  if (props.employeesData.employments.employmentstatus != null) {
    employee_status.value = props.employeesData.employments.employmentstatus.id
  }
  employee_remarks.value = props.employeesData.employments.remarks
  biometric_id.value = props.employeesData.employments.biometric
  payroll_type.value = props.employeesData.employments.payroll_type
  hours_work.value = props.employeesData.employments.working_hours
  if (props.employeesData.employments.schedule_types != null) {
    schedule_type.value = props.employeesData.employments.schedule_types.id
  }

  if (props.employeesData.employments.user != null) {
    email.value = props.employeesData.employments.user.email
    selectedRole.value = props.employeesData.employments.user.user_levels.id
    password.value = props.employeesData.employments.user.password

  }

  if (props.employeesData.memo) {
    allMemoData.value = props.employeesData.memo
  }

  if (props.employeesData.government != null) {
    sss.value = props.employeesData.government.sss
    tin.value = props.employeesData.government.tin
    philhealth.value = props.employeesData.government.phil_health
    pagibig.value = props.employeesData.government.pag_ibig
    prclicense.value = props.employeesData.government.prc
    passport.value = props.employeesData.government.passport
    tax_status.value = props.employeesData.government.tax_status_id
  }

  if (props.employeesData.contacts != null) {
    contactData.value = props.employeesData.contacts

  }
  if (props.employeesData.emergency != null) {
    emergencyContacts.value = props.employeesData.emergency
  }
  if (props.employeesData.alternate != null) {
    alternateContacts.value = props.employeesData.alternate
  }
  if (props.employeesData.email != null) {
    alternateEmail.value = props.employeesData.email
  }

  if (props.employeesData.schedule != null) {
    const schedules = []
    for (var i = 0; i < props.employeesData.schedule.length; i++) {
      const schedule = {
        sched_id: sched_id.value = props.employeesData.schedule[i].id,
        day: day.value = props.employeesData.schedule[i].day,
        shift_start: shift_start.value = props.employeesData.schedule[i].shift_start,
        shift_end: shift_end.value = props.employeesData.schedule[i].shift_end,
        break_start: break_start.value = props.employeesData.schedule[i].break_start,
        break_end: break_end.value = props.employeesData.schedule[i].break_end,
        rest_day: rest_day.value = props.employeesData.schedule[i].rest_day

      }

      schedules.push(schedule)

    }
    scheduledata.value = schedules;

  }

  if (props.employeesData.salaries != null) {
    dfrom.value = props.employeesData.salaries.date_from
    basesalary.value = props.employeesData.salaries.base_salary
    othertype.value = props.employeesData.salaries.others_type
    othersupplies.value = props.employeesData.salaries.other_supplies
    monthgross.value = props.employeesData.salaries.monthly_gross
    percentageincrease.value = props.employeesData.salaries.percentage_increase
    raiseamount.value = props.employeesData.salaries.raise_amount
    raise.value = props.employeesData.salaries.raise_percentage
    commission.value = props.employeesData.salaries.commission
    actionform.value = props.employeesData.salaries.salary_action_id
    note.value = props.employeesData.salaries.notes

    clothing.value = props.employeesData.salaries.clothing
    communication.value = props.employeesData.salaries.communication
    discretionary.value = props.employeesData.salaries.discretionary
    laudry.value = props.employeesData.salaries.laundry
    meal.value = props.employeesData.salaries.meal
    medical.value = props.employeesData.salaries.medical
    productivity.value = props.employeesData.salaries.productivity
    rice.value = props.employeesData.salaries.rice
    transportation.value = props.employeesData.salaries.transportation
    travel.value = props.employeesData.salaries.travel
    others.value = props.employeesData.salaries.others
  }

  if (props.employeesData.leave_credits_sick != null) {
    SickCreditData.value = props.employeesData.leave_credits_sick
    console.log(SickCreditData.value)

  }
  if (props.employeesData.leave_credits_vacation != null) {
    VacationCreditData.value = props.employeesData.leave_credits_vacation
  }

});

// const salaryRules = ref<((v: string) => boolean | string)[]>([
//   // (value) => !!value || 'Input is required',
//   (value) => /^\d{6}$/.test(value) || 'Limit 6 digits only'
// ]);

</script>

<template>
  <section>
    <!-- Dialog Content -->
    <VCard class="flex-grow-1 overflow-auto" style="overflow: scroll;max-height: 750px;">
      <VCardText>
        <VToolbar title="Edit Employee" />
      </VCardText>
      <VDivider />

      <VForm ref="refEmployee" @submit.prevent="UpdateEmployee">

        <!-- Basic Information here -->
        <VCard style="margin:2vh;">
          <VToolbar color="primary" title="Basic Information" />
          <VCardText>
            <VRow>
              <VCol>
                <VTextField readonly v-model="employee_id" :rules="[requiredValidator]" label="Employee ID" type="number"
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
                <VSelect v-model="gender" :rules="[requiredValidator]" :items="gen" item-title="item" item-value="value"
                  label="Gender" type="text" />
              </VCol>
            </VRow>

            <!-- 3rd Row -->
            <VRow>
              <VCol sm="3.5" md="3.5">
                <VSelect v-model="civil_status" :rules="[requiredValidator]" :items="c_status" item-title="item"
                  item-value="value" label="Civil Status" type="text" />
              </VCol>

              <VCol sm="3.5" md="3.5">
                <VTextField v-model="date_of_birth" :rules="[requiredValidator]" label="Date of Birth" type="date" />
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
                  item-value="value" label="Department/ Line of Business" type="text" width="auto" />
              </VCol>
            </VRow>

            <VRow>
              <VCol sm="3.5" md="3.5">
                <VSelect v-model="location" :rules="[requiredValidator]" :items="locate" item-title="item"
                  item-value="value" label="Location" type="text" width="auto" />
              </VCol>
            </VRow>

            <VRow>
              <VCol sm="3.5" md="3.5">
                <VSelect v-model="billability" :rules="[requiredValidator]" :items="[{ title: 'Billability', value: 'billable' }, {
                  title: 'Non-Billability',
                  value: 'non-billable',
                }]" label="Billability"></VSelect>
              </VCol>
            </VRow>

            <VRow>
              <VCol sm="3.5" md="3.5">
                <VSelect v-model="employee_type" :rules="[requiredValidator]" :items="[{ title: 'Rank and File', value: 'rank-and-file' }, {
                  title: 'Manager', value: 'manager'
                },
                { title: 'Officer', value: 'officer' }]" label="Employee Type" type="text" />
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
                <VSelect v-model="employee_status" :rules="[requiredValidator]" :items="estatus" item-title="item"
                  item-value="value" label="Employment Status" type="text" />
              </VCol>
            </VRow>

            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextarea v-model="employee_remarks" :rules="[requiredValidator]" label="Employee Remarks" type="text" />
              </VCol>
            </VRow>

            <VDivider style="margin:2vh" />

            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="biometric_id" :rules="[requiredValidator]" label="Biometric ID" type="number" />
              </VCol>
            </VRow>

            <VRow>
              <VCol sm="3.5" md="3.5">
                <VSelect v-model="payroll_type" :rules="[requiredValidator]" :items="[{ title: 'Hourly', value: 'hourly' }, { title: 'Daily', value: 'daily' },
                { title: 'Semi Monthly', value: 'semi-monthly' }, {
                  title: 'Monthly',
                  value: 'monthly',
                }
                ]" label="Payroll Type" type="text" />
              </VCol>
            </VRow>
          </VCardText>
        </VCard>
        <!-- Work Information ends here -->

        <!-- Work Schedule here -->
        <VCard style="margin:2vh;">
          <VToolbar color="primary" title="Work Schedule" />
          <VCardText>
            <VTextField v-model="user_id" type="hidden" style="display: none;" />
            <VRow>
              <VCol>
                <VSelect v-model="schedule_type" :items="schedOptions" item-title="item" item-value="value" type="text"
                :rules="[requiredValidator]" width="auto" label="Schedule Type" />
              </VCol>
            </VRow>

            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="hours_work" :rules="[requiredValidator]" max=9
                  oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';"
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
                  <tr v-for="(data, index) in scheduledata" :key="data">
                    <td class="text-center">
                      {{ data.day }}
                    </td>
                    <td class="text-center">
                      <VTextField :disabled="data.rest_day == 1 ? true : false" v-model="data.shift_start" type="time"
                        variant="underlined" />
                    </td>
                    <td class="text-center">
                      <VTextField :disabled="data.rest_day == 1 ? true : false" v-model="data.shift_end" type="time"
                        variant="underlined" />
                    </td>
                    <td class="text-center">
                      <v-text-field :disabled="data.rest_day == 1 ? true : false" v-model="data.break_start" type="time"
                        variant="underlined" />
                    </td>
                    <td class="text-center">
                      <v-text-field :disabled="data.rest_day == 1 ? true : false" v-model="data.break_end" type="time"
                        variant="underlined" />
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
              <!-- <VCheckbox v-model="showFields" label="User Access Level" /> -->
              <div>
                <VTextField v-model="user_id" type="hidden" style="display: none;" />
                <VRow>
                  <VCol sm="3.5" md="3.5">
                    <VTextField v-model="email" label="Email" type="text" :rules="[requiredValidator, emailValidator]" />
                  </VCol>
                </VRow>

                <VRow>
                  <VCol sm="3.5" md="3.5">
                    <VSelect v-model="selectedRole" label="User Level" type="text" :items="user_level" item-title="item"
                      item-value="value" :rules="[requiredValidator]">
                    </VSelect>
                  </VCol>
                </VRow>

                <VRow>
                  <VCol sm="3.5" md="3.5">
                    <VTextField v-model="password" label="Password" :type="isPasswordVisible ? 'text' : 'password'"
                      :append-inner-icon="isPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
                      :rules="[v => !password || password.length >= 8 || 'Password must be at least  characters long']"
                      @click:append-inner="isPasswordVisible = !isPasswordVisible" />
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
            <VTextField v-model="user_id" type="hidden" style="display: none;" />
            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="sss" label="SSS" type="text" />
              </VCol>
            </VRow>

            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="tin" label="TIN" type="text" />
              </VCol>
            </VRow>

            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="philhealth" label="Phil Health" type="text" />
              </VCol>
            </VRow>

            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="pagibig" label="PAG IBIG" type="text" />
              </VCol>
            </VRow>

            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="prclicense" label="PRC License No." type="text" />
              </VCol>
            </VRow>

            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="passport" label="Passport No." type="text" />
              </VCol>
            </VRow>

            <VRow>
              <VCol>
                <VSelect v-model="tax_status" :items="tstatus" item-title="item" item-value="value" type="text"
                  width="auto" label="Tax Status" />
              </VCol>
            </VRow>
          </VCardText>
        </VCard>
        <!-- Government Information ends here -->

        <!-- Educational Background -->
        <EducationBackground :Data="Data" />
        <!-- Educational Background ends here -->

        <!-- Contact Information -->
        <ContactInfo :contactData="contactData" @formDataChanged="handleChanged" :Data="Data" />
        <!-- Contact Information end -->

        <!-- Dependents -->
        <Dependents :Data="Data" />
        <!-- Dependents ends here -->

        <!-- Benefits -->
        <Benefits :Data="Data" />
        <!-- Benefits ends here -->

        <!-- Leave Plans and Usage -->
        <VCard style="margin:2vh;">
          <VToolbar color="primary" title="Leave Plans and Usage" />
          <VCardText>
            <VAlert prominent type="info" variant="tonal">
              <template #text>
                WARNING! All fields in this tab are required.
              </template>
            </VAlert><br>

            <div style="padding-top:2vh">
              <h3>Leave Plans and usage</h3>
              <p style=""><span>This is a summary of your leave plans.</span></p>
            </div>

            <VDivider />

            <div style="padding-top:2vh">
              <VRow>
                <VCol sm="6" md="6">
                  <h3>Sick : Default Sick leave</h3>
                  <p style="">{{ props.employeesData.leave_credits_sick.sick_leave_credits }} available credits</p>
                </VCol>

                <VCol sm="6" md="6">
                  <div style="float:right; padding:2vh;">
                    <VBtn @click.prevent="openAddLeaveCredits" style="margin-right: 1vh; margin-bottom: 1vh;">
                      <VIcon start icon="tabler-pencil" />Edit
                    </VBtn>
                    <VBtn @click.prevent="openViewLeaveAcural" style="margin-right: 1vh; margin-bottom: 1vh;">
                      <VIcon start icon="tabler-eye" />View Leave Accrual
                    </VBtn>
                  </div>
                </VCol>
              </VRow>

            </div>
            <VDivider />
            <div style="padding-top:2vh">
              <VRow>
                <VCol sm="6" md="6">
                  <h3>Vacation : Default Vacation leave</h3>
                  <p style="">{{ props.employeesData.leave_credits_vacation.vacation_leave_credits }} available credits</p>
                </VCol>

                <VCol sm="6" md="6">
                  <div style="float:right; padding:2vh;">
                    <VBtn @click.prevent="openAddLeaveVacation" style="margin-right: 1vh; margin-bottom: 1vh;">
                      <VIcon start icon="tabler-pencil" />Edit
                    </VBtn>
                    <VBtn @click.prevent="openViewAccrualVacation" style="margin-right: 1vh; margin-bottom: 1vh;">
                      <VIcon start icon="tabler-eye" />View Leave Accrual
                    </VBtn>
                  </div>
                </VCol>
              </VRow>

            </div>
          </VCardText>
        </VCard>
        <!-- Leave plans and usage ends here -->

        <!-- Salary bank detail -->
        <Banks :Data="Data" />
        <VCard style="margin:2vh;">
          <VToolbar color="primary" title="Salary" />
          <VCardText>
            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="dfrom" label="Date From" type="date" />
              </VCol>
            </VRow>
            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="basesalary" label="Base Salary" type="number" max=999999
                  oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
              </VCol>
            </VRow>
            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="othertype" label="Others Type" type="text" />
              </VCol>
            </VRow>
            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="othersupplies" label="Other Supplies" type="number" max=999999
                  oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
              </VCol>
            </VRow>
            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="monthgross" label="Monthly Gross" type="number" max=999999
                  oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
              </VCol>
            </VRow>
            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="percentageincrease" label="Percentage Increase" type="number" max=999999
                  oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
              </VCol>
            </VRow>
            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="raiseamount" label="Raise Amount" type="number" max=999999
                  oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
              </VCol>
            </VRow>
            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="raise" label="Raise %" type="number" max=999999
                  oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
              </VCol>
            </VRow>
            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="commission" label="Commision" type="number" max=999999
                  oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
              </VCol>
            </VRow>
            <VRow>
              <VCol>
                <VSelect v-model="actionform" :items="salaryActions" item-title="item" item-valu="value" type="text"
                  width="auto" label="Action Form" />
              </VCol>
            </VRow>
            <VRow>
              <VCol sm="3.5" md="3.5">
                <VTextField v-model="note" label="Notes" type="text" />
              </VCol>
            </VRow>
          </VCardText>
          <!--- salary end ---->
          <!--- Allowances ---->
          <VToolbar color="primary" title="Allowances" />
          <VCard style="margin: 2vh;">
            <VTable class="py-2 px-2">
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
                      <VTextField v-model="clothing" type="number" variant="underlined" max=999999
                        oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
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
                      <VTextField v-model="communication" type="number" variant="underlined" max=999999
                        oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
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
                      <VTextField v-model="discretionary" type="number" variant="underlined" max=999999
                        oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
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
                      <VTextField v-model="laudry" type="number" variant="underlined" max=999999
                        oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
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
                      <VTextField v-model="meal" type="number" variant="underlined" max=999999
                        oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
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
                      <VTextField v-model="medical" type="number" variant="underlined" max=999999
                        oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
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
                      <VTextField v-model="productivity" type="number" variant="underlined" max=999999
                        oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
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
                      <VTextField v-model="rice" type="number" variant="underlined" max=999999
                        oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
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
                      <VTextField v-model="transportation" type="number" variant="underlined" max=999999
                        oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
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
                      <VTextField v-model="travel" type="number" variant="underlined" max=999999
                        oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
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
                      <VTextField v-model="others" type="number" variant="underlined" max=999999
                        oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
                    </VCol>
                  </td>
                </tr>
              </tbody>
            </VTable>
          </VCard>
          <!--- Allowance end ---->
        </VCard>
        <!-- Salary bank detail end -->

        <!-- Assets -->
        <Assets :Data="Data" />
        <!-- Assets ends here -->

        <!-- Memo -->
        <Memo :allMemoData="allMemoData" :Data="Data" />
        <!-- Memo ends here -->

        <!-- Employment Record -->
        <EmployementRecord :Data="Data" />
        <!-- Employment Record ends here -->

        <!-- Movement -->
        <Movements :Data="Data" />
        <!-- Movement ends here -->

        <!-- Document -->
        <Documents :Data="Data" />
        <!-- Document ends here -->

        <!-- Medical Record -->
        <MedicalRecord :Data="Data" />
        <!-- Medical Record ends here -->

        <!-- Requirements -->
        <VCard style="margin:2vh;">
          <VToolbar color="primary" title="Requirements" />
          <VCardText>
            <VCard>
              <VTable>
                <thead>
                  <tr>
                    <th class="text-center" scope="col" width="50">
                      Completed
                    </th>
                    <th class="text-center" scope="col" width="100">
                      Requirement Name
                    </th>
                    <th class="text-center" scope="col">
                      Notes
                    </th>
                  </tr>
                </thead>
                <!-- 👉 table body -->
                <tbody>
                  <tr v-for="row in requirements" :key="row">
                    <td>
                      <VRow>
                        <VCol class="text-center ml-5">
                          <VCheckbox v-model="row.selectedCheckbox" :value="1" />
                        </VCol>
                      </VRow>

                      <VCol hidden>
                        <VTextField type="number" v-model="row.req_id" />
                      </VCol>
                    </td>

                    <td>
                      <VLabel><strong>{{ row.name }}</strong></VLabel>
                    </td>

                    <td>
                      <VTextField type="text" v-model="row.notes" />
                    </td>

                  </tr>
                </tbody>
              </VTable>
            </VCard>
          </VCardText>
        </VCard>
        <!-- Requirements ends here -->

        <!--submit and close-->
        <VCardText class="d-flex justify-end flex-wrap gap-3">
          <VRow>
            <VCol class="d-flex justify-end flex-wrap gap-3">
              <VBtn variant="tonal" color="error" @click="closeForm()">
                Close
              </VBtn>
              <VBtn type="submit">
                Update
              </VBtn>
            </VCol>
          </VRow>
        </VCardText>
        <!--submit and close end-->

      </VForm>
    </VCard>

    <v-overlay v-model="loading" id="container">
      <VProgressCircular indeterminate color="primary" id="loader"
        class="d-flex align-items-center justify-content-center" />
    </v-overlay>

    <!-- DIALOG FOR ADJUST CREDITS SICK-->
    <VDialog scrollable v-model="adjustLeaveCreaditsDialog" max-width="800">
      <adjustLeaveCreadits @textFieldData="handleLeaveCreditsData" :credit="props.employeesData.leave_credits_vacation"
        @close="adjustLeaveCreaditsDialog = false" />
    </VDialog>

    <!-- DIALOG FOR VIEW LEAVE ACRUAL SICK -->
    <VDialog scrollable v-model="viewLeaveAcrualDialog" max-width="1000">
      <viewLeaveAcrual @close="viewLeaveAcrualDialog = false"  :credit="props.employeesData.leave_credits_vacation"/>
    </VDialog>

    <!-- DIALOG FOR ADJUST CREDITS VACATION-->
    <VDialog scrollable v-model="adjustLeaveCreaditsVacation" max-width="800">
        <adjustLeaveVacation :vacation="VacationCreditData" @textFieldData="handleDataVacation" @close="adjustLeaveCreaditsVacation = false"/>
    </VDialog>

    <!-- DIALOG FOR VIEW LEAVE ACRUAL VACATION -->
    <VDialog scrollable v-model="viewLeaveVacation" max-width="1000">
        <viewLeaveAccuralVacation :vacation="VacationCreditData" @close="viewLeaveVacation=false" />
    </VDialog>
    <div class="snackbar-wrapper">
      <VSnackbar v-model="errorToastr" color="error" transition="fade-transition" location="bottom center">
        You Don't have Enough Leave Credits Left!
      </VSnackbar>
    </div>

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

#container {
  display: flex;
  align-items: center;
  justify-content: center;
  block-size: 100%;
}

  // /* Adjust the VCard style for screens smaller than 768px */
  // @media screen and (max-width: 768px) {
  //   VCard {
  //     max-height: none; /* Remove the max-height limit */
  //     overflow-y: auto; /* Add vertical scroll if needed */
  //   }
  // }
</style>
