<script lang="ts" setup>
import moment from 'moment';

const props = defineProps(['approvedData'])
const emit = defineEmits(['closeDialog'])

const closeDialog = () => {
    emit('closeDialog')
}

</script>

<template>
    <!-- Dialog Content -->
    <VCard>
        <VCardText>
            <VCardTitle class="mt-5">Accepted Attendance Request</VCardTitle>
            <VCardText>
                <VRow>
                    <VCol cols="12">
                        <VTextField readonly v-model="approvedData.created_at" label="Requested Date"
                            :value="moment(approvedData.created_at).format('MM/DD/YYYY')" />

                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField readonly v-model="approvedData.login" label="Login Date"
                            :value="moment(approvedData.login).format('MM/DD/YYYY')" />
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField readonly v-model="approvedData.timeIn" label="Time In"
                            :value="moment(approvedData.timeIn, 'hh:mm:A').format('hh:mm:A')" />
                    </VCol>

                    <VCol cols="12" sm="6">
                        <VTextField readonly v-model="approvedData.state" label="State" />
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField readonly v-model="approvedData.type" label="Type" />
                    </VCol>
                    <VCol cols="12">
                        <VTextarea readonly v-model="approvedData.remarks" label="Remarks" />
                    </VCol>
                </VRow>
            </VCardText>

        </VCardText>

        <VCardText class="d-flex justify-end">
            <VBtn @click="closeDialog">
                Close
            </VBtn>
        </VCardText>
    </VCard>
</template>
