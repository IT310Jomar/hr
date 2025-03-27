<script setup lang="ts">
import Fill_InBtn from '@/layouts/components/Fill_InBtn.vue'
import { formatDate } from '@/helper';

import axios from 'axios';
import {
  ref,
  onMounted,
  reactive,
  watch
} from 'vue';

const cashAdvancePending = ref(['']);


// Cash Advance Data || Pending Data
const getCashAdvance = () => {
  axios.get('/api/user/cash/advance')
    .then((response) => {
      cashAdvancePending.value = response.data.cashAdvancePending
    }).catch(error => {
      console.log('errror')
    })
}

onMounted(() => {
  getCashAdvance();
});

const userRole = JSON.parse(localStorage.getItem('userRole') || 'null')


</script>


<template>
  <VCol v-if="userRole == 'God Mode' || userRole == 'Administrator'">
    <VCard title="Approval Center">
      <div class="float-right">

        <Fill_InBtn />
      </div>
      <VDivider class="mb-5" />
      <div>
        <VTable class="px-5 mb-5">
          <tbody>
            <tr v-for="(data, index) in cashAdvancePending" :key="data.id" style="height: 3.75rem;" class="text-center">
              <td>{{ index + 1 }}</td>
              <td>Wala Pani!!</td>
              <td>{{ formatDate(data.requested_date) }}</td>
              <!-- <td class="text-center">
                  <VMenu v-for="menu in menusVariant" :key="menu">
                    <template #activator="{ props }">
                      <VBtn icon size="small" color="default" v-bind="props" variant="text">
                        <VIcon icon="tabler:dots-vertical"></VIcon>
                      </VBtn>
                    </template>
                    <v-list class="text-center">
                      <v-list-item title="Accept" @click="approveCashAdvance(data)" />
                      <v-list-item title="Decline" @click="declineCashAdvance(data)" />
                    </v-list>
                  </VMenu>
                </td> -->
            </tr>
          </tbody>
          <!-- 👉 table footer  -->
          <tfoot v-show="!cashAdvancePending.length">
            <tr>
              <td colspan="7" class="text-center" style="padding-top: 8%; padding-bottom: 8%; font-size: larger;">
                Good job, you have nothing pending.
              </td>
            </tr>
          </tfoot>
        </VTable>
      </div>
    </VCard>
  </VCol>
</template>

