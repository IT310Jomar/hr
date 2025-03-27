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
            <VCardTitle class="mb-5" >Accepted Overtime Requests</VCardTitle>
            <VCardText>
                <VRow>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="approvedData.day" label="Day" readonly/>
                        <VDivider />
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="approvedData.shift_date" label="Shift Date" readonly
                        :value="moment(approvedData.shift_date).format('MM/DD/YYYY')"/>
                        <VDivider />
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="approvedData.shift_from" label="Shift From" readonly
                        :value="moment(approvedData.shift_from, 'hh:mm A').format('hh:mm A')"/>
                        <VDivider />
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="approvedData.shift_to" label="Shift To" readonly
                        :value="moment(approvedData.shift_to, 'hh:mm A').format('hh:mm A')"/>
                        <VDivider />
                    </VCol>
                    <VCol cols="12">
                        <VTextField variant="plain" v-model="approvedData.classification" label="Classification" readonly />
                        <VDivider />
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="approvedData.start" label="Start" readonly
                        :value="moment(approvedData.start, 'hh:mm A').format('hh:mm A')"/>
                        <VDivider />
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="approvedData.end" label="End" readonly
                        :value="moment(approvedData.end, 'hh:mm A').format('hh:mm A')"/>
                        <VDivider />
                    </VCol>
                    <VCol cols="12">
                        <VTextarea variant="plain" v-model="approvedData.purpose" label="Reason" readonly />
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
