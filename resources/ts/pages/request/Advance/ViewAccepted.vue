<script lang="ts" setup>

const props = defineProps(['approvedData'])
const emit = defineEmits(['closeDialog'])

const closeDialog = () => {
    emit('closeDialog')
}

const name = ref('')
const requested_date = ref('')
const amount = ref('')
const reasons = ref('')
</script>

<template>
    <!-- Dialog close btn -->
    <DialogCloseBtn @click="closeDialog" />

    <!-- Dialog Content -->
    <VCard>
        <VCardText>
            <VCardTitle >Approved Cash Advance</VCardTitle>
            <VCardText>
                <VRow>
                    <VCol cols="12">

                        <VTextField variant="plain" v-model="approvedData.requested_date" label="Requested Date"
                            class="mt-5" readonly :value="approvedData.requested_date.split('-').slice(1).concat(approvedData.requested_date.split('-')[0]).join('/')" />
                        <VDivider />
                        <VTextField variant="plain" v-model="approvedData.amount" label="Amount" readonly class="mt-5" />
                        <VDivider />
                        <VTextField variant="plain" v-model="approvedData.date_approved" label="Requested Date"
                            class="mt-5" readonly :value="approvedData.date_approved.split('-').slice(1).concat(approvedData.date_approved.split('-')[0]).join('/')" />
                        <VDivider />
                        <VTextarea variant="plain" v-model="approvedData.reasons" label="Reason" readonly class="mt-5">
                        </VTextarea>
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
