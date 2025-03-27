<script setup lang="ts">
import type {VForm} from 'vuetify/components'
import axios from 'axios'
import { ref } from 'vue';
import {useToastr} from '@/toastr';

const toastr = useToastr();
const props = defineProps<Props>()
const emit = defineEmits(['close'])
const refForm = ref<VForm>()

interface Props {
  logsData: any
  leaveDelete: any
}

//function for closing dialog
const closedialog =() => {
  emit('close')
}

const deleteData = () => {
  props.leaveDelete(props.logsData.id)
  closedialog()
}

</script>

<template>
    <DialogCloseBtn @click.prevent="closedialog" />
    <VCard title="Delete Memo">
      <VDivider class="mt-5" />
    <!-- 👉 Form -->
      <VCardText>
        <VRow>
            <VCol cols="12" sm="12">
              <VCard flat>
                  <VCardText>
                    <div>
                        <h3>Are you sure you want to delete this leave ?</h3>
                    </div>
                  </VCardText>
              </VCard>
            </VCol>
        </VRow>
      </VCardText>
      <VDivider class="mb-1 mt-1" />
      <VCardText class="d-flex justify-end flex-wrap gap-3">
        <VBtn color="error" variant="tonal" @click="closedialog" class="mr-2">CLOSE</VBtn>
        <VBtn @click.prevent="deleteData">
          Yes, Delete
        </VBtn>
      </VCardText>
    </VCard>
</template>
