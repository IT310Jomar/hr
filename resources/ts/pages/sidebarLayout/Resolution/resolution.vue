<script setup lang="ts">
import Unresolveview from '@/pages/resolution/Unresolveview.vue';
import Unresolveedit from '@/pages/resolution/Unresolveedit.vue';
import axios from 'axios';
import { Options } from 'flatpickr/dist/types/options';
import { ref } from 'vue';
import CashAdvancePending from './VWindows/CashAdvancePending.vue';
import OfficialBusiness from './VWindows/OfficialBusiness.vue';
import ScheduleAdjustment from './VWindows/ScheduleAdjustment.vue';
import ScheduleAttendance from './VWindows/ScheduleAttendance.vue';
import LeaveRequest from './VWindows/LeaveRequest.vue';
import Undertime from './VWindows/Undertime.vue';
import OvertimeRequest from './VWindows/OvertimeRequest.vue';
import { environment } from '@/environments/environment';

const selectedItem = ref()
const selectedItem1 = ref()
const employeeNames = ref()
const departments = ref()


const dfrom = ref('')
const dto = ref('')
const token = JSON.parse(localStorage.getItem('accessToken') || 'null');

const tab = ref()
const inputs = ref()
const company = ref()
const types = ref()
const selectedTypes = ref()
const startDateTimePickerConfig = computed(() => {
  const config: Options = { dateFormat: 'Y-m-d' }
  return config
})

const endDateTimePickerConfig = computed(() => {
  const config: Options = { dateFormat: 'Y-m-d' }
  return config
})

const getCompany = () => {
  axios.get(environment.API_URL + 'user/resolution/get-compay', { params: { token: token } } )
  .then(response => {
    company.value = []
    if(response.data.success) {
      if(response.data.company) {
        for(var i = 0 ; i < response.data.company.length ; i++) {
          company.value.push({
            item : response.data.company[i].company_name,
            value : response.data.company[i].id,
          })
        }
      }
    }
  })
}

const getTypes = () => {
  axios.get(environment.API_URL + 'user/resolution/get-types', { params: { token: token } } )
  .then(response => {
    types.value = []
    if(response.data.success) {
      if(response.data.types) {
        types.value = response.data.types
      }
    }
  })
}

const getEmployee = () => {
  axios.get(environment.API_URL + 'user/employees/getEmployee', { params: { token: token } })
    .then(response => {
      if (response.data.success) {
        if (response.data.employees) {
          employeeNames.value = []
          for (var i = 0; i < response.data.employees.length; i++) {
            employeeNames.value.push({
              item: response.data.employees[i].last_name + ' ' + response.data.employees[i].first_name + ' ' + response.data.employees[i].middle_name,
              value: response.data.employees[i].id
            })
          }
        }
      }
    })
}

const getDepartments = () => {
  axios.get(environment.API_URL + 'user/employees/getEmploymentOptions', { params: { token: token } })
    .then(response => {
      if (response.data.success) {
        if (response.data.departments) {
          departments.value = []
          for (var i = 0; i < response.data.departments.length; i++) {
            departments.value.push({
              item: response.data.departments[i].name,
              value: response.data.departments[i].id,
            })
          }
        }
      }
    })
}

watch([dfrom, dto, selectedItem1, selectedItem, selectedTypes], () => {
  if (dfrom.value != '' || dto.value != '' || selectedItem1.value != '' || selectedItem.value != '' || selectedTypes.value != null ) {
    inputs.value = [{
      dateFrom : dfrom.value,
      dateTo : dto.value,
      empID : selectedItem1.value,
      dept : selectedItem.value,
      types : selectedTypes.value,
    }]
  } 
});


const initializeData = () => {
  getEmployee()
  getDepartments()
  getCompany()
  getTypes()
}

onMounted(() => {
  initializeData()

})

</script>
<template>
  <section>
    <VCard title="Resolution Center" >
      <VDivider />
      <VRow>
        <VCol cols="4">
          <VCard class="my-3 ml-3">
            <VCardText>
                <p class="card-text">Narrow your results</p>
                <label for="filter_date_from" class="form-label">From Date</label>
                <AppDateTimePicker :key="JSON.stringify(startDateTimePickerConfig)" v-model="dfrom" label="YYYY-MM-DD"
                  :config="startDateTimePickerConfig" />
                <br>
                <label for="filter_date_to" class="form-label">To Date</label>
                <AppDateTimePicker :key="JSON.stringify(endDateTimePickerConfig)" v-model="dto" label="YYYY-MM-DD"
                  :config="endDateTimePickerConfig" />
                <br>
                <label for="filter_date_from" class="form-label">Company</label>
                <VSelect :items="company" item-title="item" item-value="value" label="Specialized Outsource Partner, Inc." />
                <br>
                <label for="filter_date_from" class="form-label">Department</label>
                <VCombobox v-model="selectedItem" :items="departments" item-title="item" item-value="value" />
                <br>
                <label for="filter_date_from" class="form-label">Employee</label>
                <VCombobox v-model="selectedItem1" :items="employeeNames" item-title="item" item-value="value" />
                <br>
                <label for="filter_date_from" class="form-label">Types</label>
                <v-checkbox v-model="selectedTypes"  v-for="(type) in types" :key="type" :label="type.name" :value="type.id"></v-checkbox>
            </VCardText>
          </VCard>
        </VCol>
        <VCol cols="8">
          <VCard class="my-3 mr-3" >
            <VCardText>
              <!--  -->
              <VTabs v-model="tab" class="mb-5">
                <VTab value="cash-advance">
                  Cash Advance
                </VTab>

                <VTab value="sick-vacation">
                  Sick / Vacation Leave
                </VTab>

                <VTab value="certificate-attendance">
                  Certificate of Attendance
                </VTab>

                <VTab value="schedule-adjustment">
                  Schedule Adjustment
                </VTab>

                <VTab value="undertime">
                  Undertime
                </VTab>

                <VTab value="overtime">
                 Overtime
                </VTab> 

                <VTab value="official-b">
                 Official Business
                </VTab> 
              </VTabs>
              <VDivider/>
            <div class="card-block h-50 vb-content">
              <!-- Cash advance Here -->
              <VWindow v-model="tab">
                <VWindowItem value="cash-advance"> <br>
                  <CashAdvancePending :inputs="inputs" />
                </VWindowItem>
                <!-- Official Business Here -->
                <VWindowItem value="official-b"> <br>
                  <OfficialBusiness :inputs="inputs" />
                </VWindowItem>
                <!-- Schedule Adjustment Here -->
                <VWindowItem value="schedule-adjustment"> <br>
                  <ScheduleAdjustment :inputs="inputs" />
                </VWindowItem>
                <!-- Certificate Attendance Here -->
                <VWindowItem value="certificate-attendance"> <br>
                  <ScheduleAttendance :inputs="inputs" />
                </VWindowItem>
                <!-- Leave Request -->
                <VWindowItem value="sick-vacation"> <br>
                  <LeaveRequest :inputs="inputs" />
                </VWindowItem>
                <!-- Undertime Request -->
                <VWindowItem value="undertime"> <br>
                  <Undertime :inputs="inputs" />
                </VWindowItem>
                <!-- Overtime Request -->
                <VWindowItem value="overtime"> <br>
                  <OvertimeRequest :inputs="inputs" />
                </VWindowItem>
              </VWindow>
            </div>
          </VCardText>
          </VCard>
        </VCol>
      </VRow>
    </VCard>
  </section>
</template>

