<script setup lang="ts">
import {PerfectScrollbar} from 'vue3-perfect-scrollbar'
import type {VForm} from 'vuetify/components'
import {emailValidator, requiredValidator} from '@validators'
import axios from 'axios'
import { ref, onMounted } from 'vue';
import {useToastr} from '@/toastr';
import { toast } from 'vue3-toastify';
import { environment } from '@/environments/environment';

interface Props {
  data: any
  scheduleData: any
  id: any
 
}

const isDialogVisible = ref(false)
const toastr = useToastr();
const props = defineProps<Props>()
const emit = defineEmits(['updated']);
const name = ref('')
const isScheduleValid = ref(false)
const refForm = ref<VForm>()
const scheduleForm = ref();
const schedule_type_id = ref()
const schedule_type = ref()
const day = ref()
const shift_start = ref()
const shift_end = ref()
const break_start = ref()
const break_end = ref()
const rest_day = ref()

let days = [
  {
    id: 1,
    day: 'Monday',
  },
  {
    id: 2,
    day: 'Tuesday',
  },
  {
    id: 3,
    day: 'Wednesday',
  },
  {
    id: 4,
    day: 'Thursday',
  },
  {
    id: 5,
    day: 'Friday',
  },
  {
    id: 6,
    day: 'Saturday',
  },
  {
    id: 7,
    day: 'Sunday',
  },
];

const scheduleconfig = ref();
const sched_id = ref()

const updateForm =  (data: any, id: any) => {
  axios.put(environment.API_URL +`user/schedule_categories/update-schedule-data/${id}`,{
    id: data.id,
    name: data.name,
  }) .then((response) => {
    emit('updated', response.data)
  })
  .catch((error) => {
    toastr.error('Invalid Data!');
  })
};

const UpdateScheduleConfig = (data: any) => {
  refForm.value?.validate()
    .then(({ valid: isValid }) => {
      if (isValid) {
        EditedScheduleConfig(data, data.id)
        updateForm(data, data.id)
      } else {
        toast("Please double check your fields", {
          autoClose: 4000,
          type: 'error',
          theme: 'colored'
        })
      }
    })
}

//submit forms
const EditedScheduleConfig = (data: any, id: any) => {
  axios.put(environment.API_URL +`user/employees/schedule_config/edit/${id}`,
    {
      id: data.id,
      scheduleconfig: scheduleconfig.value,
    }
  ).then((response) => {
    // console.log(employee_id.value)
    if (response.data.success) {
      emit('updated', response.data)
      isDialogVisible.value = false
      toast("Success! Schedule record updated!", {
        autoClose: 4000,
        type: 'success',
        theme: 'colored',
        style: {
          width: '350px' // Set the width to 400 pixels
        }
      })
    } else {
      toast("Error! Please check your fields!", {
        autoClose: 4000,
        type: 'error',
        theme: 'colored',
        style: {
          width: '350px' // Set the width to 400 pixels
        }
      })
    }
  })
}
//submit forms end

const scheduleData = (id: any) => {
  axios.get(environment.API_URL +'user/schedule_config/getData')
    .then(response => {
      scheduleconfig.value = []
      for(let a = 0; a < response.data.data[id].length; a++) {
        for(let b = 0; b < response.data.data[id][a].length; b++) {
          scheduleconfig.value.push({
            sched_id: sched_id.value = response.data.data[id][a][b].id,
            day: day.value = response.data.data[id][a][b].day,
            shift_start: shift_start.value = response.data.data[id][a][b].shift_start,
            shift_end: shift_end.value = response.data.data[id][a][b].shift_end,
            break_start: break_start.value = response.data.data[id][a][b].break_start,
            break_end: break_end.value = response.data.data[id][a][b].break_end,
            rest_day: rest_day.value = response.data.data[id][a][b].rest_day
          })
        }
        // console.log(a < response.data.data[id].length)
      }
    });
}


onMounted(() => {
 

  // scheduleData(props.data);

  if(props.data != null){
    if(props.data.id == props.data.id)
      schedule_type: schedule_type.value = props.data.id
    }
  })

</script>

<template>
  <VDialog v-model="isDialogVisible" max-width="800" top="true">
    <!-- Dialog Activator -->
    <template #activator="{ props }">
      <VBtn
        size="x-small"
        color="warning"
        prepend-icon="tabler-edit"
        v-bind="props" 
        v-model="isDialogVisible" inset
        @click.prevent="scheduleData(id)"
      >Update
      </VBtn>
    </template>
    <!-- Dialog close btn -->
    <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />
    <!-- Dialog Content -->

    <VCard title="Update Schedule Type">
      <VDivider class="mt-5" />
    <!-- 👉 Form -->
    <VForm ref="refForm" v-model="isScheduleValid" :initial-values="scheduleForm" @submit.prevent="UpdateScheduleConfig(data, data.id)">
      <VCardText>
        <VRow>
          <VCol cols="12" sm="12">
            <PerfectScrollbar :options="{ wheelPropagation: false }">
              <VCard flat>
                <VCardText>
                  <VRow>
                    <!-- 👉 name -->
                    <VCol cols="12">
                      <VTextField v-model="data.name" :rules="[requiredValidator]" label="Schedule Type" />
                    </VCol>
                    <VCol cols="12">
                      <!-- <VSelect v-model="schedule_type" :items="props.scheduleData" item-title="name" item-value="id" type="text"
                        :rules="[requiredValidator]" width="auto" label="Schedule Type" /> -->

                      <VTextField v-model="sched_id" label="Schedule Type ID" type="hidden" style="display: none;"/>
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
                  <tr v-for="row in scheduleconfig" :key="row">
                    <td class="text-center">
                      {{ row.day }}
                    </td>
                    <td class="text-center">
                      <VTextField :rules="[requiredValidator]" :disabled="row.rest_day == 1 ? true : false" v-model="row.shift_start" type="time"
                        variant="underlined" />
                    </td>
                    <td class="text-center">
                      <VTextField :rules="[requiredValidator]" :disabled="row.rest_day == 1 ? true : false" v-model="row.shift_end" type="time"
                        variant="underlined" />
                    </td>
                    <td class="text-center">
                      <v-text-field :rules="[requiredValidator]" :disabled="row.rest_day == 1 ? true : false" v-model="row.break_start" type="time"
                        variant="underlined" />
                    </td>
                    <td class="text-center">
                      <v-text-field :rules="[requiredValidator]" :disabled="row.rest_day == 1 ? true : false" v-model="row.break_end" type="time"
                        variant="underlined" />
                    </td>
                    <td class="text-center">
                      <v-checkbox v-model="row.rest_day" :value="1"/>
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
