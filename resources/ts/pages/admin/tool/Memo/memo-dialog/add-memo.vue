<script setup lang="ts">
import Preview from '@/pages/admin/tool/Memo/memo-dialog/preview.vue'
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
import type { VForm } from 'vuetify/components'
import { emailValidator, requiredValidator } from '@validators'
import axios from 'axios'
import { ref } from 'vue';
import { useToastr } from '@/toastr';
import { Options } from 'flatpickr/dist/types/options'
import { environment } from '@/environments/environment'

const toastr = useToastr();
const isDialogVisible = ref(false)
const emit = defineEmits(['submitted',])
const isMemoValid = ref(false)
const memoForm = ref();
const to_address = ref();
const from_address = ref();
const memo_subject = ref();
const memo_date = ref();
const memo_message = ref();


const dateConfig = computed(() => {
  const config: Options = {dateFormat: 'Y-m-d'}
  return config
})

//submits data
const onSubmit = () => {
  axios.post(environment.API_URL +'user/memocreate/store', {
    to_address: to_address.value,
    from_address: from_address.value,
    memo_subject: memo_subject.value,
    memo_date: memo_date.value,
    memo_message: memo_message.value,
  })
    .then((response) => {
      // console.log(response.data)
      emit('submitted', response.data);
      to_address.value = ''
      from_address.value = ''
      memo_subject.value = ''
      memo_date.value = ''
      memo_message.value = ''
      isMemoValid.value = false
      toastr.success('Added Successfully!');
    })
}
//preview reads all data type in add-memo
watch([to_address, from_address, memo_subject, memo_date, memo_message], ([toValue, fromValue, memoValue, dateValue, messageValue]) => {
  to_address: to_address.value = toValue;
  from_address: from_address.value = fromValue;
  memo_subject: memo_subject.value = memoValue;
  memo_date: memo_date.value = dateValue;
  memo_message: memo_message.value = messageValue;
})
</script>

<template>
  <VDialog v-model="isDialogVisible" max-width="600" max-height="600" persistent z-index="1000">
    <!-- Dialog Activator -->
    <template #activator="{ props }">
      <VBtn color="info" @click="isDialogVisible = true" size="small" prepend-icon="tabler-plus">
        Add
      </VBtn>
    </template>

    <!-- Dialog close btn -->
    <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />
    <!-- Dialog Content -->
    <VCard title="Add Memo">
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
                    <VTextField type="text" v-model="to_address" :rules="[requiredValidator]" variant="underlined" />
                  </VCol>
                  <VCol>
                    <VListItemTitle style=" font-size: 15px;">
                      From
                    </VListItemTitle>
                    <VTextField type="text" v-model="from_address" :rules="[requiredValidator]" variant="underlined" />
                  </VCol>
                </VRow>
              </VCol>
              <VCol>
                <VListItemTitle style=" font-size: 15px;">
                  Subject
                </VListItemTitle>
                <VTextField type="text" v-model="memo_subject" :rules="[requiredValidator]" variant="underlined" />
              </VCol>
              <VCol>
                <VListItemTitle style=" font-size: 15px;">
                  Date
                </VListItemTitle>
                <!-- <VTextField type="date" v-model="memo_date" :rules="[requiredValidator]" variant="underlined" /> -->
                <AppDateTimePicker
                :rules="[requiredValidator]"
                  v-model="memo_date"
                  label="DD-MM-YYYY"
                  :config="dateConfig"
                  :style="{ zIndex: 1001 }"
                  variant="underlined"
                />
              </VCol>
              <VCol>
                <VTextField type="text" v-model="memo_message" :rules="[requiredValidator]" variant="underlined"
                  label="Memo here" />
              </VCol>
            </div>
          </VCol>
        </VCardText>
        <VDivider/>
        <VCardText class="d-flex justify-end flex-wrap gap-2">
          <VBtn type="submit" @click="isDialogVisible = false">
            Save
          </VBtn>
          <Preview :to_address="to_address" :from_address="from_address" :memo_subject="memo_subject"
            :memo_date="memo_date" :memo_message="memo_message" />  
        </VCardText>
      </VForm>
    </VCard>
  </VDialog>
</template>
