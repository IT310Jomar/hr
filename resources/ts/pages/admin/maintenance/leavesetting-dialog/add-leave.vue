<script setup lang="ts">
import type { VForm } from 'vuetify/components'
import { emailValidator, requiredValidator } from '@validators'
import axios from 'axios'
import { ref } from 'vue';
import { useToastr } from '@/toastr';
import { environment } from '@/environments/environment'

const emit = defineEmits(['submitted', 'close', 'dataValues',])
const refForm = ref<VForm>()
const user_level = ref();
const leave_count = ref();
const description = ref();
const toastr = useToastr();
const props = defineProps<Props>()
const isleaveValid = ref(false);
const leaveForm = ref(); 
const employeeuser = ref();

const getEStatus = () => {
  axios.get(environment.API_URL +'user/employees/getEmploymentOptions')
    .then((response) => {
      // EmPLOYMENT status
      if (response.data.success) {
        if (response.data.levels) {
          employeeuser.value=[]
          for (var x = 1; x < response.data.levels.length; x++) {
            employeeuser.value.push(
              {
                item: response.data.levels[x].name,
                value: response.data.levels[x].item
              }
            )
          }
        }
      }
    })
}
watch([leave_count, user_level, description], ([leaveValue, userValue, descripValue]) => {
  emit('dataValues', {
    leave_count: leaveValue,
    user_level: userValue,
    description: descripValue,
  })

})

const isDialogVisible = () => {
  props.isDialogSubmit()
  closedialog()
}

function closedialog() {
  emit('close')
}

//props
interface Props {
  employeeuser: any
  isDialogSubmit: Function
}
//props end

onMounted (() => {
  getEStatus()
})
</script>

<template>
  <!-- Dialog close btn -->
  <DialogCloseBtn @click.prevent="closedialog" />
  <!-- Dialog Content -->
  <VCard title="Add Leave Setting">
    <VForm ref="refForm" v-model="isleaveValid" :initial-values="leaveForm" @submit.prevent="props.isDialogSubmit">
    <VDivider class="mt-3" />
      <VCardText>
        <VRow>
          <VCol cols="12" sm="12">
            <div>
              <VCol>
                <VListItemTitle style=" font-size: 15px;">
                  Leave Count
                </VListItemTitle>
                <VTextField type="number" variant="underlined" v-model="leave_count" :rules="[requiredValidator]" max=12
                  oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';"  />
              </VCol>
              <VCol>
                <VListItemTitle style=" font-size: 15px;">
                  Select Role
                  <VSelect v-model="user_level" :rules="[requiredValidator]" :items="employeeuser" item-title="item"
                    item-value="value" variant="underlined" />
                </VListItemTitle>
              </VCol>
              <VCol>
                <VListItemTitle style=" font-size: 15px;">
                  Description (Optional)
                  <VTextField type="text" variant="underlined" label="Text here" v-model="description" :rules="[requiredValidator]"  />
                </VListItemTitle>
              </VCol>
            </div>
          </VCol>
        </VRow>
      </VCardText>
      <VDivider class="mb-1 mt-1" />
      <VCardText class="d-flex justify-end flex-wrap gap-3">
        <VBtn variant="tonal" color="on-secondary" @click.prevent="closedialog">
          Cancel
        </VBtn>
        <VBtn @click.prevent="isDialogVisible">
          Save
        </VBtn>
      </VCardText>
    </VForm>
  </VCard>
</template>
