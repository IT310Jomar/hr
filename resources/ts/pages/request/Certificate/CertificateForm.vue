<script lang="ts" setup>
import AppDateTimePicker from '@/@core/components/AppDateTimePicker.vue';
import axios from 'axios';
import { watch, Ref } from 'vue';
import { requiredValidator } from '@/@core/utils/validators';
import { environment } from '@/environments/environment';
import { toast } from 'vue3-toastify';
import moment from 'moment';

const emit = defineEmits(['form-Submitted'])
const props = defineProps(['Certificate', 'attendanceData', 'empData'])

const attendanceId = ref()
const user_id = ref()
const state = ref([])
const attendance_date = ref([])
const attendance_time = ref([])
const employee_id = ref()
const remarks = ref()
const others = ref('')
const showTextField = ref(false)
const submit = ref(false)
const isFlatSnackbarVisible = ref(false)
const selectedItem = ref()
const stateType = ref([
    { title: 'In', value: 'Check In' },
    { title: 'Out', value: 'Check Out' }
])
const items = ref([
    { title: 'Biometric device malfunction', value: '0' },
    { title: 'Power Outage', value: '1' },
    { title: 'Others', value: '2' }

])

//for setting current date 
const date1 = new Date();
const year2 = date1.getFullYear();
const month2 = (date1.getMonth() + 1).toString().padStart(2, '0'); // add leading zero if needed
const day = date1.getDate().toString().padStart(2, '0'); // add leading zero if needed
const currentDate = `${year2}-${month2}-${day}`;

// For disabling the previous date
var date = new Date();
var today_date = date.getDate();
var month = date.getMonth() + 1;
var year = date.getUTCFullYear();
var padded_month = month < 10 ? '0' + month : month;
var padded_today_date = today_date < 10 ? '0' + today_date : today_date;
var minDate = year + '-' + padded_month + '-' + padded_today_date;
// end here

// 👉 Add item function
const addItem = () => {
    if (props.Certificate.Attendance.length < 2) {
        props.Certificate.Attendance.push({
            state: state.value = [],
            attendance_date: attendance_date.value = [],
            attendance_time: attendance_time.value = [],
        });
    } else {
        toast("Limit to 2 add only!", {
            autoClose: 4000,
            type: 'warning',
            theme: 'colored',
            style: {
                width: '350px' // Set the width to 400 pixels
            }
        })
    }
};


// 👉 Remove Product edit section
const removeProduct = (id: number) => {
    props.Certificate.Attendance.splice(id, 1)
}

//Watch the selectedItem
watch(selectedItem, () => {
    if (selectedItem.value === '0') {
        selectedItem.value = items.value[0].title;
        showTextField.value = false;
    }
    else if (selectedItem.value === '1') {
        selectedItem.value = items.value[1].title;
        showTextField.value = false;
    }
    else if (selectedItem.value === '2') {
        showTextField.value = true;
    }
})


