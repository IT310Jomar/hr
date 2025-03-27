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
            <VCardTitle class="mb-5" >Declined Overtime Requests</VCardTitle>
            <VCardText>
                <VRow>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="declinedData.day" label="Day" readonly />
                        <VDivider />
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="declinedData.shift_date" label="Shift Date" readonly
                            :value="moment(declinedData.shift_date).format('MM/DD/YYYY')" />
                        <VDivider />
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="declinedData.shift_from" label="Shift From" readonly
                            :value="moment(declinedData.shift_from, 'hh:mm A').format('hh:mm A')" />
                        <VDivider />
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="declinedData.shift_to" label="Shift To" readonly
                            :value="moment(declinedData.shift_to, 'hh:mm A').format('hh:mm A')" />
                        <VDivider />
                    </VCol>
                    <VCol cols="12">
                        <VTextField variant="plain" v-model="declinedData.classification" label="Classification" readonly />
                        <VDivider />
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="declinedData.start" label="Start" readonly
                            :value="moment(declinedData.start, 'hh:mm A').format('hh:mm A')" />
                        <VDivider />
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="declinedData.end" label="End" readonly
                            :value="moment(declinedData.end, 'hh:mm A').format('hh:mm A')" />
                        <VDivider />
                    </VCol>
                    <VCol cols="12">
                        <VTextarea variant="plain" v-model="declinedData.purpose" label="Reason" readonly />
                        <VDivider />
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
