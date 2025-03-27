<script lang="ts" setup>
import moment from 'moment'

const props = defineProps(['editData', 'updateOvertimeData'])
const emit = defineEmits(['closeDialog'])
const items = ['normal', 'early']

const closeDialog = () => {
  emit('closeDialog')
}

const submitDialog = () => {
  props.updateOvertimeData(props.editData, props.editData.id)
  closeDialog();
}

</script>
<template>
  <!-- Dialog close btn -->
  <DialogCloseBtn @click="closeDialog" />

  <!-- Dialog Content -->
  <VCard title="Leave Request">
    <VCardText>
      <VRow>
        <VCol cols="12" sm="6" >
          <VTextField  v-model="editData.day" label="Day"  readonly/>
          <VDivider/>
        </VCol>
        <VCol cols="12" sm="6" >
          <VTextField type="date" v-model="editData.shift_date" label="Shift Date" />
          <VDivider/>
        </VCol>
        <VCol cols="12" sm="6" >
          <VTextField type="time" v-model="editData.shift_from" label="Shift From" />
          <VDivider/>
        </VCol>
        <VCol cols="12" sm="6">
          <VTextField type="time" v-model="editData.shift_to" label="Shift To" />
          <VDivider/>
        </VCol>
        <VCol cols="12" >
          <VSelect  v-model="editData.classification" :items="items" label="Classification" />
          <VDivider/>
        </VCol>
        <VCol cols="12" sm="6">
          <VTextField type="time" v-model="editData.start" label="Start" />
          <VDivider/>
        </VCol>
        <VCol cols="12" sm="6">
          <VTextField type="time" v-model="editData.end" label="End" />
          <VDivider/>
        </VCol>
        <VCol cols="12">
          <VTextarea  v-model="editData.purpose" label="Reason"/>
          <VDivider/>
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