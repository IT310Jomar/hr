<script lang="ts" setup>
import moment from 'moment';

const props = defineProps(['declinedScheduleData'])
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
            <VCardTitle>Declined Schedcule Adjustment </VCardTitle>
            <VCardText>
                <VRow class="mt-5" >
                    <VCol cols="12" sm="6" >
                        <VTextField  variant="plain" v-model="declinedScheduleData.date_from" label="Date From" readonly
                        :value="moment(declinedScheduleData.date_from).format('MM/DD/YYYY')"/>
                        <VDivider/>
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField  variant="plain" v-model="declinedScheduleData.date_to" label="Date To" readonly
                        :value="moment(declinedScheduleData.date_to).format('MM/DD/YYYY')"/>
                        <VDivider/>
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="declinedScheduleData.shift_start" label="Shift Start"  readonly
                        :value="moment(declinedScheduleData.shift_start, 'hh:mm A').format('hh:mm A')"/>
                        <VDivider/>
                    </VCol>

                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="declinedScheduleData.shift_end" label="Shift End" readonly
                        :value="moment(declinedScheduleData.shift_end, 'hh:mm A').format('hh:mm A')"/>
                        <VDivider/>
                    </VCol>

                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="declinedScheduleData.break_start" label="Break Start" readonly
                        :value="moment(declinedScheduleData.break_start, 'hh:mm A').format('hh:mm A')"/>
                        <VDivider/>
                    </VCol>

                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="declinedScheduleData.break_end" label="Break End" readonly
                        :value="moment(declinedScheduleData.break_end, 'hh:mm A').format('hh:mm A')"/>
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
