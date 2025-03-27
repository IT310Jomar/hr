<script setup lang="ts">
import type { VForm } from 'vuetify/components'
import { emailValidator, requiredValidator } from '@validators'
import axios from 'axios'
import { ref } from 'vue';
import { useToastr } from '@/toastr';
import AppDateTimePicker from '@/@core/components/AppDateTimePicker.vue';
import { toast } from 'vue3-toastify';
import { config } from 'process';
import { Options } from 'flatpickr/dist/types/options'

const refForm = ref<VForm>()
const toastr = useToastr();
const emit = defineEmits(['dataValues', 'close', 'onSubmit'])
const isattendanceValid = ref(false)
const memoForm = ref();
const attendance_date = ref('');
const attendance_time = ref();
const props = defineProps<Props>()
const state = ref();
const attendanceId = ref();
const user_id = ref();
const date = new Date();
const year = date.getFullYear();
const month = (date.getMonth() + 1).toString().padStart(2, '0'); // add leading zero if needed
const day = date.getDate().toString().padStart(2, '0'); // add leading zero if needed
const currentDate = `${year}-${month}-${day}`;
const emplist = ref([{ item: '--Select Employee--', value: null }])
const dateClose = ref(false)

const dateConfig = computed(() => {
  const config: Options = {dateFormat: 'Y-m-d'}
  return config
})

const timeConfig = computed(() => {
  const config: Options = {enableTime: true, noCalendar: true, dateFormat: 'H:i'}
  return config
})

watch([attendanceId, user_id, emplist, attendance_date, attendance_time, state], ([idValue, user_id, selectedValue, dateValue, timeValue, stateValue]) => {
  emit('dataValues', {
    attendanceId: idValue,
    emplist: selectedValue,
    attendance_date: dateValue,
    attendance_time: timeValue,
    state: stateValue,
    user_id : user_id
  })

})

function closedialog() {
  emit('close')
}

const isDialogVisible = () => {
  props.isDialogSubmit()
  closedialog()
}

const PostAttendance = () => {
  refForm.value?.validate()
    .then(({ valid: isValid }) => {
      if (isValid) {
        isDialogVisible()
      } else {
        toast("Please double check your fields", {
          autoClose: 4000,
          type: 'error',
          theme: 'colored'
        })
      }
    })
}


//props
interface Props {
  employee:any
  attendanceData: any
  isDialogSubmit: Function
}
//props end

onMounted(() => {
  watch(emplist,(selectedValue) => {
    if (props.attendanceData != null) {
      console.log(currentDate, "Current Date")
      // console.log(props.attendanceData, "Props Attendance")
      for (var t = 0; t < props.attendanceData.length; t++) {
           for(var x = 0; x < props.attendanceData[t].attendance_logs.length; x++){
            if (props.attendanceData[t].attendance_logs[x].employee_id == selectedValue) {
             let dataID = props.attendanceData[t].attendance_logs.length - 1;
             if(props.attendanceData[t].attendance_logs[dataID].login != currentDate){
                attendanceId : attendanceId.value = ''
                user_id : user_id.value  = props.attendanceData[t].user_id
             } else {
              attendanceId: attendanceId.value = props.attendanceData[t].attendance_logs[dataID].id
              user_id : user_id.value  = props.attendanceData[t].user_id
             }
           }
          }
        attendance_date: attendance_date.value = currentDate
        
      }
    }
  })
})
</script>

<template>
  <!-- Dialog close btn -->
  <DialogCloseBtn @click.prevent="closedialog" />
  <!-- Dialog Content -->
  <VCard title="Add Logs">
    <VForm ref="refForm">
    <VDivider class="mt-3" />
    <VCardText>
      <VRow>
          <VCol cols="12">
            <VListItemTitle style=" font-size: 15px;">
              Employee
            </VListItemTitle>
            <VSelect v-model="emplist" :rules="[requiredValidator]" :items="props.employee" item-title="item"
              item-value="value" type="text" width="auto" />
          </VCol>
          <VCol cols="12" sm="6" md="4">
            <VListItemTitle style=" font-size: 15px;">
              Date
            </VListItemTitle >
            <VCol Hidden>
              <VTextField  v-model="attendanceId" />
              <VTextField  v-model="user_id" />
            </VCol>
            <AppDateTimePicker
            :rules="[requiredValidator]"
              v-model="attendance_date"
              label="DD-MM-YYYY"
              :config="dateConfig"
              :style="{ zIndex: 1001 }"
            />
          </VCol>
          <VCol cols="12" sm="6" md="4">
            <VListItemTitle style=" font-size: 15px;">
              Time
            </VListItemTitle>
            <!-- <VTextField type="time" v-model="attendance_time" :rules="[requiredValidator]" /> -->

            <AppDateTimePicker
            :rules="[requiredValidator]"
              v-model="attendance_time"
              label="Time"
              :config="timeConfig"
              :style="{ zIndex: 1001 }"
            />

          </VCol>
          <VCol>
            <VListItemTitle style=" font-size: 15px;">
              State
            </VListItemTitle>
            <VSelect v-model="state" label="State" :rules="[requiredValidator]"
              :items="[{ title: 'Log In', value: 'Check In' }, { title: 'Log Out', value: 'Check Out' }]" />
          </VCol>
      </VRow>
    </VCardText>
    <VDivider />
    <VCardText class="d-flex justify-end flex-wrap gap-2">
      <VBtn variant="tonal" color="on-secondary" @click.prevent="closedialog">
        Cancel
      </VBtn>
      <VBtn @click.prevent="PostAttendance">
        Save
      </VBtn>
    </VCardText>
    </VForm>
  </VCard>
</template>
<style>
.dialog {
  z-index: 9999;
}
</style>
