<script setup lang="ts">
const emit = defineEmits(['close','textFieldData'])
const props = defineProps<Props>();

const adjustCredits = ref();
const reasons =ref();
const leave_id = ref();

const ac = ref();
const rs = ref()
const l_id = ref();

interface Props {
  credit: any
}
onMounted(() => {
  if(props.credit != null){
    leave_id: leave_id.value = props.credit.id
  }
});

const closeDialog = () => {
  emit('close')
}

const dataBinding = () => {
    ac.value = adjustCredits.value,
    rs.value = reasons.value
    l_id.value = leave_id.value
    closeDialog()
 }
  // 👉 WATCH THE INPUTTED VALUE OF USERS IN FORM AND SEND IT TO PARENT COMPONENT
  watch([ac,rs,l_id], ([adjustCreditsValue,reasonsValue,leaveIdValue,]) => {
  // Emit form data to parent component
  emit('textFieldData', {
    ac: adjustCreditsValue,
    rs: reasonsValue,
    l_id: leaveIdValue,
  })

})
</script>
<template>
  <section>
    <DialogCloseBtn @click.prevent="closeDialog" />
    <VCard style=" overflow: scroll;max-height: 500px;">
      <VCardTitle class="mb-6">
        Adjust Leave Credits
      </VCardTitle>
      <VCardText>
        <VRow class="mb-5">
          <VCol cols="12" hidden>
            <VTextField v-model="leave_id" type="number" />
          </VCol>
          <VCol cols="12" hidden>
            <VTextField v-model="l_id" type="number" />
          </VCol>
          <VCol cols="12">
            <VTextField v-model="adjustCredits" label="Adjust Credits 4 / -4" type="number" />
          </VCol>
          <VCol cols="12" hidden>
            <VTextField v-model="ac"  type="number" />
          </VCol>
        </VRow>
        <VRow>
          <VCol cols="12">
            <VTextarea v-model="reasons" label="Adjust Reason for Overriding" />
          </VCol>
          <VCol cols="12" hidden>
            <VTextarea v-model="rs" type="text" />
          </VCol>
        </VRow>
        <VRow>
          <VCol class="d-flex justify-center">
            <VLabel>Current total leave credits: {{ credit.credits }}</VLabel>
          </VCol>
        </VRow>
      </VCardText>
      <VCardText class="d-flex justify-end flex-wrap gap-3">
        <VBtn @click.prevent="closeDialog" variant="tonal" color="error">
          CANCEL
        </VBtn>
        <VBtn @click.prevent="dataBinding"
          :disabled="adjustCredits < -4 || adjustCredits > 4 || adjustCredits == null || (adjustCredits > -4 && adjustCredits < 4) || adjustCredits=='' ? true : false"
          color="primary">
          SAVE
        </VBtn>
      </VCardText>
    </VCard>
  </section>
</template>
