<script setup lang="ts">
import { emailValidator, requiredValidator } from '@validators'
import axios from 'axios'
import { ref, onMounted } from 'vue';
import type { VForm } from 'vuetify/components'
import { toast } from 'vue3-toastify';
import { useToastr } from '@/toastr';
import { environment } from '@/environments/environment';

const toastr = useToastr();
const isDialogVisible = ref(false)
const emit = defineEmits(['submitted']);
const name = ref('')
const isScheduleValid = ref(false)
const scheduleForm = ref();
const refForm = ref<VForm>()
const day = ref()
const shift_start = ref()
const shift_end = ref()
const break_start = ref()
const break_end = ref()

// Define an array of days in the correct order
const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

// Initialize scheduleconfig as an array of objects, with each object representing a day of the week
const scheduleconfig = ref(days.map((days, index) => ({
  days: days,
})));

const PostScheduleConfig = () => {
  refForm.value?.validate()
    .then(({ valid: isValid }) => {
      if (isValid) {
        saveScheduleConfig()
      } else {
        toast("Please double check your fields", {
          autoClose: 4000,
          type: 'error',
          theme: 'colored'
        })
      }
    })
}

const saveScheduleConfig = () => {
  axios.post(environment.API_URL +'user/schedulecreates/store', {
    name: name.value,
    scheduleconfig: scheduleconfig.value,
  })
    .then((response) => {
      if (response.data.success) {
        scheduleconfig.value.forEach((row) => {
          row.rest_day = false;
        });
        // Emit 'submitted' event only if 'name' value is present
        if (response.data.name) {
          emit('submitted', response.data);
          isDialogVisible.value = false;
          isScheduleValid.value = false;
          refForm.value?.reset();
          refForm.value?.resetValidation();
        }
        emit('submitted', response.data);
        // Reset form and show success message
        isDialogVisible.value = false;
        isScheduleValid.value = false;
        refForm.value?.reset();
        refForm.value?.resetValidation();
        toastr.success('Added Successfully!');
      } else {
        // Show error message if validation fails
        toastr.error('Error! Please check your fields!');
      }
    });
};

// watch(row.rest_day,(newVal) => {
//   if (!newVal) {
//     row.rest_day = 0; // set rest_day to 0 if unchecked
//   }
// })

</script>

<template>
  <VDialog v-model="isDialogVisible" max-width="800" class=" mb-16">
    <!-- Dialog Activator -->
    <template #activator="{ props }">
      <VBtn color="info" variant="text" size="small" prepend-icon="tabler-plus" @click="isDialogVisible = true">
        <strong>New</strong>
      </VBtn>
    </template>
    <!-- Dialog close btn -->
    <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />
    <!-- Dialog Content -->
    <VCard title="Create New Schedule">

      <VDivider class="mt-5" />

      <!-- 👉 Form -->
      <VForm ref="refForm" v-model="isScheduleValid" :initial-values="scheduleForm" @submit.prevent="PostScheduleConfig">
        <VCardText>
          <VRow>
            <VCol cols="12" sm="12">
              <PerfectScrollbar :options="{ wheelPropagation: false }">
                <VCard flat>
                  <VCardText>
                    <VRow>
                      <!-- 👉 name -->
                      <VCol cols="12">
                        <VTextField v-model="name" :rules="[requiredValidator]" label="Create Schedule Type" />
                      </VCol>
                    </VRow>
                  </VCardText>
                </VCard>
                <VCard class="mt-4">
                  <VTable>
                    <!-- 👉 table head -->
                    <thead>
                      <tr>
                        <th class="text-Left" scope="col">
                          Day
                        </th>
                        <th class="text-Left" scope="col">
                          Shift Start
                        </th>
                        <th class="text-Left" scope="col">
                          Shift End
                        </th>
                        <th class="text-Left" scope="col">
                          Break Start
                        </th>
                        <th class="text-Left" scope="col">
                          Break End
                        </th>
                        <th class="text-Left" scope="col">
                          Rest Day
                        </th>
                      </tr>
                    </thead>
                    <!-- 👉 table body -->
                    <tbody>
                      <tr v-for="row in scheduleconfig" :key="row.day">
                        <td class="text-center">
                          {{ row.days }}
                        </td>
                        <td class="text-center">
                          <VTextField :rules="row.rest_day == 1 ? [(v) => (v && row.rest_day == 1)] : [requiredValidator, (v) => (v && row.rest_day == 1)]" :disabled="row.rest_day == 1 ? true : false"
                            v-model="row.shift_start" type="time" variant="underlined" />
                        </td>
                        <td class="text-center">
                          <VTextField :rules="row.rest_day == 1 ? [(v) => (v && row.rest_day == 1)] : [requiredValidator, (v) => (v && row.rest_day == 1)]" :disabled="row.rest_day == 1 ? true : false"
                            v-model="row.shift_end" type="time" variant="underlined" />
                        </td>
                        <td class="text-center">
                          <VTextField :rules="row.rest_day == 1 ? [(v) => (v && row.rest_day == 1)] : [requiredValidator, (v) => (v && row.rest_day == 1)]" :disabled="row.rest_day == 1 ? true : false"
                            v-model="row.break_start" type="time" variant="underlined" />
                        </td>
                        <td class="text-center">
                          <VTextField :rules="row.rest_day == 1 ? [(v) => (v && row.rest_day == 1)] : [requiredValidator, (v) => (v && row.rest_day == 1)]" :disabled="row.rest_day == 1 ? true : false"
                            v-model="row.break_end" type="time" variant="underlined" />
                        </td>
                        <td class="text-center">
                          <VCheckbox v-model="row.rest_day" :value="1"/>
                        </td>
                      </tr>
                    </tbody>
                  </VTable>
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
          <VBtn type="submit">
            Save
          </VBtn>
        </VCardText>
      </VForm>
    </VCard>
  </VDialog>
</template>
