<script setup lang="ts">
import { requiredValidator } from '@validators'
import axios from 'axios'
import { ref } from 'vue';
import { useToastr } from '@/toastr';
import { Options } from 'flatpickr/dist/types/options'

const toastr = useToastr();
const emit = defineEmits(['close', 'onSubmit', 'attendanceLogs','updated'])
const props = defineProps<Props>()
const emplist = ref([{ item: '--Select Employee--', value: null }])
const attendance_date = ref();
const attendance_time = ref();
const attendance_dateOut = ref();
const attendance_timeOut = ref();
const state = ref();
const attendanceId = ref();
const attendanceLogs = ref()

const dateConfig = computed(() => {
  const config: Options = {dateFormat: 'd-m-y'}
  return config
})

const timeConfig = computed(() => {
  const configTime: Options = {enableTime: true, noCalendar: true, dateFormat: 'H:i'}
  return configTime
})

const timeOutConfig = computed(() => {
  const configDate: Options = {enableTime: true, noCalendar: true, dateFormat: 'H:i'}
  return configDate
})

const dateOutConfig = computed(() => {
  const configTimes: Options = {dateFormat: 'd-m-y'}
  return configTimes
})

//props
interface Props {
  employee:any
  data:any
  id:any
}

//function for closing dialog
function closedialog() {
  emit('close')
}

onMounted(() => {
  //validate the data if != null then valdiate it again if the id = props.id then update the value of v-model from database
    if(props.data != null){
      if(props.data.id == props.id)
          attendanceId: attendanceId.value = props.data.id
          attendance_date: attendance_date.value = props.data.login
          attendance_time:  attendance_time.value = props.data.timeIn
          attendance_dateOut: attendance_dateOut.value = props.data.logout
          attendance_timeOut: attendance_timeOut.value = props.data.timeOut
          state: state.value = props.data.state
          emplist: emplist.value = props.data.employee_id
    }
})

//function for editing the logs of the employee
const editEmployeelogs = (id: any) => {
  axios.put('/api/user/attendance/editAttendance/' + id,{
    attendance_date: attendance_date.value,
    attendance_time: attendance_time.value,
    attendance_dateOut: attendance_dateOut.value,
    attendance_timeOut: attendance_timeOut.value,
    state: state.value,
    emplist: emplist.value
  }).then((response) => {
    if(response.data.success){
      emit('updated', response.data)
      closedialog()
      toastr.success('Updated Successfully!');
    }
  })
}

</script>

<template>
  <DialogCloseBtn @click.prevent="closedialog" />
  <VCard>
    <VCardText>
      <VRow>
        <VCol>
          <VCardTitle>
            Edit Logs
          </VCardTitle>
        </VCol>
      </VRow>
    </VCardText>
    <VDivider />
    <VCardText>
      <VRow>
        <VCol class="mb-5">
          <VSelect v-model="emplist" :items="props.employee" readonly item-title="item" item-value="value" label="Employee"
            :rules="[requiredValidator]" />
        </VCol>
      </VRow>
      <VRow>
        <VCol class="mb-5">
          <VCol hidden>
            <VTextField v-model="attendanceId"></VTextField>
          </VCol>
          <!-- <VTextField readonly v-model="attendance_date" label="Login Date" type="date" :rules="[requiredValidator]"></VTextField> -->

          <AppDateTimePicker
          :rules="[requiredValidator]"
            v-model="attendance_date"
            label="DD-MM-YYYY"
            :config="dateConfig"
            :style="{ zIndex: 1001 }"
          />
        </VCol>
      </VRow>
      <VRow>
        <VCol class="mb-5">
          <!-- <VTextField v-model="attendance_time" label="Time In" type="time" :rules="[requiredValidator]"></VTextField> -->

          <AppDateTimePicker
            :rules="[requiredValidator]"
                v-model="attendance_time"
                label="Time"
                :config="timeOutConfig"
                :style="{ zIndex: 1001 }"
              />
        </VCol>
      </VRow>
      <VRow>
        <VCol class="mb-5">
          <!-- <VTextField v-model="attendance_dateOut" label="Logout Date" type="date" :rules="[requiredValidator]"></VTextField> -->

          <AppDateTimePicker
          :rules="[requiredValidator]"
            v-model="attendance_dateOut"
            label="DD-MM-YYYY"
            :config="dateOutConfig"
            :style="{ zIndex: 1001 }"
          />
        </VCol>
      </VRow>
      <VRow>
        <VCol class="mb-5">
          <!-- <VTextField v-model="attendance_timeOut" label="Time Out" type="time" :rules="[requiredValidator]"></VTextField> -->

          <AppDateTimePicker
            :rules="[requiredValidator]"
              v-model="attendance_timeOut"
              label="Time"
              :config="timeConfig"
              :style="{ zIndex: 1001 }"
            />
        </VCol>
      </VRow>
      <VRow>
        <VCol class="mb-5">
          <VSelect v-model="state" label="State" :rules="[requiredValidator]"
            :items="[{ title: 'Log In', value: 'Check In' }, { title: 'Log Out', value: 'Check Out' }]" />
        </VCol>
      </VRow>
    </VCardText>
    <VCardText>
      <VRow>
        <VCol class="d-flex justify-end">
          <VBtn color="error" variant="tonal" @click.prevent="closedialog" class="mr-2">CLOSE</VBtn>
          <VBtn @click.prevent="editEmployeelogs(id)">SAVE</VBtn>
        </VCol>
      </VRow>
    </VCardText>
  </VCard>
</template>
