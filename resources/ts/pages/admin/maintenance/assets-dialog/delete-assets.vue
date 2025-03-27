<script setup lang="ts">
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
import type { VForm } from 'vuetify/components'
import { emailValidator, requiredValidator } from '@validators'
import axios from 'axios'
import { ref } from 'vue';
import { useToastr } from '@/toastr';
import { environment } from '@/environments/environment'

interface Props { data: any }

const isDialogVisible = ref(false)
const toastr = useToastr();
const props = defineProps<Props>()
const emit = defineEmits(['deleted']);
const name = ref('')
const isFormValid = ref(false)
const refForm = ref<VForm>()
const formValues = ref();

const assetsDelete = (id:any) => {
      axios.delete(environment.API_URL +`user/maintenance/remove-asset-category/${id}`)
      .then(response => {
        emit('deleted', response.data);
        toastr.success('Deleted Successfully!');
      }).catch(error => {
        console.log(error);
      })
    };
    const getid = (id:any) => {
      axios.get(environment.API_URL +`user/view-asset-category/${id}`)
      .then(response => {
      }).catch(error => {
        console.log(error);
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
        prepend-icon="tabler-trash"
        v-bind="props" 
        v-model="isDialogVisible" inset
      >Delete
      </VBtn>
    </template>

    <!-- Dialog close btn -->
    <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />

    <!-- Dialog Content -->
    <VCard title="Delete Asset Type">

      <VDivider class="mt-5" />
    <!-- 👉 Form -->
      <VCardText>
        <VRow>
            <VCol cols="12" sm="12">
              <PerfectScrollbar :options="{ wheelPropagation: false }">
                  <VCard flat>
                      <VCardText>
                        <div>
                            <h3>Are you sure you want to delete this asset ?</h3>
                        </div>
                      </VCardText>
                  </VCard>
              </PerfectScrollbar>
            </VCol>
        </VRow>
      </VCardText>
      <VDivider class="mb-1 mt-1" />
      <VCardText class="d-flex justify-end flex-wrap gap-3">
        <VBtn variant="tonal" color="on-secondary" @click="isDialogVisible = false">
          No
        </VBtn>
        <VBtn @click="assetsDelete(data.id), isDialogVisible = false">
          Yes, Delete
        </VBtn>
      </VCardText>
    </VCard>
  </VDialog>
</template>
