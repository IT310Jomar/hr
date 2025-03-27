<script lang="ts" setup>
import moment from 'moment';

const props = defineProps(['editData', 'onUpdate'])
const emit = defineEmits(['closeDialog', 'formUpdated'])

const items = ref([
    { title: 'Biometric device malfunction', value: '0' },
    { title: 'Power Outage', value: '1' },
    { title: 'Others', value: '2' }

])

const closeDialog = () => {
  emit('closeDialog')
}

const submitDialog = () => {
  props.onUpdate(props.editData, props.editData.id)
  emit('formUpdated')
  closeDialog();
}

</script>
<template>
  <!-- Dialog close btn -->
  <DialogCloseBtn @click="closeDialog" />

  <!-- Dialog Content -->
  <VCard title="Attendance Request">
    <VCardText>
      <VRow>
        <VCol cols="12">
          <VTextField readonly v-model="editData.created_at" label="Requested Date"
            :value="moment(editData.created_at).format('MM/DD/YYYY')" />

        </VCol>
        <VCol cols="12" sm="6">
          <VTextField readonly v-model="editData.login" label="Login Date" :value="moment(editData.login).format('MM/DD/YYYY')" />
        </VCol>
        <VCol cols="12" sm="6">
          <VTextField readonly v-model="editData.timeIn" label="Time In" :value="moment(editData.timeIn,'hh:mm:A').format('hh:mm:A')"/>
        </VCol>

        <VCol cols="12" sm="6">
          <VTextField readonly v-model="editData.state" label="State" />
        </VCol>
        <VCol cols="12" sm="6">
          <VTextField v-model="editData.type" label="Type" />
          <VDivider />
        </VCol>
        <VCol cols="12">
          <VTextarea v-model="editData.remarks" label="Remarks" />
          <VDivider />
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