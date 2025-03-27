<script setup lang="ts">
import {PerfectScrollbar} from 'vue3-perfect-scrollbar'
import type {VForm} from 'vuetify/components'
import axios from 'axios'
import { ref } from 'vue';
import {useToastr} from '@/toastr';
import { environment } from '@/environments/environment';

interface Props {data: any}

const isDialogVisible = ref(false)
const toastr = useToastr();
const props = defineProps<Props>()
const emit = defineEmits(['deleted']);
const name = ref('')
const isFormValid = ref(false)
const refForm = ref<VForm>()
const formValues = ref();

const memoDelete = (id:any) => {
      axios.delete(environment.API_URL +`user/memo/delete-memo-data/${id}`)
      .then(response => {
        emit('deleted', response.data);
        toastr.success('Deleted Successfully!');

      }).catch(error => {
        console.log(error);
      })
    };

    const getid = (id:any) => {
      axios.get(environment.API_URL +`user/memo/view-memo-data/${id}`)
      .then(response => {
        // toastr.success('Get ID Successfully!');
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
        color="error"
        prepend-icon="tabler-trash"
        v-bind="props" 
        v-model="isDialogVisible" inset
        @click.prevent="getid(data.id)"
      >Delete
      </VBtn>
    </template>

    <!-- Dialog close btn -->
    <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />
    <!-- Dialog Content -->
    <VCard title="Delete Memo">
      <VDivider class="mt-5" />
      
    <!-- 👉 Form -->
      <VCardText>
        <VRow>
            <VCol cols="12" sm="12">
              <PerfectScrollbar :options="{ wheelPropagation: false }">
                  <VCard flat>
                      <VCardText>
                        <div>
                            <h3>Are you sure you want to delete this memo ?</h3>
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
        <VBtn @click="memoDelete(data.id), isDialogVisible = false">
          Yes, Delete
        </VBtn>
      </VCardText>
    </VCard>
  </VDialog>
</template>
