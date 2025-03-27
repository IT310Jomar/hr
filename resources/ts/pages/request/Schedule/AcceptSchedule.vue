<script lang="ts" setup>
const props = defineProps < Props > ()
const emit = defineEmits(['closeDialog'])

interface Props {
    approvedData: any
    requestApproved: any
}
const closeDialog = () =>{
  emit('closeDialog')
} 

const submitDialog = () =>{
  props.requestApproved(props.approvedData.id)
  closeDialog();
}
const isFlatSnackbarVisible = ref(false);
</script>

<template>
    <!-- Dialog close btn -->
    <DialogCloseBtn @click="closeDialog" />

    <!-- Dialog Content -->
    <VCard title="Do you want to accept the request?">
      <VCardText>

      </VCardText>

      <VCardText class="d-flex justify-end gap-3 flex-wrap">
        <VBtn
          color="secondary"
          variant="tonal"
          @click="closeDialog"
        >
          No
        </VBtn>
        <VBtn @click.prevent="submitDialog">
          Yes
        </VBtn>
      </VCardText>
    </VCard>
</template>
