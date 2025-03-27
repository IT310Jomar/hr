<script setup lang="ts">
import moment from 'moment';

const emit = defineEmits(['closedialog'])
const props = defineProps(['latest_memo_ToAddress', 'latest_memo_FromAddress', 'latest_memo_subject', 'latest_memo_date'])


const closeDialog = () =>{
  emit('closedialog')
}

</script>
<template>
  <!-- Dialog close btn -->
  <DialogCloseBtn @click="closeDialog" />

  <!-- Dialog Content -->
  <VCard title="MEMO">

    <VDivider class="mt-5" />

    <VCardText>
      <VRow>
        <VCol cols="12" sm="12">
          <div>
            <VListItemTitle class="mb-3 mt-5" style="font-weight: bolder;">
              TO: {{ props.latest_memo_ToAddress }}
            </VListItemTitle>
            <VListItemTitle class="mb-3 mt-5" style="font-weight: bolder;">
              FROM: {{ props.latest_memo_FromAddress }}
            </VListItemTitle>
            <VListItemTitle class="mb-3 mt-5" style="font-weight: bolder;">
              SUBJECT: {{ props.latest_memo_subject }}
            </VListItemTitle>
            <VListItemTitle class="mb-3 mt-5" style="font-weight: bolder;">
              DATE: {{ moment(props.latest_memo_date).format('MMMM DD, YYYY') }}
            </VListItemTitle>
          </div>
        </VCol>
      </VRow>
    </VCardText>
    <VDivider class="mb-1 mt-1" />
    <VCardText class="d-flex justify-end flex-wrap gap-3">
      <VBtn @click="closeDialog">
        Ok
      </VBtn>
    </VCardText>
  </VCard>
</template>
