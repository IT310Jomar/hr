<script lang="ts" setup>
const props = defineProps(['declinedData'])
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
            <VCardTitle >Declined Cash Advance</VCardTitle>
            <VCardText>
                <VRow>
                    <VCol cols="12">
                        <VTextField variant="plain" v-model="declinedData.requested_date" label="Requested Date"
                            class="mt-5" readonly :value="declinedData.requested_date.split('-').slice(1).concat(declinedData.requested_date.split('-')[0]).join('/')" />
                        <VDivider />
                        <VTextField variant="plain" v-model="declinedData.amount" label="Amount" readonly class="mt-5" />
                        <VDivider />
                        <VTextField variant="plain" v-model="declinedData.date_decline" label="Requested Date"
                            class="mt-5" readonly :value="declinedData.date_decline.split('-').slice(1).concat(declinedData.date_decline.split('-')[0]).join('/')" />
                        <VDivider />
                        <VTextarea variant="plain" v-model="declinedData.reasons" label="Reason" readonly class="mt-5">
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
