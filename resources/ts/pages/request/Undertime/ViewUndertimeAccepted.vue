<script lang="ts" setup>
import moment from 'moment';

const props = defineProps(['approvedUndertimeData'])
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
              <VCardTitle class="mb-5" >Accepted Undertime Request</VCardTitle>
                <VCardText>
                    <VRow>
                        <VCol cols="12" sm="6">
                            <VTextField variant="plain" v-model="approvedUndertimeData.date_req" label="Date Request" readonly
                            :value="moment(approvedUndertimeData.date_req).format('MM/DD/YYYY')"/>
                            <VDivider/>
                        </VCol>
                        <VCol cols="12" sm="6">
                            <VTextField variant="plain" v-model="approvedUndertimeData.from" label="From" readonly
                            :value="moment(approvedUndertimeData.from, 'hh:mm A').format('hh:mm A')"/>
                            <VDivider/>
                        </VCol>
                        <VCol cols="12" sm="6">
                            <VTextField variant="plain" v-model="approvedUndertimeData.to" label="To" readonly
                            :value="moment(approvedUndertimeData.to, 'hh:mm A').format('hh:mm A')"/>
                            <VDivider/>
                        </VCol>

                        <VCol cols="12" sm="6">
                            <VTextField variant="plain" v-model="approvedUndertimeData.total_hours" label="Total Hours" readonly/>
                            <VDivider/>
                        </VCol>

                        <VCol cols="12" >
                            <VTextarea variant="plain" v-model="approvedUndertimeData.reason" label="Reason" readonly/>
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
