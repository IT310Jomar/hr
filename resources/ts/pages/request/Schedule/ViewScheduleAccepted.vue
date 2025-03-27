<script lang="ts" setup>
import moment from 'moment';

const props = defineProps(['approvedScheduleData'])
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
                <VCardTitle >Accepted Schedule Adjustment</VCardTitle>
                <VCardText>
                    <VRow>
                        <VCol cols="12" sm="6" >
                        <VTextField  variant="plain" v-model="approvedScheduleData.date_from" label="Date From" readonly
                        :value="moment(approvedScheduleData.date_from).format('MM/DD/YYYY')"/>
                        <VDivider/>
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField  variant="plain" v-model="approvedScheduleData.date_to" label="Date To" readonly
                        :value="moment(approvedScheduleData.date_to).format('MM/DD/YYYY')"/>
                        <VDivider/>
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="approvedScheduleData.shift_start" label="Shift Start"  readonly
                        :value="moment(approvedScheduleData.shift_start, 'hh:mm A').format('hh:mm A')"/>
                        <VDivider/>
                    </VCol>

                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="approvedScheduleData.shift_end" label="Shift End" readonly
                        :value="moment(approvedScheduleData.shift_end, 'hh:mm A').format('hh:mm A')"/>
                        <VDivider/>
                    </VCol>

                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="approvedScheduleData.break_start" label="Break Start" readonly
                        :value="moment(approvedScheduleData.break_start, 'hh:mm A').format('hh:mm A')"/>
                        <VDivider/>
                    </VCol>

                    <VCol cols="12" sm="6">
                        <VTextField variant="plain" v-model="approvedScheduleData.break_end" label="Break End" readonly
                        :value="moment(approvedScheduleData.break_end, 'hh:mm A').format('hh:mm A')"/>
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
