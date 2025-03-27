<script lang="ts" setup>
import moment from 'moment';

const props = defineProps(['declinedUndertimeData'])
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
              <VCardTitle class="mb-5" >Declined Undertime Request</VCardTitle>
                <VCardText>
                    <VRow>
                        <VCol cols="12" sm="6">
                            <VTextField variant="plain" v-model="declinedUndertimeData.date_req" label="Date Request" readonly
                            :value="moment(declinedUndertimeData.date_req).format('MM/DD/YYYY')"/>
                            <VDivider/>
                        </VCol>
                        <VCol cols="12" sm="6">
                            <VTextField variant="plain" v-model="declinedUndertimeData.from" label="From" readonly
                            :value="moment(declinedUndertimeData.from, 'hh:mm A').format('hh:mm A')"/>
                            <VDivider/>
                        </VCol>
                        <VCol cols="12" sm="6">
                            <VTextField variant="plain" v-model="declinedUndertimeData.to" label="To" readonly
                            :value="moment(declinedUndertimeData.to, 'hh:mm A').format('hh:mm A')"/>
                            <VDivider/>
                        </VCol>

                        <VCol cols="12" sm="6">
                            <VTextField variant="plain" v-model="declinedUndertimeData.total_hours" label="Total Hours" readonly/>
                            <VDivider/>
                        </VCol>

                        <VCol cols="12" >
                            <VTextarea variant="plain" v-model="declinedUndertimeData.reason" label="Reason" readonly/>
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
