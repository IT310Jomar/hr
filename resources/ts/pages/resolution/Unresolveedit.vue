<script setup lang="ts">
import { environment } from "@/environments/environment"
import axios from "axios"
import moment from "moment"

const selectedItem = ref('Leave')
const items = ref()
const props = defineProps(['test'])
const userEmail = ref()

</script>

<template>
  <section>
    <VCard title="Missing Logs">
      <VDivider />
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
              <VCol hidden>
                <VTextField type="text" v-model="userEmail">
                  {{ props.test.employee.user.email }}
                </VTextField>
              </VCol>
              <VTable>
                <tbody>
                  <tr>
                    <td>IN</td>
                    <td>{{ moment(props.test.employee.attendance_logs[0].timeIn, 'H:mm A').format('H:mm A') }}</td>
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
                <VTextarea label="Message" />
              </div>
            </div>
          </VCol>
        </VRow>
      </VCardText>
      <VDivider class="mb-1 mt-1" />
      <VCardText class="d-flex justify-end flex-wrap gap-3">
        <VBtn>
          Submit
        </VBtn>
      </VCardText>
    </VCard>
  </section>
</template>
