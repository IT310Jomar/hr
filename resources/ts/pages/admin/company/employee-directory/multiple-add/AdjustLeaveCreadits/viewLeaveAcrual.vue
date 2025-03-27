<script setup lang="ts">
const emit = defineEmits(['close'])

const props = defineProps<Props>()
interface Props {
  credit: any
}

const closeDialog = () => {
  emit('close')
}
</script>
<template>
  <section>
    <DialogCloseBtn @click="closeDialog" />
    <VCard class="mb-5">
      <VCardTitle>
        View Leave Accrual
      </VCardTitle>
      <VCardText>
        <VRow>
          <VCol>
            <VTable class="bordered-table mb-5">
              <thead>
                <th scope="col" class="text-center">Transaction Date</th>
                <th scope="col" class="text-center">Usage Date</th>
                <th scope="col" class="text-center">Activity</th>
                <th scope="col" class="text-center">Credit / Debit</th>
                <th scope="col" class="text-center">Reason</th>
              </thead>
              <tbody v-if="props.credit.length > 0">
                <tr v-for="(data, index) in credit" :key="data.id">
                  <td scope="col" class="text-center"></td>
                  <td scope="col" class="text-center"></td>
                  <td scope="col" class="text-center"></td>
                  <td scope="col" class="text-center"></td>
                  <td scope="col" class="text-center"></td>
                </tr>
              </tbody>
              <tfoot v-else>
                <tr>
                  <td colspan="7" class="text-center">
                    No data available
                  </td>
                </tr>
              </tfoot>
            </VTable>
            <VDivider class="mb-3" />
            <VRow>
              <VCol class="d-flex justify-center">
                <VLabel>Current total leave credits: {{ credit.credits }}</VLabel>
              </VCol>
            </VRow>
          </VCol>
        </VRow>
      </VCardText>
      <VCardText class="d-flex justify-end flex-wrap gap-3">
        <VBtn @click.prevent="closeDialog" variant="tonal" color="error">
          CANCEL
        </VBtn>
      </VCardText>
    </VCard>
  </section>
</template>
