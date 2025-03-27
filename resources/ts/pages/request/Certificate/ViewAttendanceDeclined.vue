<script lang="ts" setup>
import moment from 'moment';

const props = defineProps(['declineData'])
const emit = defineEmits(['closeDialog'])

const closeDialog = () => {
    emit('closeDialog')
}

</script>

<template>
    <!-- Dialog close btn -->
    <DialogCloseBtn @click="closeDialog" />

    <!-- Dialog Content -->
    <VCard>
        <VCardText>
            <VCardTitle class="mb-5">Declined Attendance Requests</VCardTitle>
            <VCardText>
                <VRow>
                    <VCol cols="12">
                        <VTextField readonly v-model="declineData.created_at" label="Requested Date"
                            :value="moment(declineData.created_at).format('MM/DD/YYYY')" />

                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField readonly v-model="declineData.login" label="Login Date"
                            :value="moment(declineData.login).format('MM/DD/YYYY')" />
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField readonly v-model="declineData.timeIn" label="Time In"
                            :value="moment(declineData.timeIn, 'hh:mm:A').format('hh:mm:A')" />
                    </VCol>

                    <VCol cols="12" sm="6">
                        <VTextField readonly v-model="declineData.state" label="State" />
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField readonly v-model="declineData.type" label="Type" />
                    </VCol>
                    <VCol cols="12">
                        <VTextarea readonly v-model="declineData.remarks" label="Remarks" />
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
