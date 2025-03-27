<script lang="ts" setup>
import moment from 'moment';

const props = defineProps(['declinedBusinessData'])
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
            <VCardTitle class="mt-5">Declined Business Requests</VCardTitle>
            <VCardText>
                <VRow>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="declinedBusinessData.date_from" label="Date From" readonly
                        :values="moment(declinedBusinessData.date_from).format('MM/DD/YYYY')"/>
                        <VDivider/>
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="declinedBusinessData.date_to" label="Date To" readonly
                        :values="moment(declinedBusinessData.date_to).format('MM/DD/YYYY')"/>
                        <VDivider/>
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="declinedBusinessData.time_from" label="Time From" readonly
                        :values="moment(declinedBusinessData.time_from, 'hh:mm A').format('hh:mm A')"/>
                        <VDivider/>
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="declinedBusinessData.time_to" label="Time To" readonly 
                        :values="moment(declinedBusinessData.time_to, 'hh:mm A').format('hh:mm A')"/>
                        <VDivider/>
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="declinedBusinessData.location" label="Location" readonly/>
                    </VCol>
                    <VDivider/>

                    <VCol cols="12">
                        <VTextarea variant="plain" v-model="declinedBusinessData.purpose" label="Purpose" readonly/>
                        <VDivider/>
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
