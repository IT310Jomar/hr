<script lang="ts" setup>
import { formatDate } from '@/helper';

const props = defineProps<Props>()
interface Props {
  Data: any
}
</script>

<template>
  <VCard>
    <VCardTitle class="text-center"><strong>
        Sirius - Attendance Management
      </strong>
    </VCardTitle>
    <VCardText>
      <VRow>
        <VCol>
          <VTable class="bordered">
            <thead>
              <tr>
                <th class="text-center">Employee ID</th>
                <th class="text-center">Full Name</th>
                <th class="text-center">Log In</th>
                <th class="text-center">Log Out</th>
                <th class="text-center">Total Hours</th>
              </tr>
            </thead>
            <tbody v-if="Data != ''">
              <tr v-for="(data, index) in Data" :key="data">
                <td class="text-center">{{ data.employee_id }}</td>
                <td class="text-center"> 
                  {{ data.employee.first_name }}
                  {{ data.employee.middle_name }}
                  {{ data.employee.last_name }}
                </td>
                <td class="text-left">
                  <VRow>
                    <VCol>
                      <ul>
                        <label>
                          Login Date:
                        </label> {{ formatDate(data.login) }}
                      </ul>
                      <ul>
                        <label>
                          Login Time:
                        </label> {{ data.timeIn }}
                      </ul>
                    </VCol>
                  </VRow>
                </td>
                <td class="text-left">
                  <VRow>
                    <VCol>
                      <ul>
                        <label>
                          Logout Date:
                        </label>
                        {{ formatDate(data.logOut) }}
                      </ul>
                      <ul>
                        <label>
                          Logout Time:
                        </label> {{ data.timeOut }}
                      </ul>
                    </VCol>
                  </VRow>
                </td>
                <td class="text-center"> {{ data.totalHours }}</td>
              </tr>
            </tbody>
            <tfoot v-else>
              <tr>
                <td colspan="8" class="text-center py-5">
                  <VProgressLinear indeterminate color="primary" />
                </td>
              </tr>
            </tfoot>
          </VTable>
        </VCol>
      </VRow>
    </VCardText>
  </VCard>
</template>

<style lang="scss">
.dialog-bottom-transition-enter-active,
.dialog-bottom-transition-leave-active {
  transition: transform 0.2s ease-in-out;
}
</style>
