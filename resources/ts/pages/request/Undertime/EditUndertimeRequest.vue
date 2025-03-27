<script lang="ts" setup>
const props = defineProps(['editUndertimeData', 'updateUndertimeData'])
const emit = defineEmits(['closeDialog'])

const closeDialog = () => {
    emit('closeDialog')
}

const submitDialog = () => {
    props.updateUndertimeData(props.editUndertimeData, props.editUndertimeData.id)
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
                    <VTextField v-model="editUndertimeData.date_req" label="Date Request" type="date" />
                </VCol>
                <VCol cols="12" sm="6">
                    <VTextField v-model="editUndertimeData.from" label="From" type="time"/>
                </VCol>
                <VCol cols="12" sm="6">
                    <VTextField v-model="editUndertimeData.to" label="To" type="time"/>
                </VCol>

                <VCol cols="12" sm="6">
                    <VTextField v-model="editUndertimeData.total_hours" label="Total Hours" />
                </VCol>

                <VCol cols="12">
                    <VTextarea v-model="editUndertimeData.reason" label="Reason" />
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
