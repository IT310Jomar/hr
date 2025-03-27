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
        Sirius - Employee List Report
      </strong>
    </VCardTitle>
    <VCardText>
      <VRow>
        <VCol>
          <VTable class="px-5 mb-7">
            <thead>
              <tr>
                <th style="min-width: 150px; width: auto;" class="text-center">
                  Employee ID No
                </th>
                <th class="text-center">
                  Full Name
                </th>
                <th class="text-center">
                  Department
                </th>
                <th class="text-center">
                  Title
                </th>
                <th class="text-center">
                  Date Hired
                </th>
                <th class="text-center">
                  Date Regularization
                </th>
                <th class="text-center">
                  Status
                </th>
              </tr>
            </thead>
            <tbody v-if="Data != ''">
              <tr v-for="(data, index) in Data" :key="data">
                <td class="text-center">{{ data.id }}</td>
                <td class="text-center">
                  {{ data.first_name }}
                  {{ data.middle_name }}
                  {{ data.last_name }}
                </td>
                <td class="text-center">{{ data.employments.departments.name }}</td>
                <td class="text-center">{{ data.employments.title }}</td>
                <td class="text-center">{{ formatDate( data.employments.date_hired ) }}</td>
                <td class="text-center">{{ formatDate( data.employments.date_regularization ) }}</td>
                <td class="text-center">{{ data.employments.employmentstatus.name }}</td>
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
