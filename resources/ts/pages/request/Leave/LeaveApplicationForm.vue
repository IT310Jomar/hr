<script lang="ts" setup>
import axios from 'axios';
import { ref } from 'vue';
import { requiredValidator } from '@/@core/utils/validators';
import { VForm, VTextField } from 'vuetify/components';
import { environment } from '@/environments/environment';
import { toast } from 'vue3-toastify';
import moment from 'moment';

const emit = defineEmits(['form-submitted', 'file-view']);
const props = defineProps(['total_leaves', 'current_leave', 'sick_leave_count', 'vacation_leave_count', 'user_id', 'employee_id']);


const items = ['Sick', 'Vacation']
const leave_type = ref('')
const date_from = ref('')
const date_to = ref('')
const reason = ref('')
const file_attachment = ref()
const imageUrl = ref()
const submit = ref(false)
const isFlatSnackbarVisible = ref(false)

const handleFileUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (!target.files) return;

    file_attachment.value = target;
    const reader = new FileReader();
    reader.readAsDataURL(target.files[0]);
    reader.onload = (event) => {
        if (event.target) {
            imageUrl.value = event.target.result as string;
        }
    };
};

// For disabling the previous date
var date = new Date();
var today_date = date.getDate();
var month = date.getMonth() + 1;
var year = date.getUTCFullYear();
var padded_month = month < 10 ? '0' + month : month;
var padded_today_date = today_date < 10 ? '0' + today_date : today_date;
var minDate = year + '-' + padded_month + '-' + padded_today_date;
// end here

const applied = (e: Event) => {
    e.preventDefault();
    const formdata = new FormData();
    formdata.append('user_id', props.user_id);
    formdata.append('employee_id', props.employee_id);
    formdata.append('leave_type', leave_type.value);
    formdata.append('date_from', date_from.value);
    formdata.append('date_to', date_to.value);
    formdata.append('reason', reason.value);
    formdata.append('file_attachment', file_attachment.value?.files[0]);

    if (!leave_type.value || !date_from.value || !date_to.value || !reason.value) {
    } else {
        if (leave_type.value == 'Sick') {
            if (props.sick_leave_count > 0) {
                axios
                    .post(environment.API_URL + 'user/leave/request/store', formdata)
                    .then((response) => {
                        emit('form-submitted', response.data);
                        submit.value = true;
                        toast("Request Submitted.", {
                            autoClose: 4000,
                            type: 'success',
                            theme: 'colored',
                            style: {
                                width: '350px' // Set the width to 400 pixels
                            }
                        })
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
            } else {
                toast("Insufficient Sick Leave Credit!", {
                    autoClose: 4000,
                    type: 'error',
                    theme: 'colored',
                    style: {
                        width: '350px' // Set the width to 400 pixels
                    }
                })
            }
        }
        if (leave_type.value == 'Vacation') {
            if (props.vacation_leave_count > 0) {
                axios
                    .post(environment.API_URL + 'user/leave/request/store', formdata)
                    .then((response) => {
                        emit('form-submitted', response.data);
                        submit.value = true;
                        toast("Request Submitted.", {
                            autoClose: 4000,
                            type: 'success',
                            theme: 'colored',
                            style: {
                                width: '350px' // Set the width to 400 pixels
                            }
                        })
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
            } else {
                toast("Insufficient Vacation Leave Credit!", {
                    autoClose: 4000,
                    type: 'error',
                    theme: 'colored',
                    style: {
                        width: '350px' // Set the width to 400 pixels
                    }
                })
            }
        }
    }
};

</script>
<template>
    <section>
        <VCardText>
            <v-card-title>Leave Application Form</v-card-title>
            <VDivider />
            <VForm ref="refForm" @submit.prevent="applied">
                <v-row>

                    <v-col cols="12" sm="6">
                        <v-card-text class="font-weight-bold">
                            Available Leave Credits: {{ total_leaves }}
                        </v-card-text>
                        <!-- <v-card-text class="font-weight-bold">
                            Current Leave Credits: 
                        </v-card-text> -->
                    </v-col>

                    <v-col cols="12" sm="6">
                        <v-card-text>Leave Type</v-card-text>
                        <VSelect id="select" v-model="leave_type" :items="items" data-vv-as="Date To"
                            :rules="[requiredValidator]" />

                        <v-row class=" mt-3 ">
                            <VTextField id="data_from" v-model="date_from" type="date" :min="minDate" class="pl-3 mr-3 mb-2" label="From"
                                data-vv-as="Date To" :rules="[requiredValidator]" />

                            <VTextField id="date_to" v-model="date_to" type="date" :min="minDate" class="ml-3 pr-3 mb-2" label="To"
                                data-vv-as="Date To" :rules="[requiredValidator]" />
                        </v-row>
                        <v-row class="mt-5">
                            <v-col>
                                <VFileInput id="file" chips label="Select File" accept=".jpg,.jpeg,.png,.doc,.docx,.pdf"
                                    @change="handleFileUpload" :rules="[requiredValidator]" ref="file" />
                                <small class="text-muted ml-10">(5MB maximum file size, allowed file types: jpg, png, doc,
                                    pdf)</small>
                                <VTextarea id="reason" class="py-5" v-model="reason" variant="underlined" label="Reason"
                                    :rules="[requiredValidator]" />
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                <div class="primary text-right mt-5">
                    <VBtn type="submit" @click="isFlatSnackbarVisible = true">Apply</VBtn>
                </div>
            </VForm>
        </VCardText>
    </section>
</template>
