<script setup lang="ts">
import { environment } from "@/environments/environment"
import axios from "axios"
import moment from "moment"
const isDialogVisible = ref(false)
const selectedItem = ref('Leave')
const items = ref()
const props = defineProps(['editRes'])
const userEmail = ref()
const token = JSON.parse(localStorage.getItem('accessToken') || 'null');

const getRequestTypes = () => {
  axios.get(environment.API_URL + 'user/resolution/request-types', { params : { token : token } })
  .then(response => {
    items.value = []
    if(response.data.success) {
      if(response.data.requestTypes) {
        for(var i = 0 ; i < response.data.requestTypes.length ; i++) {
          items.value.push({
            item : response.data.requestTypes[i].name,
            value : response.data.requestTypes[i].id,
          })
        }
      }
    }
  })
}

onMounted(() => {
  getRequestTypes()
})

</script>

<template>
  <section>
    <!-- Dialog Content -->
    <VCard title="Missing Logs">
      <VDivider/>
      <VCardText>
        <VRow>
          <VCol cols="12" sm="12">
            <div>
              <VListItemTitle class="mb-3 " style=" font-size: 15px;">
                You have a missing biologs for this day
              </VListItemTitle>
              <VListItemTitle class="mb-3 mt-5" style=" font-size: 20px;">
                Logs on this day
              </VListItemTitle>
              <VTable>
                <tbody>
                  <tr>
                    <td>IN</td>
                    <td>{{ moment(props.editRes.employee.attendance_logs[0].timeIn, 'H:mm A').format('H:mm A') }}</td>
                  </tr>
                </tbody>
              </VTable>
              <VDivider />
              <VForm class="mb-4" action="#">
                <p class="mt-6 ">Missing Out</p>
              </VForm>
              <VForm class="mb-4" action="#">
                <p class="mt-6 ">File on behalf of employee</p>
              </VForm>
              <div class="form-group">
                <label for="activity" class="form-label">activity</label>
                <VCombobox v-model="selectedItem" :items="items" item-title="item" item-value="value" />
              </div>
            </div>
          </VCol>
        </VRow>
      </VCardText>
      <VDivider class="mb-1 mt-1" />
      <VCardText class="d-flex justify-end flex-wrap gap-3">
        <VBtn @click="isDialogVisible = false">
          Submit
        </VBtn>
      </VCardText>
    </VCard>
  </section>
</template>
