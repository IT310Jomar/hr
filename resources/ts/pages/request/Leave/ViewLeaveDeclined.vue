<script lang="ts" setup>
import moment from 'moment';

const props = defineProps(['declinedData'])
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
                <VCardTitle class="mb-5" >Declined Leave Requests</VCardTitle>
                <VCardText>
                    <VRow>
                        <VCol cols="12">
                            <VTextField variant="plain" v-model="declinedData.leave_type" width: auto label="Leave Type" readonly/>
                            <VDivider />
                            <VTextField variant="plain" v-model="declinedData.date_from" label="Date From" class="mt-5" requestApproved
                                readonly :value="moment(declinedData.date_from).format('MM/DD/YYYY')"/>
                                <VDivider />
                            <VTextField variant="plain" v-model="declinedData.date_to" label="Date To" readonly class="mt-5" requestApproved  
                            :value="moment(declinedData.date_to).format('MM/DD/YYYY')"/>
                            <VDivider />
                            <VTextarea variant="plain" v-model="declinedData.reason" label="Reason" readonly class="mt-5" requestApproved></VTextarea>
                            <VDivider />
                        </VCol>
                    </VRow>
                </VCardText>

            </VCardText>

            <VCardText class="d-flex justify-end">
                <VBtn @click=" closeDialog">
                    Close
                </VBtn>
            </VCardText>
        </VCard>
</template>
