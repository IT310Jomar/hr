<script lang="ts" setup>
import axios from 'axios';
import { ref } from 'vue';
import { requiredValidator } from '@/@core/utils/validators';
import { VForm } from 'vuetify/components';
import { environment } from '@/environments/environment';
import { toast } from 'vue3-toastify';

const emit = defineEmits(['form-submitted']);
const props = defineProps(['user_id', 'employee_id'])

const requested_date = ref();
const amount = ref();
const reasons = ref();
const isFlatSnackbarVisible = ref(false);
const submit = ref(false);

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
    const amountValue = amount.value ? parseFloat(amount.value) : null;
    if (amountValue !== null && amountValue < 0) {
        // Display an error message or take appropriate action for negative amount
        toast("Please enter positive number.", {
            autoClose: 4000,
            type: 'error',
            theme: 'colored',
            style: {
                width: '350px' // Set the width to 400 pixels
            }
        })
        return;
    }

    axios
        .post(environment.API_URL + 'user/cash/advance/createrequest', {
            user_id: props.user_id,
            employee_id: props.employee_id,
            requested_date: requested_date.value,
            amount: amount.value,
            reasons: reasons.value,
        })
        .then((response) => {
            if (response.data.success) {
                emit('form-submitted', response.data);
                toast("Submitted Successfully!", {
                    autoClose: 4000,
                    type: 'success',
                    theme: 'colored',
                    style: {
                        width: '350px' // Set the width to 400 pixels
                    }
                })
                requested_date.value = null; // clear the value of the VTextField
                amount.value = null; // clear the value of the VTextField
                reasons.value = null; // clear the value of the VTextField
                submit.value = true;
                setTimeout(() => {
                }, 1000)
            }
        })
        .catch((error) => {
            toast("Submission Error! ", {
                autoClose: 4000,
                type: 'error',
                theme: 'colored',
                style: {
                    width: '350px' // Set the width to 400 pixels
                }
            })
        });
};

const positiveValidator = (value: any) => {
    if (value < 0) {
        return 'Please enter a positive value.'
    }
    return true
}

</script>

<template>
    <section>
        <VCol cols="12" class="d-flex flex-column>">
            <VCard class="pa-5 flex-grow-1">
                <v-card-title>Request Cash Advance</v-card-title>
                <VDivider />
                <VCardText>
                    <VForm ref="refForm" @submit.prevent="submitted" @keydown.enter.prevent="submitted">
                        <div class="px-10">
                            <v-row>
                                <v-col>
                                    <v-card-text>Date Requested</v-card-text>
                                    <VTextField v-model="requested_date" :min="minDate" width="10px" type="date"
                                        data-vv-as="Date Requested" :rules="[requiredValidator]" />
                                </v-col>
                                <v-col>
                                    <v-card-text>Amount Requested</v-card-text>
                                    <v-text-field v-model="amount" data-vv-as="Amount Requested" type="number"
                                        :rules="[requiredValidator, positiveValidator]"></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col cols="12">
                                    <v-card-text>Reason</v-card-text>
                                    <VTextarea v-model="reasons" label="Text here..." data-vv-as="Reasons"
                                        :rules="[requiredValidator]" />
                                </v-col>
                            </v-row>
                        </div>

                        <VDivider class="mt-5" />
                        <v-row>
                            <v-col cols="12">
                                <div class="text-right mt-5">
                                    <v-spacer></v-spacer>
                                    <VBtn color="primary" type="submit" @click="isFlatSnackbarVisible = true">
                                        Submit
                                    </VBtn>
                                </div>
                            </v-col>
                        </v-row>
                    </VForm>
                </VCardText>
            </VCard>
        </VCol>
    </section>
</template>
