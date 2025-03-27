<script lang="ts" setup>
import { formatDate } from '@/helper';
import { debounce } from 'lodash'
import axios from 'axios';
import { ref } from 'vue'
import DeclineRequest from '@/pages/request/Advance/DeclineRequest.vue';
import AcceptRequest from '@/pages/request/Advance/AcceptRequest.vue';
import { useToastr } from '@/toastr';

type FormSubmittedEvent = (value: boolean) => void;
interface Emit {
  (e: 'submitted', callback: FormSubmittedEvent): void;
}
const props = defineProps<Props>()
const emit = defineEmits(['updateCurrentPage','update-search-query','selected-per-page-change'])
const menusVariant = ['primary']
const searchQuery = ref('');
const approvedData = ref()
const declinedData = ref()
const acceptCashRequest = ref(false)
const declineCashRequest = ref(false)
const loading = ref(false);
const success = ref(false);
const toastr = useToastr();
const rowPerPage = ref(5);
const selected = ref('5')

interface Props {
  paginatedData: any
  totalPages: any
  currentPage: any
  getCashAdvance: any
  perPages: any
  selectedPerPage: any
  itemsPerPage: any
}

//PaginitionPage
const paginationPendingPage = ref(props.currentPage)

//aprove
const approveCashAdvance = (data: any) => {
    approvedData.value = data
    acceptCashRequest.value = true
}

//decline
const declineCashAdvance = (data: any) => {
    declinedData.value = data
    declineCashRequest.value = true
}

//aprove
const requestApproved = (id: any) => {
  axios.put(`/api/user/cash/advance/approverequest/${id}`)
      .then((response) => {
          if (response.data.success) {
              success.value = true
              approvedData.value = response.data.dataApproved
              props.getCashAdvance()
              loading.value = false
              toastr.success('Approved Successfully!')
          }
      }).catch((error) => {
          if (error) {
            toastr.error('Approved Request Failed!')
              loading.value = true;
              setTimeout(() => {
                  loading.value = false;
              }, 4000);
          }
      })
};

//decline
const requestDeclined = (id: any) => {
  axios.put(`/api/user/cash/advance/declinerequest/${id}`)
      .then((response) => {
          if (response.data.success) {
              success.value = true
              declinedData.value = response.data.dataDeclined
              props.getCashAdvance()
              loading.value = false
              toastr.success('Declined Successfully!')
          }
      }).catch((error) => {
          if (error) {
            toastr.error('Declined Request Failed!')
              loading.value = true;
              setTimeout(() => {
                  loading.value = false;
              }, 4000);
          }
      })
};

//handle the pagination in pending request that will emitted to the parent component
function updatePage(newPage: number) {
  paginationPendingPage.value = newPage
  emit('updateCurrentPage', newPage)
  // console.log(paginationPendingPage.value)
};

// for changing the item per page for pending
function onChangeSelectedPerPage(selectedValue: number) {
  emit('selected-per-page-change', selectedValue);
}

// watch the data input search by the user for pending request
watch(searchQuery, debounce(() => {
    emit('update-search-query', searchQuery.value);
}, 100));

</script>

<template>
  <VCardText class="d-flex flex-wrap py-4 gap-4">
    <div class="me-3" style="width: 80px;">
      <v-select
        v-model="selected"
        :items="perPages" :item-value="itemsPerPage" :item-title="selectedPerPage" @update:modelValue="onChangeSelectedPerPage">
        <!-- <option style="color: #444;" v-for="perPage in perPages" :key="perPage" :value="perPage">{{ perPage
        }}</option> -->
      </v-select>
      <!-- <VSelect v-model="rowPerPage" density="compact" variant="outlined" :items="[10, 20, 30, 50]" /> -->
    </div>

    <VSpacer />

    <div class="app-user-search-filter d-flex align-center flex-wrap gap-4 justify-end">

      <!-- 👉 Search  -->
      <div style="width: 15rem;">
        <VTextField v-model="searchQuery" placeholder="Search" density="compact" append-inner-icon="mdi-magnify"/>
      </div>

    </div>
  </VCardText>

  <VTable class="text-no-wrap mt-5 mb-5">
    <!-- 👉 table head -->
    <thead>
      <tr>
        <th class="text-center" scope="col">
          Emp ID
        </th>
        <th class="text-center" scope="col">
          Name
        </th>
        <th class="text-center" scope="col">
          Date Requested
        </th>
        <th class="text-center" scope="col">
          Action
        </th>
      </tr>
    </thead>
    <!-- 👉 table body -->
    <tbody>
      <tr v-for="(data, index) in paginatedData" :key="data.id" style="height: 3.75rem;" class="text-center">
        <td class="text-center">{{ index + 1 }}</td>
        <td class="text-center">{{ data.employee?.first_name }} {{ data.employee?.middle_name }} {{ data.employee?.last_name }}</td>
        <td class="text-center">{{ formatDate(data.requested_date) }}</td>
        <td class="text-center">
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
        </td>
      </tr>
    </tbody>
    <!-- 👉 table footer  -->
    <tfoot v-show="!paginatedData.length">
      <tr>
        <td colspan="7" class="text-center">
          Nothing to see here
        </td>
      </tr>
    </tfoot>
  </VTable>
  <VPagination v-model="paginationPendingPage" size="small" :length="totalPages" @update:model-value="updatePage"
    class="mb-5" />

  <!-- Dialog For Accepting Cash Advance Request-->
  <VDialog v-model="acceptCashRequest" max-width="600">
      <AcceptRequest @closeDialog="acceptCashRequest = false" :approvedData="approvedData"
          :requestApproved="requestApproved"/>
  </VDialog>

  <!-- Dialog For Declining Cash Advance Request -->
  <VDialog v-model="declineCashRequest" max-width="600">
      <DeclineRequest @closeDialog="declineCashRequest = false" :declinedData="declinedData"
          :requestDeclined="requestDeclined" />
  </VDialog>
</template>
