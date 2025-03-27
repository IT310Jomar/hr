<script lang="ts" setup>
import axios from 'axios';
import { ref } from 'vue';
import { requiredValidator } from '@/@core/utils/validators';
import { VForm } from 'vuetify/components';
import { environment } from '@/environments/environment';
import { toast } from 'vue3-toastify';

const emit = defineEmits(['form-submitted'])
const props = defineProps(['user_id', 'employee_id'])

const date_from = ref()
const date_to = ref()
const time_from = ref()
const time_to = ref()
const location = ref()
const purpose = ref()
const success = ref(false)
const failed = ref(false)
const submit = ref(false)

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
        .post(environment.API_URL + 'user/business/request/store', {
            user_id: props.user_id,
            employee_id: props.employee_id,
            date_from: date_from.value,
            date_to: date_to.value,
            time_from: time_from.value,
            time_to: time_to.value,
            location: location.value,
            purpose: purpose.value,
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
            time_from.value = null; // clear the value of the VTextField
            time_to.value = null; // clear the value of the VTextField
            location.value = null; // clear the value of the VTextField
            purpose.value = null; // clear the value of the VTextField
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
        <v-card-title class="mb-5">Official Business Form</v-card-title>

        <VForm ref="refForm" @submit.prevent="submitted">
            <v-row>
                <VCol cols="12" sm="6" class="px-5">
                    <VTextField v-model="date_from" type="date" :min="minDate" label="From" data-vv-as="Date From"
                        :rules="[requiredValidator]" />
                </VCol>
                <VCol cols="12" sm="6" class="px-5">
                    <VTextField v-model="date_to" type="date" :min="minDate" label="To" data-vv-as="Date To"
                        :rules="[requiredValidator]" />
                </VCol>
                <VCol cols="12" sm="6" class="px-5">
                    <VTextField v-model="time_from" type="time" label="From" data-vv-as="Time From"
                        :rules="[requiredValidator]" />
                </VCol>
                <VCol cols="12" sm="6" class="px-5">
                    <VTextField v-model="time_to" type="time" label="To" data-vv-as="Time To"
                        :rules="[requiredValidator]" />
                </VCol>

                <VCol class="px-5">
                    <VTextarea v-model="location" label="Location" class="mb-5" data-vv-as="Location"
                        :rules="[requiredValidator]" />
                    <VTextarea v-model="purpose" label="Purpose" data-vv-as="Purpose" :rules="[requiredValidator]" />
                </VCol>
            </v-row>
            <VBtn type="submit" class="float-right mt-10 mb-5">Apply</VBtn>
        </VForm>
    </section>
</template>
