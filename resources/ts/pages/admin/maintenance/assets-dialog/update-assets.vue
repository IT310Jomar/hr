<script setup lang="ts">
import { PerfectScrollbar } from 'vue3-perfect-scrollbar' 
import type { VForm } from 'vuetify/components'
import { emailValidator, requiredValidator } from '@validators'
import axios from 'axios'
import { ref } from 'vue';
import { useToastr } from '@/toastr';
import { environment } from '@/environments/environment';

interface Props { data: any }

const isDialogVisible = ref(false)
const toastr = useToastr();
const props = defineProps<Props>()
const emit = defineEmits(['updated']);
const name = ref('')
const isFormValid = ref(false)
const refForm = ref<VForm>()
const formValues = ref();

const updateForm =  (data: any, id: any) => {
  axios.put(environment.API_URL +`user/maintenance/update-asset-category/${id}`,{
    id: data.id,
    name: data.name,
  }) .then((response) => {
    emit('updated', response.data)
    toastr.success('Updated Successfully!');
  })
  .catch((error) => {
    toastr.error('Invalid Data!');
  })
};
</script>

<template>
  <VDialog v-model="isDialogVisible" max-width="600" top="true">
    <!-- Dialog Activator -->
    <template #activator="{ props }">
      <VBtn
        size="x-small"
        color="primary"
        prepend-icon="tabler-edit"
        v-bind="props" 
        v-model="isDialogVisible" inset
      >Update
      </VBtn>
    </template>

    <!-- Dialog close btn -->
    <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />

    <!-- Dialog Content -->
    <VCard title="Update Asset Type">

      <VDivider class="mt-5" />
    <!-- 👉 Form -->
    <VForm ref="refForm" v-model="isFormValid" :initial-values="formValues" @submit.prevent="updateForm(data,data.id)">
      <VCardText>
        <VRow>
          <VCol cols="12" sm="12">
            <PerfectScrollbar :options="{ wheelPropagation: false }">
              <VCard flat>
                <VCardText>

                    <VRow>
                      <!-- 👉 name -->
                      <VCol cols="12">
                        <VTextField v-model="data.name" :rules="[requiredValidator]" label="Asset Type" />
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
