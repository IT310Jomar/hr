<script lang="ts" setup>
const props = defineProps(['updateBusinessData', 'editBusinessData'])
const emit = defineEmits(['closeDialog'])

const closeDialog = () => {
    emit('closeDialog')
}

const submitDialog = () => {
    props.updateBusinessData(props.editBusinessData, props.editBusinessData.id)
    closeDialog();
}


</script>
<template>
    <!-- Dialog close btn -->
    <DialogCloseBtn @click="closeDialog" />

    <!-- Dialog Content -->
    <VCard title="Undertime Request">
        <VCardText>
            <VRow>
                <VCol cols="12" sm="6">
                    <VTextField v-model="editBusinessData.date_from" label="Date From" type="date"/>
                </VCol>
                <VCol cols="12" sm="6">
                    <VTextField v-model="editBusinessData.date_to" label="Date To" type="date"/>
                </VCol>
                <VCol cols="12" sm="6">
                    <VTextField v-model="editBusinessData.time_from" label="Time From" type="time" />
                </VCol>
                <VCol cols="12" sm="6">
                    <VTextField v-model="editBusinessData.time_to" label="Time To" type="time"/>
                </VCol>
                <VCol cols="12" >
                    <VTextField v-model="editBusinessData.location" label="Location" />
                </VCol>
                <VCol cols="12">
                    <VTextarea v-model="editBusinessData.purpose" label="Purpose" />
                </VCol>
            </VRow>
        </VCardText>

        <VCardText class="d-flex justify-end flex-wrap gap-3">
            <VBtn variant="tonal" color="secondary" @click="closeDialog">
                Close
            </VBtn>
            <VBtn
                @click.prevent="submitDialog">
                Update
            </VBtn>
        </VCardText>
    </VCard>
</template>
