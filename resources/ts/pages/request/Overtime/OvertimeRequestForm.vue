<script lang="ts" setup>
import axios from 'axios';
import moment from 'moment';
import { requiredValidator } from '@/@core/utils/validators';
import { environment } from '@/environments/environment';
import { toast } from 'vue3-toastify';

const emit = defineEmits(['form-submit'])
const props = defineProps(['user_id', 'employee_id'])

const token = JSON.parse(localStorage.getItem('accessToken') || 'null')

const date = moment(new Date()).format('MM/DD/YYYY');
const scheduleDay = ref()
const scheduleClassification = ref()
const shiftDate = ref()
const shift_from = ref()
const shift_to = ref()
const otMinutes = ref()
const start = ref()
const end = ref()
const purpose = ref()
const dayOfWeek = ref()
const submit = ref(false)
const items = ['normal', 'early']

//For getting the current day
const date2 = new Date()
const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
const current_day = daysOfWeek[date2.getDay()]

// For disabling the previous date
var getDate = new Date();
var today_date = getDate.getDate();
var month = getDate.getMonth() + 1;
var year = getDate.getUTCFullYear();
var padded_month = month < 10 ? '0' + month : month;
var padded_today_date = today_date < 10 ? '0' + today_date : today_date;
var minDate = year + '-' + padded_month + '-' + padded_today_date;
// end here

const getData = async () => {
    axios.get(environment.API_URL + 'user/overtime/request/getdata', {
        params: {
            token: token
        }
    }).then(response => {
        for (let i = 0; i < response.data.overtimeRequest.length; i++) {
            for (let j = 0; j < response.data.overtimeRequest[i].schedule.length; j++) {
                if (dayOfWeek.value == response.data.overtimeRequest[i].schedule[j].day) {
                    scheduleDay.value = response.data.overtimeRequest[i].schedule[j].day
                    shift_from.value = moment(response.data.overtimeRequest[i].schedule[j].shift_start, 'hh:mm A').format('hh:mm A')
                    shift_to.value = moment(response.data.overtimeRequest[i].schedule[j].shift_end, 'hh:mm A').format('hh:mm A')
                }
            }
        }
    }).catch(error => {
        console.log('error')
    })
}

watch(shiftDate, () => {
    const shiftDateObj = new Date(shiftDate.value);
    dayOfWeek.value = daysOfWeek[shiftDateObj.getDay()];
});

watch([start && end], () => {
    let startVal = moment(start.value, "hh:mm A")
    let endVal = moment(end.value, "hh:mm A")

    if (endVal.isBefore(startVal)) {
        let temp = startVal
        startVal = endVal
        endVal = temp
    }
    otMinutes.value = endVal.diff(startVal, 'minutes');
})


const submitted = () => {
    axios.post('/api/user/overtime/request/store', {
        user_id: props.user_id,
        employee_id: props.employee_id,
        day: scheduleDay.value,
        shift_date: shiftDate.value,
        shift_from: moment(shift_from.value, 'HH:mm:ss').format('HH:mm:ss'),
        shift_to: moment(shift_to.value, 'HH:mm:ss').format('HH:mm:ss'),
        classification: scheduleClassification.value,
        start: start.value,
        end: end.value,
        purpose: purpose.value
    }).then((response) => {
        emit('form-submit', response.data)
        toast("Request Submitted.", {
            autoClose: 4000,
            type: 'success',
            theme: 'colored',
            style: {
                width: '350px' // Set the width to 400 pixels
            }
        })
        submit.value = true
        shiftDate.value = ''
        shift_from.value = null
        scheduleDay.value = null
        shift_to.value = null
        start.value = null
        end.value = null
        purpose.value = null
        otMinutes.value = null
        scheduleClassification.value = null
    }).catch((error) => {
        toast("Request Error!", {
            autoClose: 4000,
            type: 'error',
            theme: 'colored',
            style: {
                width: '350px' // Set the width to 400 pixels
            }
        })
    })

}

onMounted(async () => {
    await watch(dayOfWeek, async () => {
        await getData();
    });
})

</script>
<template>
    <section>
        <v-card-title>Overtime Application Form</v-card-title>
        <VRow>
            <v-col cols="12" sm="6">
                <v-card-text>
                    <strong>Date Submitted: {{ date }}</strong>
                </v-card-text>
                <v-card-text>
                    <strong>Shift Schedule: {{ shift_from }} - {{ shift_to }}</strong>
                </v-card-text>
            </v-col>
            <v-col cols="12">
                <VForm ref="refForm" @submit.prevent="submitted">
                    <v-table>
                        <thead>
                            <tr>
                                <th class="text-center">Shift</th>
                                <th class="text-center">Biometric Logs</th>
                                <th class="text-center">OT</th>
                                <th class="text-center">OT Minutes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center" style="width: 25%;">{{ shift_from }} To {{ shift_to }}</td>
                                <td class="text-center" style="width: 25%;">NO LOGS</td>
                                <td class="text-center" style="width: 25%;">NO OT</td>
                                <td class="text-center" style="width: 25%;">{{ otMinutes }}</td>
                            </tr>
                        </tbody>
                    </v-table>
                    <VSpacer />
                    <v-table>
                        <thead>
                            <tr>
                                <th class="text-center">Day</th>
                                <th class="text-center">Shift Date</th>
                                <th class="text-center">Shift from</th>
                                <th class="text-center">To</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center" style="width: 25%;">
                                    <VTextField type="text" v-model="scheduleDay" readonly variant="filled" />

                                </td>
                                <td class="text-center" style="width: 25%;">
                                    <v-text-field type="date" v-model="shiftDate" :min="minDate" :rules="[requiredValidator]" />
                                </td>
                                <td class="text-center" style="width: 25%;">
                                    <VTextField :value="shift_from" readonly variant="filled" />
                                </td>
                                <td class="text-center" style="width: 25%;">
                                    <VTextField :value="shift_to" readonly variant="filled" />
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                    <v-card-text>Pre-approved Overtime Hours</v-card-text>
                    <v-row>
                        <v-col cols="12" sm="4">
                            <VSelect id="select" v-model="scheduleClassification" :items="items" label="classification"
                                :rules="[requiredValidator]" />
                        </v-col>
                        <v-col cols="12" sm="4">
                            <VTextField type="time" label="Start" v-model="start" :rules="[requiredValidator]" />
                        </v-col>
                        <v-col cols="12" sm="4">
                            <VTextField type="time" label="End" v-model="end" :rules="[requiredValidator]" />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <VTextarea v-model="purpose" label="Indicate Ticket Number (If Applicable) - Task/Purpose"
                                :rules="[requiredValidator]" />
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <VBtn type="submit" class="float-right ">Apply</VBtn>
                        </v-col>
                    </v-row>
                </VForm>
            </v-col>
        </VRow>
    </section>
</template>