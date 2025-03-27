<script setup lang="ts">
import type { Options } from 'flatpickr/dist/types/options'
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
import { VForm } from 'vuetify/components'
import axios from 'axios'
import type { Events, NewEvents } from './Teamtypes'
import { useCalendarStores } from './useCalendarStores'

import { requiredValidator, urlValidator } from '@validators'

const props = defineProps<Props>()

const emit = defineEmits<{
  (e: 'update:isDrawerOpen', val: boolean): void
  (e: 'addEvent', val: NewEvents): void
  (e: 'updateEvent', val: Events): void
  (e: 'removeEvent', eventId: string): void
}>()

interface Props {
  isDrawerOpen: boolean
  event: (Events | NewEvents)
}

// 👉 store
const store = useCalendarStores()
const refForm = ref<VForm>()

// 👉 Event
const event = ref<Events | NewEvents>(JSON.parse(JSON.stringify(props.event)))

const resetEvent = () => {
  event.value = JSON.parse(JSON.stringify(props.event))
  nextTick(() => {
    refForm.value?.resetValidation()
  })
}

watch(() => props.isDrawerOpen, resetEvent)

const removeEvent = () => {
  emit('removeEvent', event.value.id)

  // Close drawer
  emit('update:isDrawerOpen', false)
}
const search = ref('')
const token = JSON.parse(localStorage.getItem('accessToken') || 'null');
const employess = ref()
const employee_id = ref()
const getemployess = () => {
  axios.get("/api/user/manage/manage-team/get-team-employees", { params : {token : token}})
  .then(response => {
    if(response.data.success) {
      if(response.data.employees) {
        employess.value = []
        for(var x = 0 ; x < response.data.employees.length; x++) {
          employess.value.push (
            {
              item : response.data.employees[x].last_name + ' ' + response.data.employees[x].first_name + ' ' + response.data.employees[x].middle_name,
              value : response.data.employees[x].id,
            }
          )
        }
      }
    }
  })
}


// watch(event, (newValue, oldValue) => {
//   console.log('employess has changed!', newValue, oldValue)
// })

const handleSubmit = () => {
  refForm.value?.validate()
    .then(({ valid }) => {
      if (valid) {
        // If id exist on id => Update event
        if (event.value.id !== '') {
          
          emit('updateEvent', event.value)

        // // Else => add new event
        } else{ 
          emit('addEvent', event.value)
          // console.log(event.value, "Add Event Here") 
        }
        // Close drawer
        emit('update:isDrawerOpen', false)
      }
    })
}

onMounted(() => {
  getemployess()
})


// 👉 Form

const onCancel = () => {
  emit('update:isDrawerOpen', false)

  nextTick(() => {
    refForm.value?.reset()
    resetEvent()
    refForm.value?.resetValidation()
  })
}

const startDateTimePickerConfig = computed(() => {
  const config: Options = { enableTime: true, dateFormat: 'Y-m-d H:i' }
  if (event.value.end)
    config.maxDate = event.value.end

  return config
})

const endDateTimePickerConfig = computed(() => {
  const config: Options = { enableTime: true, dateFormat: 'Y-m-d H:i' }

  if (event.value.start)
    config.minDate = event.value.start

  return config
})

const dialogModelValueUpdate = (val: boolean) => {
  emit('update:isDrawerOpen', val)
}
</script>

<template>
  <VNavigationDrawer
    temporary
    location="end"
    :model-value="props.isDrawerOpen"
    width="420"
    class="scrollable-content"
    @update:model-value="dialogModelValueUpdate"
  >
    <!-- 👉 Header -->
    <div class="d-flex align-center pa-6 pb-1">
      <h6 class="text-h6">
        {{ event.id ? 'Update' : 'Add' }} Event
      </h6>
  
      <VSpacer />

      <VBtn
        v-show="event.id"
        icon
        variant="tonal"
        size="32"
        class="rounded me-3"
        color="default"
        @click="removeEvent"
      >
        <VIcon
          size="18"
          icon="tabler-trash"
        />
      </VBtn>

      <VBtn
        variant="tonal"
        color="default"
        icon
        size="32"
        class="rounded"
        @click="$emit('update:isDrawerOpen', false)"
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
          <!-- SECTION Form -->
          <VForm
            ref="refForm"
            @submit.prevent="handleSubmit"
          >
            <VRow>
              <!-- 👉 Title -->
              <VCol cols="12">
                <VTextField
                  v-model="event.title"
                  label="Title"
                  :rules="[requiredValidator]"
                />
              </VCol>

              <!-- 👉 Calendar -->
              <VCol cols="12">
                <VSelect
                  v-model="event.extendedProps.calendar"
                  label="Label"
                  :rules="[requiredValidator]"
                  :items="store.availableCalendars"
                  :item-title="item => item.label"
                  :item-value="item => item.label"
                >
                  <template #selection="{ item }">
                    <div
                      v-show="event.extendedProps.calendar"
                      class="align-center"
                      :class="event.extendedProps.calendar ? 'd-flex' : ''"
                    >
                      <VBadge
                        :color="item.raw.color"
                        inline
                        dot
                        class="pa-1"
                      />
                      <span>{{ item.raw.label }}</span>
                    </div>
                  </template>
                </VSelect>
              </VCol>

              <!-- 👉 Start date -->
              <VCol cols="12">
                <AppDateTimePicker
                  :key="JSON.stringify(startDateTimePickerConfig)"
                  v-model="event.start"
                  :rules="[requiredValidator]"
                  label="Start date"
                  :config="startDateTimePickerConfig"
                />
              </VCol>

              <!-- 👉 End date -->
              <VCol cols="12">
                <AppDateTimePicker
                  :key="JSON.stringify(endDateTimePickerConfig)"
                  v-model="event.end"
                  :rules="[requiredValidator]"
                  label="End date"
                  :config="endDateTimePickerConfig"
                />
              </VCol>

              <!-- 👉 All day -->
              <VCol cols="12">
                <VSwitch
                  v-model="event.allDay"
                  label="All day"
                />
              </VCol>

              <!-- 👉 Guests -->
              <VCol cols="12">
                <VSelect
                  v-model="event.extendedProps.employee_id"
                  label="Name of Employee/s"
                  :items="employess"
                  item-title="item"
                  item-value="value"
                  chips
                  multiple
                  eager
                />
              </VCol>

              <!-- 👉 Description -->
              <VCol cols="12">
                <VTextarea
                  v-model="event.extendedProps.reason"
                  label="Reason"
                />
              </VCol>

              <!-- 👉 Form buttons -->
              <VCol cols="12">
                <VBtn
                  type="submit"
                  class="me-3"
                >
                  Submit
                </VBtn>
                <VBtn
                  variant="tonal"
                  color="secondary"
                  @click="onCancel"
                >
                  Cancel
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        <!-- !SECTION -->
        </VCardText>
      </VCard>
    </PerfectScrollbar>
  </VNavigationDrawer>
</template>
