<script lang="ts" setup>

const props = defineProps(['editScheduleData', 'updateScheduleData'])
const emit = defineEmits(['closeDialog','formSubmitted'])

const closeDialog = () => {
    emit('closeDialog')
}

const submitDialog = () => {
    props.updateScheduleData(props.editScheduleData, props.editScheduleData.id)
    emit('formSubmitted')
    closeDialog();
}

</script>

<template>
        <!-- Dialog close btn -->
        <DialogCloseBtn @click="closeDialog" />

        <!-- Dialog Content -->
        <VCard title="Schedule Adjustment">
            <VCardText>
                <VRow>
                    <VCol cols="12" sm="6">
                        <VTextField v-model="editScheduleData.date_from" type="date" label="Date From" 
                       />
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField v-model="editScheduleData.date_to" type="date" label="Date To" 
                       />
                    </VCol>
                    <VCol cols="12" sm="6">
                        <VTextField v-model="editScheduleData.shift_start" type="time" label="Shift Start" persistent-hint />
                    </VCol>

                    <VCol cols="12" sm="6">
                        <VTextField v-model="editScheduleData.shift_end"  type="time" label="Shift End" />
                    </VCol>

                    <VCol cols="12" sm="6">
                        <VTextField v-model="editScheduleData.break_start"  type="time" label="Break Start" />
                    </VCol>

                    <VCol cols="12" sm="6">
                        <VTextField v-model="editScheduleData.break_end"  type="time" label="Break End" />
                    </VCol>

                </VRow>
            </VCardText>

            <VCardText class="d-flex justify-end flex-wrap gap-3">
                <VBtn variant="tonal" color="secondary" @click="closeDialog">
                    Close
                </VBtn>
                <VBtn
                    @click.prevent="submitDialog">
                    Save
                </VBtn>
            </VCardText>
        </VCard>
</template>
