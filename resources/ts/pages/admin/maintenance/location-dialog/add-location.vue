<script setup lang="ts">
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
import type { VForm } from 'vuetify/components'
import { emailValidator, requiredValidator } from '@validators'
import axios from 'axios'
import { ref } from 'vue';
import { useToastr } from '@/toastr';
import { environment } from '@/environments/environment'

const isDialogVisible = ref(false)
const toastr = useToastr();
const emit = defineEmits(['submitted']);
const name = ref('')
const isFormValid = ref(false)
const refForm = ref<VForm>()
const formValues = ref();

const onSubmit = () => {
  axios.post(environment.API_URL +'user/maintenance/location',{
    name: name.value,
  })
    .then((response) => {
      emit('submitted', response.data);
      name.value = ''
      isFormValid.value = false
      toastr.success('Added Successfully!');
    })
    nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}
</script>

<template>
  <VDialog v-model="isDialogVisible" max-width="600" top="true">
    <!-- Dialog Activator -->
    <template #activator="{ props }">
      <VBtn v-bind="props" v-model="isDialogVisible" inset color="primary" size="small" prepend-icon="tabler-plus"
        @click="">
        <strong>Add Location</strong>
      </VBtn>
    </template>
    <!-- Dialog close btn -->
    <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />
    <!-- Dialog Content -->
    <VCard title="Add Location / Work Place">
      <VDivider class="mt-5" />
    <!-- 👉 Form -->
    <VForm ref="refForm" v-model="isFormValid" :initial-values="formValues" @submit.prevent="onSubmit">
      <VCardText>
        <VRow>
          <VCol cols="12" sm="12">
            <PerfectScrollbar :options="{ wheelPropagation: false }">
              <VCard flat>
                <VCardText>
                <VRow>
                  <VCol cols="12">
                    <VTextField v-model="name" :rules="[requiredValidator]" label="Location Name" />
                  </VCol>
                </VRow>
                </VCardText>
              </VCard>
            </PerfectScrollbar>
          </VCol>
        </VRow>
      </VCardText>
      <VDivider class="mb-1 mt-1" />
      <VCardText class="d-flex justify-end flex-wrap gap-3">
        <VBtn variant="tonal" color="on-secondary" @click="isDialogVisible = false">
          Cancel
        </VBtn>
        <VBtn type="submit" @click="isDialogVisible = false">
          Save
        </VBtn>
      </VCardText>
    </VForm>
    </VCard>
  </VDialog>
</template>
