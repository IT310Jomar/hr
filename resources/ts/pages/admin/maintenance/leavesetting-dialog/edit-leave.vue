<script setup lang="ts">
import { requiredValidator } from '@validators'
import axios from 'axios'
import { ref } from 'vue';
import { useToastr } from '@/toastr';
import { environment } from '@/environments/environment'

const toastr = useToastr();
const emit = defineEmits(['close', 'onSubmit'])
const props = defineProps<Props>()
const employeeuser = ref([{ item: '--Select Employee--', value: null }])
const leave_count = ref();
const user_level = ref();
const description = ref();
const userLevel = ref();
//props
interface Props {
  data: any
  id: any
  employeeuser: any
}

//function for closing dialog
function closedialog() {
  emit('close')
}

onMounted(() => {
  getEStatus()
  //validate the data if != null then valdiate it again if the id = props.id then update the value of v-model from database
  if (props.data != null) {
    if (props.data.id == props.id)
    leave_count: leave_count.value = props.data.leave_count
    user_level: user_level.value = props.data.user_level
    description: description.value = props.data.description
  }
})

const getEStatus = () => {
  axios.get(environment.API_URL +'user/employees/getEmploymentOptions')
    .then((response) => {
      // EmPLOYMENT status
      if (response.data.success) {
        if (response.data.levels) {
          for (var x = 1; x < response.data.levels.length; x++) {
            employeeuser.value.push(
              {
                item: response.data.levels[x].name,
                value: response.data.levels[x].name
              }
            )
          }
        }
      }
    })
}

//function for editing the logs of the employee
const editleavelogs = (id: any) => {
  axios.put(environment.API_URL +'user/leave/editleave/' + id, {
    leave_count: leave_count.value,
    user_level: user_level.value,
    description: description.value,
  }).then((response) => {
    if (response.data.success) {
      emit('onSubmit')
      closedialog()
      toastr.success('Updated Successfully!');
    }
  }).catch((error) => {
    console.log(error , 'error')
  })
}
</script>

<template>
  <DialogCloseBtn @click.prevent="closedialog" />
  <VCard>
    <VCardText>
      <VRow>
        <VCol>
          <VCardTitle>
            Edit Logs
          </VCardTitle>
        </VCol>
      </VRow>
    </VCardText>
    <VDivider />
    <VCardText>
      <VRow>
        <VCol cols="12" sm="12">
          <div>
            <VCol>
              <VTextField type="number" variant="underlined" v-model="leave_count" :rules="[requiredValidator]" max=12
                oninput="if(this.value <= 0 || Number(this.value) > Number(this.max)) this.value = '';" />
            </VCol>
            <VCol>
              <VSelect v-model="user_level" :rules="[requiredValidator]" :items="employeeuser" item-title="item"
                item-value="value" variant="underlined"/>
            </VCol>
            <VCol>
              <VTextField type="text" variant="underlined" label="Text here" v-model="description"
                :rules="[requiredValidator]" />
            </VCol>
          </div>
        </VCol>
      </VRow>
    </VCardText>
    <VCardText>
      <VRow>
        <VCol class="d-flex justify-end">
          <VBtn color="error" variant="tonal" @click.prevent="closedialog" class="mr-2">CLOSE</VBtn>
          <VBtn @click.prevent="editleavelogs(id)">SAVE</VBtn>
        </VCol>
      </VRow>
    </VCardText>
  </VCard>
</template>
