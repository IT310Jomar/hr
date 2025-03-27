<script lang="ts" setup>

const props = defineProps(['declinedData', 'requestDeclined'])
const emit = defineEmits(['closeDialog', 'handleFormCancel'])

const closeDialog = () => {
  emit('closeDialog')
}

const submitDialog = () => {
  props.requestDeclined(props.declinedData.id)
  emit('handleFormCancel')
  closeDialog();
}
</script>

<template>
  <!-- Dialog close btn -->
  <DialogCloseBtn @click="closeDialog" />

  <!-- Dialog Content -->
  <VCard title="Are you sure you want to decline the request?">
    <VCardText>

    </VCardText>

    <VCardText class="d-flex justify-end gap-3 flex-wrap">
      <VBtn color="secondary" variant="tonal" @click="closeDialog">
        No
      </VBtn>
      <VBtn @click="submitDialog">
        Yes
      </VBtn>
    </VCardText>
  </VCard>
</template>
