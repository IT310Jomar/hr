<script setup lang="ts">
import type { VForm } from 'vuetify/components'
import { ref } from 'vue';  

const isDialogVisible = ref(false)
const emit = defineEmits(['submitted']);
const isMemoValid = ref(false)
const memoForm = ref();
const props = defineProps<Props>();
interface Props {
  to_address: any
  from_address:any
  memo_subject: any
  memo_date: any
  memo_message: any
}
</script>

<template>
  <VDialog v-model="isDialogVisible" max-width="600" max-height="600">
    <!-- Dialog Activator -->
    <template #activator="{ props }">
        <VBtn @click="isDialogVisible = true">
          Preview
        </VBtn>
    </template>
    <!-- Dialog close btn -->
    <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />
    <!-- Dialog Content -->
    <VCard title="Preview">
      <VDivider class="mt-3" />
      <VForm ref="refForm" v-model="isMemoValid" :initial-values="memoForm" @submit.prevent="onSubmit">
        <VCardText>
          <VCol cols="12" sm="12">
            <div>
              <VCol>
                <VRow>
                <VCol>
                  <VListItemTitle style=" font-size: 15px;">
                    To
                  </VListItemTitle>
                  <VTextField type="text" readonly v-model="props.to_address" variant="underlined"/>
                </VCol>
                <VCol>
                  <VListItemTitle style=" font-size: 15px;">
                    From
                  </VListItemTitle>
                  <VTextField readonly v-model="props.from_address"  variant="underlined"/>
                </VCol>
              </VRow> 
              </VCol>
              <VCol>
                <VListItemTitle style=" font-size: 15px;">
                  Subject
                </VListItemTitle>
                <VTextField type="text" readonly v-model="props.memo_subject" variant="underlined"/>
              </VCol>
              <VCol>
                <VListItemTitle  style=" font-size: 15px;">
                  Date
                </VListItemTitle>
                <VTextField type="date" readonly v-model="props.memo_date" variant="underlined"/>
                </VCol>
              <VCol>
                <VTextField type="text" readonly v-model="props.memo_message" variant="underlined" label="Memo here"/>
              </VCol>
            </div>
          </VCol>
        </VCardText>
        <VDivider class="mb-1 mt-1" />
      </VForm>
    </VCard>
  </VDialog>
</template>
