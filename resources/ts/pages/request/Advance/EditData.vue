<script lang="ts" setup>


const props = defineProps(['editData', 'updateRequest'])
const emit = defineEmits(['closeDialog', 'formSubmitted'])

const closeDialog = () => {
    emit('closeDialog')

}

const submitDialog = () => {
    props.updateRequest(props.editData, props.editData.id)
    emit('formSubmitted')
    closeDialog();
}
const name = ref('')


</script>

<template>
    <!-- Dialog close btn -->
    <DialogCloseBtn @click="closeDialog" />

    <!-- Dialog Content -->
    <VCard >
        <VCardTitle class="d-flex flex-column  mt-5 px-5" >
           Cash Advance Requests
        </VCardTitle>
        <VCardText>
            <VRow>
                <VCol cols="12">
                    <VTextField v-model="editData.requested_date" label="Requested Date" class="mb-5" type="date"/>
                    <VTextField v-model="editData.amount" label="Amount" class="mb-5" />
                    <VTextarea v-model="editData.reasons" label="Reason" />
                </VCol>
            </VRow>
        </VCardText>
        <VDivider />

        <VCardText class="d-flex justify-end flex-wrap gap-3">
            <VBtn variant="tonal" color="secondary" @click="closeDialog">
                Close
            </VBtn>
            <VBtn @click.prevent="submitDialog">
                Update
            </VBtn>
        </VCardText>
    </VCard>
</template>
