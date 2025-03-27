<script lang="ts" setup>
import AppDateTimePicker from '@core/components/AppDateTimePicker.vue'
import { emailValidator, requiredValidator } from '@validators'
import axios from 'axios';
import { useToastr } from '@/toastr';
import { environment } from '@/environments/environment';

const dateTime = ref(null);
const employee = ref();
const account = ref();
const teamLeader = ref();
const incident = ref();
const selectEmployee = ref([{ item: '', value: null }]);
const offenseLevel = ref();
const offense = ref();
const incidentData = ref();
const failed = ref(false);
const incidentForm = ref();
const toastr = useToastr();

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

//function for getting the data from database (offense_level table)
const getOffense = () => {
  axios.get(environment.API_URL +'user/employees/getEmploymentOptions')
  .then((response) => {
    if (response.data.success) {
      offense.value = response.data.offense
    }
  }).catch((error) => {
    // console.log(error)
  })
}
//function for submitting input data into database
const submitIncident = () => {
  axios.post(environment.API_URL +'user/incidentreport/store', {
    selectEmployee: selectEmployee.value,
    account: account.value,
    teamLeader: teamLeader.value,
    incident: incident.value,
    dateTime: dateTime.value,
    offenseLevel: offenseLevel.value
  }).then((response) => {
    if (response.data.success) {
      incidentData.value = response.data.incident
      incidentForm.value.reset()
      dateTime.value = null
      toastr.success('Added Successfully!');
    }
  }).catch((error) => {
    toastr.error('Error! Please check your fields!');
  })
}

const handleSubmit = () => {
  getEmployee();
  getOffense();
};

onMounted(() => {
  handleSubmit()
})
</script>

<template>
  <section>
    <VCard>
      <VForm ref="incidentForm">
        <VToolbar color="primary" title="Incident Report" class="headline"></VToolbar>
        <VCardText>
          <VRow>
            <VCol>
              <VRow>
                <VCol cols="12" class="mb-10 mt-2">
                  <strong>Employee</strong>
                  <VSelect v-model="selectEmployee" :items="employee" item-title="item" item-value="value" :rules="[requiredValidator]" variant="underlined" />
                </VCol>
              </VRow>
              <VRow>
                <VCol class="mb-10">
                  <strong>Account</strong>
                  <VTextField v-model="account" variant="underlined" :rules="[requiredValidator]"></VTextField>
                </VCol>
                <VCol>
                  <strong>Team Leader</strong>
                  <VTextField v-model="teamLeader" variant="underlined" :rules="[requiredValidator]"></VTextField>
                </VCol>
              </VRow>
            </VCol>
          </VRow>
        </VCardText>
        <VCardText>
          <VRow>
            <VCol class="mb-10">
              <strong>Incident</strong>
              <VTextField v-model="incident" variant="underlined" :rules="[requiredValidator]"></VTextField>
            </VCol>
          </VRow>
        </VCardText>
        <VCardText>
          <VRow>
            <VCol>
              <strong>Date Time of Incident</strong>
              <AppDateTimePicker v-model="dateTime" :config="{ enableTime: true, dateFormat: 'Y-m-d H:i' }" variant="underlined" />
            </VCol>
            <VCol>
              <strong>Offense Level</strong>
              <VSelect v-model="offenseLevel" :items="offense" item-title="name" item-value="id" variant="underlined" :rules="[requiredValidator]" />
            </VCol>
          </VRow>
        </VCardText>
        <VDivider class="mt-5"/>
        <VCardText>
          <VRow>
            <VCol class="text-right"> <VBtn @click.prevent="submitIncident">SUBMIT</VBtn> </VCol>
          </VRow>
        </VCardText>
      </VForm>
    </VCard>
    <VSnackbar color="error" v-model="failed"> Failed </VSnackbar>
  </section>
</template>
