<script lang="ts" setup>
const props = defineProps(['editData', 'updateLeaveData'])
const emit = defineEmits(['closeDialog', 'formSubmitted'])
const items = ['Sick', 'Vacation']

const closeDialog = () => {
  emit('closeDialog')
}

const submitDialog = () => {
  props.updateLeaveData(props.editData, props.editData.id)
  emit('formSubmitted')
  closeDialog();
}

const leave_type = ref('')
const date_from = ref('')
const date_to = ref('')
const reason = ref('')
const file_attachment = ref('')
const interest = ref<string[]>([])
</script>
<template>
  <!-- Dialog close btn -->
  <DialogCloseBtn @click="closeDialog" />

  <!-- Dialog Content -->
  <VCard title="Leave Request">
    <VCardText>
      <VRow>
        <VCol cols="12">
          <VSelect id="select" v-model="editData.leave_type" :items="items" data-vv-as="Date To"/>
        </VCol>
        <VRow class="px-3">
          <VCol cols="12"  >
            <VTextField v-model="editData.date_from" label="Date From" type="date" />
          </VCol>
          <VCol cols="12"  >
            <VTextField v-model="editData.date_to" label="Date To" persistent-hint type="date" />
          </VCol>
        </VRow>
        <VCol cols="12">
          <VTextarea v-model="editData.reason" label="Reason" />
        </VCol>
      </VRow>
    </VCardText>

    <VCardText class="d-flex justify-end flex-wrap gap-3">
      <VBtn variant="tonal" color="secondary" @click="closeDialog">
        Close
      </VBtn>
      <VBtn @click.prevent="submitDialog">
        Save
      </VBtn>
    </VCardText>
  </VCard>
</template>