<script setup lang="ts">
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
import type { VForm } from 'vuetify/components'
import { emailValidator, requiredValidator } from '@validators'
import axios from 'axios'
import { ref } from 'vue';
import { useToastr } from '@/toastr';
import { Options } from 'flatpickr/dist/types/options'
import { environment } from '@/environments/environment';

interface Props {data: any}

const toastr = useToastr();
const isDialogVisible = ref(false)
const props = defineProps<Props>()
const emit = defineEmits(['updated']);
const isMemoValid = ref(false)
const memoForm = ref();

const dateConfig = computed(() => {
  const config: Options = {dateFormat: 'Y-m-d'}
  return config
})

const updateForm =  (data: any, id: any) => {
  axios.put(environment.API_URL +`user/memo/update-memo-data/${id}`,{
    id: data.id,
    to_address: data.to_address,
    from_address: data.from_address,
    memo_subject: data.memo_subject,
    memo_date: data.memo_date,
    memo_message: data.memo_message,
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
  <VDialog v-model="isDialogVisible" max-width="600" max-height="600" persistent z-index="1000">
    <!-- Dialog Activator -->
    <template #activator="{ props }">
      <VBtn
        size="x-small"
        color="warning"
        prepend-icon="tabler-edit"
        v-bind="props" a
        v-model="isDialogVisible" inset
      >Update
      </VBtn>
    </template>

    <!-- Dialog close btn -->
    <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />
    <!-- Dialog Content -->
    <VCard title="Add Memo">
      <VDivider class="mt-3" />
      <VForm ref="refForm" v-model="isMemoValid" :initial-values="memoForm"  @submit.prevent="updateForm(data, data.id)">
        <PerfectScrollbar :options="{ wheelPropagation: false }">
          <VCardText>
            <VRow>
              <VCol cols="12" sm="12">
                <div>
                  <VRow>
                    <VCol>
                      <VListItemTitle style=" font-size: 15px;">
                        To
                      </VListItemTitle>
                      <VTextField type="text" v-model="data.to_address" :rules="[requiredValidator]" variant="underlined"/>
                    </VCol>
                    <VCol>
                      <VListItemTitle style=" font-size: 15px;">
                        From
                      </VListItemTitle>
                      <VTextField type="text" v-model="data.from_address" :rules="[requiredValidator]" variant="underlined"/>
                    </VCol>
                  </VRow>
                  <VCol>
                      <VListItemTitle style=" font-size: 15px;">
                        Subject
                      </VListItemTitle>
                    <VTextField type="text" v-model="data.memo_subject" :rules="[requiredValidator]" variant="underlined"/>
                  </VCol>
                  <VCol>
                      <VListItemTitle  style=" font-size: 15px;">
                        Date
                      </VListItemTitle>
                    <!-- <VTextField type="date" v-model="data.memo_date" :rules="[requiredValidator]" variant="underlined"/> -->

                      <AppDateTimePicker
                      :rules="[requiredValidator]"
                        v-model="data.memo_date"
                        label="DD-MM-YYYY"
                        :config="dateConfig"
                        :style="{ zIndex: 1001 }"
                        variant="underlined"
                      />
                    </VCol>
                  <VCol>
                      <VTextField type="text" v-model="data.memo_message" :rules="[requiredValidator]" variant="underlined" label="Memo here"/>
                  </VCol>
                </div>
              </VCol>
            </VRow>
          </VCardText>
        </PerfectScrollbar>
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
