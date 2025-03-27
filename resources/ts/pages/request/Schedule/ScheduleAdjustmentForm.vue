<script lang="ts" setup>
import axios from 'axios';
import { ref } from 'vue';
import { requiredValidator } from '@/@core/utils/validators';
import { VForm } from 'vuetify/components';
import { environment } from '@/environments/environment';
import { toast } from 'vue3-toastify';

const emit = defineEmits(['form-submitted'])
const props = defineProps(['user_id', 'employee_id'])

const note = 'If you add value on Date From and Date To and Rest Day is checked, it will be considered as working on a rest day.'
const date_from = ref()
const date_to = ref()
const shift_start = ref()
const break_start = ref()
const break_end = ref()
const shift_end = ref()
const submit = ref(false)
const isFlatSnackbarVisible = ref(false);

// For disabling the previous date
var date = new Date();
var today_date = date.getDate();
var month = date.getMonth() + 1;
var year = date.getUTCFullYear();
var padded_month = month < 10 ? '0' + month : month;
var padded_today_date = today_date < 10 ? '0' + today_date : today_date;
var minDate = year + '-' + padded_month + '-' + padded_today_date;
// end here

const submitted = () => {
    axios
        .post(environment.API_URL + 'user/schedule/adjustment/store', {
            user_id: props.user_id,
            employee_id: props.employee_id,
            date_from: date_from.value,
            date_to: date_to.value,
            shift_start: shift_start.value,
            break_start: break_start.value,
            break_end: break_end.value,
            shift_end: shift_end.value,
        })
        .then((response) => {
            emit('form-submitted', response.data);
            toast("Request Submitted.", {
                autoClose: 4000,
                type: 'success',
                theme: 'colored',
                style: {
                    width: '350px' // Set the width to 400 pixels
                }
            })
            date_from.value = null; // clear the value of the VTextField
            date_to.value = null; // clear the value of the VTextField
            shift_start.value = null; // clear the value of the VTextField
            break_start.value = null; // clear the value of the VTextField
            break_end.value = null; // clear the value of the VTextField
            shift_end.value = null; // clear the value of the VTextField
            submit.value = true;
        })
        .catch((error) => {
            toast("Request Error!", {
                autoClose: 4000,
                type: 'error',
                theme: 'colored',
                style: {
                    width: '350px' // Set the width to 400 pixels
                }
            })
        });
};
</script>
<template>
    <section>
        <VCardText>
            <v-card-title>Schedule Adjustment Application Form</v-card-title>
            <VDivider />
            <VForm ref="refForm" @submit.prevent="submitted">
                <v-row>
                    <v-col>
                        <v-window>
                            <v-card-text class="font-weight-bold">NOTE:</v-card-text>
                            <v-window-item class="ml-7">{{ note }} </v-window-item>
                        </v-window>
                    </v-col>
                    <v-col class="ml-10">
                        <v-card-text class="font-weight-bold">Effective Date</v-card-text>
                        <v-row class="pb-2">
                            <v-text-field type="date" class="pr-1 mb-2" v-model="date_from" :min="minDate" data-vv-as="Date From"
                                label="From" :rules="[requiredValidator]" />
                            <v-text-field type="date" class="pr-1 mb-2" v-model="date_to" :min="minDate" data-vv-as="Date To" label="To"
                                :rules="[requiredValidator]" />
                        </v-row>
                        <v-card-text class="font-weight-bold">Requested Schedule</v-card-text>
                        <v-row>
                            <v-text-field type="time" class="pr-1 mb-2" v-model="shift_start" data-vv-as="Shift Start"
                                label="Shift Start" :rules="[requiredValidator]" />
                            <v-text-field type="time" class="pr-1 mb-2" v-model="break_start" data-vv-as="Break Start"
                                label="Break Start" :rules="[requiredValidator]" />
                        </v-row>
                        <v-row class="mt-10 ">
                            <v-text-field type="time" class="pr-1 mb-2" v-model="break_end" data-vv-as="Break End"
                                label="Break End" :rules="[requiredValidator]" />
                            <v-text-field type="time" class="pr-1 mb-2" v-model="shift_end" data-vv-as="Shift End"
                                label="Shift End" :rules="[requiredValidator]" />
                        </v-row>
                    </v-col>
                </v-row>
                <div class="text-right mt-10">
                    <VBtn type="submit" @clik.prevent="isFlatSnackbarVisible = true">Submit</VBtn>
                </div>
            </VForm>
        </VCardText>
    </section>
</template>
