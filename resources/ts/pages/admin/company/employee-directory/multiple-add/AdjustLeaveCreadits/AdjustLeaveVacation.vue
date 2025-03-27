<script setup lang="ts">
const emit = defineEmits(['close', 'textFieldData'])
const props = defineProps<Props>();
interface Props {
  vacation: any
}


const adjustVacation = ref();
const reasons = ref();
const vacation_id = ref();

const ad = ref();
const rs = ref()
const v_id = ref();


onMounted(() => {
  if (props.vacation != null) {
    vacation_id: vacation_id.value = props.vacation.id
  }
})

const closeDialog = () => {
  emit('close')
}
const dataBinding = () => {
    ad.value = adjustVacation.value,
    rs.value = reasons.value
    v_id.value = vacation_id.value
  closeDialog()
}
// 👉 WATCH THE INPUTTED VALUE OF USERS IN FORM AND SEND IT TO PARENT COMPONENT
watch([ad, rs, v_id], ([adjustCreditsValue, reasonsValue, leaveIdValue,]) => {
  // Emit form data to parent component
  emit('textFieldData', {
    ad: adjustCreditsValue,
    rs: reasonsValue,
    v_id: leaveIdValue,
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
            <VTextField v-model="vacation_id" type="number" />
          </VCol>
          <VCol cols="12" hidden>
            <VTextField v-model="v_id" type="number" />
          </VCol>
          <VCol cols="12">
            <VTextField v-model="adjustVacation" label="Adjust Credits 4 / -4" type="number" />
          </VCol>
          <VCol cols="12" hidden>
            <VTextField v-model="ad" type="number" />
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
            <VLabel>Current total leave credits: {{ vacation.credits }} </VLabel>
          </VCol>
        </VRow>
      </VCardText>
      <VCardText class="d-flex justify-end flex-wrap gap-3">
        <VBtn @click.prevent="closeDialog" variant="tonal" color="error">
          CANCEL
        </VBtn>
        <VBtn @click.prevent="dataBinding"
          :disabled="adjustVacation < -4 || adjustVacation > 4 || adjustVacation == null || (adjustVacation > -4 && adjustVacation < 4) || adjustVacation == '' ? true : false"
          color="primary">
          SAVE
        </VBtn>
      </VCardText>
    </VCard>
  </section>
</template>
