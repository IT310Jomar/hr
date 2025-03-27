<script setup lang="ts">
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
// eslint-disable-next-line @typescript-eslint/consistent-type-imports
import type { VForm } from 'vuetify/components'

// import type { UserProperties } from '@/@fake-db/types'
import { emailValidator, requiredValidator } from '@validators'
import axios from 'axios'
import { useToastr } from '@/toastr';


type FormSubmittedEvent = (value: boolean) => void;
interface Emit {
  (e: 'update:isDrawerOpen', value: boolean): void
  (e: 'submitted', callback: FormSubmittedEvent): void;
}

interface Props {
  isDrawerOpen: boolean
}

const toastr = useToastr();
const props = defineProps<Props>()
const emit = defineEmits<Emit>()
const name = ref('')
const email = ref('')
const password = ref('')
const isFormValid = ref(false)
const refForm = ref<VForm>()
const formValues = ref();
const users = ref([])

// 👉 drawer close
const closeNavigationDrawer = () => {
  emit('update:isDrawerOpen', false)

  nextTick(() => {
    refForm.value?.reset()
    refForm.value?.resetValidation()
  })
}

const onSubmit = () => {
  axios.post('/api/user/users/store',{
    name: name.value,
    email: email.value,
    password: password.value,
  })
    
    .then((response) => {
      console.log(response.data)
      emit('submitted', response.data);
      emit('update:isDrawerOpen', false)
      name.value = ''
      email.value = ''
      password.value = ''
      isFormValid.value = false
      toastr.success('Added Successfully!');
    })
}

const handleDrawerModelValueUpdate = (val: boolean) => {
  emit('update:isDrawerOpen', val)
}
</script>

<template>
  <VNavigationDrawer
    temporary
    :width="400"
    location="end"
    class="scrollable-content"
    :model-value="props.isDrawerOpen"
    @update:model-value="handleDrawerModelValueUpdate"
  >
    <!-- 👉 Title -->
    <div class="d-flex align-center pa-6 pb-1">
      <h6 class="text-h6">
        Add User
      </h6>

      <VSpacer />

      <!-- 👉 Close btn -->
      <VBtn
        variant="tonal"
        color="default"
        icon
        size="32"
        class="rounded"
        @click="closeNavigationDrawer"
      >
        <VIcon
          size="18"
          icon="tabler-x"
        />
      </VBTn>
    </div>

    <PerfectScrollbar :options="{ wheelPropagation: false }">
      <VCard flat>
        <VCardText>
          <!-- 👉 Form -->
          <VForm
            ref="refForm"
            v-model="isFormValid"
            @submit.prevent="onSubmit"
            :initial-values="formValues" 
          >
            <VRow>
              <!-- 👉 Full name -->
              <VCol cols="12">
                <VTextField
                  v-model="name"
                  :rules="[requiredValidator]"
                  label="Full Name"
                />
              </VCol>

              <!-- 👉 Email -->
              <VCol cols="12">
                <VTextField
                  v-model="email"
                  :rules="[requiredValidator, emailValidator]"
                  label="Email"
                />
              </VCol>

              <!-- 👉 Password -->
              <VCol cols="12">
                <VTextField
                  v-model="password"
                  type="password"
                  :rules="[requiredValidator]"
                  label="Password"
                />
              </VCol>

              <!-- 👉 Role -->
              <!-- <VCol cols="12">
                <VSelect
                  v-model="role"
                  label="Select Role"
                  :rules="[requiredValidator]"
                  :items="['Admin', 'User']"
                />
              </VCol> -->

              <!-- 👉 Submit and Cancel -->
              <VCol cols="12">
                <VBtn
                  type="submit"
                  class="me-3"
                >
                  Submit
                </VBtn>
                <VBtn
                  type="reset"
                  variant="tonal"
                  color="secondary"
                  @click="closeNavigationDrawer"
                  
                >
                  Cancel
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </PerfectScrollbar>
  </VNavigationDrawer>
</template>