const onSubmit = () => {
    if (selectedItem.value === '2') {
        selectedItem.value = others.value
    }
    axios.post(environment.API_URL + 'user/attendance/request/store', {
        user_id: user_id.value,
        attendanceId: attendanceId.value,
        employee_id: employee_id.value,
        attendance: props.Certificate.Attendance,
        type: selectedItem.value || others.value,
        remarks: remarks.value
    }).then((response) => {
        console.log(response.data)
        if (response.data.success) {
            submit.value = true
            emit('form-Submitted', response.data)
            toast("Request Submitted.", {
                autoClose: 4000,
                type: 'success',
                theme: 'colored',
                style: {
                    width: '350px' // Set the width to 400 pixels
                }
            })
            user_id.value = ''
            employee_id.value = ''
            props.Certificate.Attendance = []
            remarks.value = ''
            selectedItem.value = ''
            others.value = ''
        } else if (response.data.error1) {
            toast("An existing record already exists.", {
                autoClose: 4000,
                type: 'warning',
                theme: 'colored',
                style: {
                    width: '350px' // Set the width to 400 pixels
                }
            })
        } else if (response.data.error2) {
            toast("You need to request check in first.", {
                autoClose: 4000,
                type: 'warning',
                theme: 'colored',
                style: {
                    width: '350px' // Set the width to 400 pixels
                }
            })
        } else if (response.data.error3) {
            toast("The date should be the same.", {
                autoClose: 4000,
                type: 'warning',
                theme: 'colored',
                style: {
                    width: '350px' // Set the width to 400 pixels
                }
            })
        }else if (response.data.error4) {
            toast("It should be In and Out.", {
                autoClose: 4000,
                type: 'warning',
                theme: 'colored',
                style: {
                    width: '350px' // Set the width to 400 pixels
                }
            })
        }
    }).catch((error) => {
        if (error.response.data.error) {
            toast("Request Error!", {
                autoClose: 4000,
                type: 'error',
                theme: 'colored',
                style: {
                    width: '350px' // Set the width to 400 pixels
                }
            })
        }
    })
}
watch(state, () => {
    if (props.attendanceData !== null) {
        for (let i = 0; i < props.attendanceData.length; i++) {
            user_id.value = props.attendanceData[i].user_id
            employee_id.value = props.attendanceData[i].id
            for (let j = 0; j < props.attendanceData[i].attendance_logs.length; j++) {
                let counter = props.attendanceData[i].attendance_logs.length - 1;
                if (props.attendanceData[i].attendance_logs[counter].login != currentDate) {
                    attendanceId.value = ''

                } else {
                    attendanceId.value = props.attendanceData[i].attendance_logs[j].id
                }
            }
        }
    }
})

onMounted(() => {

})
</script>
<template>
    <section>
        <v-card-text>
            <v-card-title>Certificate of Attendance Application Form</v-card-title>
            <v-divider />
            <VForm ref="refForm" @submit.prevent="onSubmit">
                <v-row class="mt-5">
                    <v-col cols="12" sm="5">
                        <VSelect variant="filled" v-model="selectedItem" :items="items" item-title="title"
                            item-value="value" label="Type">
                        </VSelect>
                        <VTextField class="py-3" v-if="showTextField" label="Others" variant="filled" v-model="others">
                        </VTextField>
                        <v-textarea v-model="remarks" class="mt-2" variant="underlined" label="Remarks"></v-textarea>
                        <VTextField hidden v-model="employee_id" />
                        <VTextField hidden v-model="user_id" />
                    </v-col>
                    <v-col cols="12" sm="7">
                        <VTable>
                            <thead>
                                <tr>
                                    <th width="50px;">Type</th>
                                    <th width="150px;" class="text-center">Date</th>
                                    <th width="150px;" class="text-center">Time</th>
                                    <th width="50px;"></th>
                                </tr>
                            </thead>
                            <!-- 👉 table body -->
                            <tbody class="clearfix" v-if="props.Certificate.Attendance.length > 0">
                                <tr v-for="Attendance in props.Certificate.Attendance" :key="Attendance">
                                    <td class="text-Left" scope="col" width="20%">
                                        <VSelect v-model="Attendance.state" :items="stateType" item-title="title"
                                            item-value="value" width="auto" variant="underlined" />
                                    </td>
                                    <td>
                                        <VTextField v-model="Attendance.attendance_date" :min="minDate" type="date" />
                                    </td>
                                    <td>
                                        <VTextField v-model="Attendance.attendance_time" type="time">
                                        </VTextField>
                                    </td>
                                    <td>
                                        <VBtn icon size="x-small" @click="removeProduct" color="error" variant="text">
                                            <VIcon size="22" icon="tabler-trash" />
                                        </VBtn>
                                    </td>
                                </tr>
                            </tbody>
                        </VTable>
                        <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
                            <VCol class="text-right clearfix">
                                <VBtn @click="addItem" size="small">
                                    Add
                                    <VIcon size="small" icon="tabler:plus" />
                                </VBtn>
                            </VCol>
                        </VCardText>
                        <v-divider class="mt-10 mb-10" />
                        <div class="text-right">
                            <VBtn type="submit" @click="isFlatSnackbarVisible = true">Submit</VBtn>
                        </div>

                    </v-col>
                </v-row>
            </VForm>
        </v-card-text>
    </section>
</template>