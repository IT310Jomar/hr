<script lang="ts" setup>
import axios from 'axios';
import { ref } from 'vue';
import { requiredValidator } from '@/@core/utils/validators';
import { VForm } from 'vuetify/components';
import { environment } from '@/environments/environment';
import { toast } from 'vue3-toastify';

const emit = defineEmits(['form-submitted']);
const props = defineProps(['user_id', 'employee_id'])

const date_req = ref<string | null>(null)
const from = ref<string | null>(null)
const to = ref<string | null>(null)
const total_hours = ref<string | null>(null)
const reason = ref<string | null>(null)
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
        .post(environment.API_URL + 'user/undertime/request/store', {
            user_id: props.user_id,
            employee_id: props.employee_id,
            date_req: date_req.value,
            from: from.value,
            to: to.value,
            total_hours: total_hours.value,
            reason: reason.value,
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
            success.value = true;
            date_req.value = null; // clear the value of the VTextField
            from.value = null; // clear the value of the VTextField
            to.value = null; // clear the value of the VTextField
            total_hours.value = null; // clear the value of the VTextField
            reason.value = null; // clear the value of the VTextField
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
        <v-card-title>Undertime Application Forms</v-card-title>

        <VForm ref="refForm" @submit.prevent="submitted">
            <v-row class="py-5">
                <VCol cols="12" sm="6">
                    <v-text-field v-model="date_req" type="date" label="Date" :min="minDate" data-vv-as="Date Request"
                        :rules="[requiredValidator]" />
                </VCol>
                <VCol cols="12" sm="6">
                    <v-text-field v-model="from" type="time" label="From" data-vv-as="From" :rules="[requiredValidator]" />
                </VCol>
                <VCol cols="12" sm="6">
                    <v-text-field v-model="to" type="time" label="To" data-vv-as="To" :rules="[requiredValidator]" />
                </VCol>
                <VCol cols="12" sm="6">
                    <v-text-field type="number" v-model="total_hours" label="No. of Hours" data-vv-as="Total Hours"
                        :rules="[requiredValidator]" />
                </VCol>
            </v-row>
            <v-row>
                <VCol>
                    <VTextarea v-model="reason" label="Purpose/Reason" data-vv-as="Reason" :rules="[requiredValidator]" />
                </VCol>
            </v-row>
            <VBtn type="submit" class="float-right mt-10 mb-5">Apply
            </VBtn>
        </VForm>
    </section>
</template>
