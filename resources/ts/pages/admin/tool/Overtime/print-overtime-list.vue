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
        Sirius - Overtime List Report
      </strong>
    </VCardTitle>
    <VCardText>
      <VRow>
        <VCol>
          <VTable class="px-5 mb-7">
            <thead>
              <tr>
                <th style="min-width: 150px; width: auto;" class="text-center">Employe ID</th>
                <th class="text-center">Full Name</th>
                <th class="text-center">Day</th>
                <th class="text-center">Shift Date</th>
                <th class="text-center">Shift From</th>
                <th class="text-center">Shift To</th>
                <th class="text-center">OT Start</th>
                <th class="text-center">OT End</th>
                <th class="text-center">Date Approved</th>
              </tr>
            </thead>
            <tbody v-if="Data != ''">
              <tr v-for="(data, index) in Data" :key="data">
                <td class="text-center">{{ data.id }}</td>
                <td class="text-center">
                  {{ data.employee.first_name }}
                  {{ data.employee.middle_name }}
                  {{ data.employee.last_name }}
                </td>
                <td class="text-center">{{ data.day }}</td>
                <td class="text-center">{{ formatDate(data.shift_date) }}</td>
                <td class="text-center">{{ data.shift_from }}</td>
                <td class="text-center">{{ data.shift_to }}</td>
                <td class="text-center">{{ data.start }}</td>
                <td class="text-center">{{ data.end }}</td>
                <td class="text-center">{{ formatDate(data.updated_at) }}</td>
              </tr>
            </tbody>
            <!-- 👉 table footer  -->
            <tfoot v-else>
              <tr>
                <td colspan="8" class="text-center py-10">
                  Nothing to see here
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
