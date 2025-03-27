<script lang="ts" setup>
import { formatDate } from '@/helper';
import { debounce } from 'lodash'
import axios from 'axios';
import { ref } from 'vue'
import { useToastr } from '@/toastr';
import DeclineRequest from '@/pages/request/Leave/DeclineLeave.vue';
import AcceptRequest from '@/pages/request/Leave/AcceptLeave.vue';


type FormSubmittedEvent = (value: boolean) => void;
interface Emit {
  (e: 'submitted', callback: FormSubmittedEvent): void;
}

const props = defineProps<Props>()
const emit = defineEmits(['updateCurrentPage', 'update-search-query-leave', 'selected-per-page-change-leave'])
const menusVariant = ['primary']
const searchQuery = ref('');
const approvedData = ref()
const declinedData = ref()
const acceptLeaveRequest = ref(false)
const declineLeaveRequest = ref(false)
const loading = ref(false);
const success = ref(false);
const toastr = useToastr();
const rowPerPage = ref(5);
const selected = ref('5')
const selectedreason = ref()


interface Props {
  paginatedDataLeave: any
  totalPagesLeave: any
  currentPage: any
  getLeave: any
  perPages: any
  selectedPerPage: any
  itemsPerPage: any
}

//PaginitionPage
const paginationPendingPage = ref(props.currentPage)

//aprove
const approveCashAdvance = (data: any) => {
  approvedData.value = data
  acceptLeaveRequest.value = true
}

//decline
const declineCashAdvance = (data: any) => {
  declinedData.value = data
  declineLeaveRequest.value = true
}

//aproved
const requestApproved = (id: any) => {
  axios.put(`/api/user/leave/request/approved/leaverequest/${id}`)
    .then((response) => {
      approvedData.value = response.data
      success.value = true
      props.getLeave()
      loading.value = false
      toastr.success('Approved Successfully!')
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


//declined
const requestDeclined = (id: any) => {
  axios.put(`/api/user/leave/request/declined/leaverequest/${id}`)
    .then((response) => {
      declinedData.value = response.data
      success.value = true
      props.getLeave()
      loading.value = false
      toastr.success('Declined Successfully!')
    }).catch((error) => {

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
  emit('selected-per-page-change-leave', selectedValue);
}

// watch the data input search by the user for pending request
watch(searchQuery, debounce(() => {
  emit('update-search-query-leave', searchQuery.value);
}, 100));

</script>
<template>
  <VCardText class="d-flex flex-wrap py-4 gap-4">
    <div class="me-3" style="width: 80px;">
      <v-select v-model="selected" :items="perPages" :item-value="itemsPerPage" :item-title="selectedPerPage"
        @update:modelValue="onChangeSelectedPerPage">
        <!-- <option style="color: #444;" v-for="perPage in perPages" :key="perPage" :value="perPage">{{ perPage
            }}</option> -->
      </v-select>
      <!-- <VSelect v-model="rowPerPage" density="compact" variant="outlined" :items="[10, 20, 30, 50]" /> -->
    </div>

    <VSpacer />

    <div class="app-user-search-filter d-flex align-center flex-wrap gap-4 justify-end">

      <!-- 👉 Search  -->
      <div style="width: 15rem;">
        <VTextField v-model="searchQuery" placeholder="Search" density="compact" append-inner-icon="mdi-magnify" />
      </div>

    </div>
  </VCardText>

  <VTable class="text-no-wrap mt-5 mb-5">
    <!-- 👉 table head -->
    <thead>
      <tr>
        <th class="text-center">Employee Name</th>
        <th class="text-center">Leave Type</th>
        <th class="text-center">Date From</th>
        <th class="text-center">Date To</th>
        <th class="text-center">Reason</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <!-- 👉 table body -->
    <tbody>
      <tr v-for="(data, index) in paginatedDataLeave" :key="data.id" style="height: 3.75rem;">
        <td class="text-center">{{ data.employee?.first_name }} {{ data.employee?.middle_name }} {{
          data.employee?.last_name }}</td>
        <td class="text-center">{{ data.leave_type }}</td>
        <td class="text-center">{{ formatDate(data.date_from) }}</td>
        <td class="text-center">{{ formatDate(data.date_to) }}</td>
        <td class="text-center">{{ data.reason }}</td>
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

      <!-- <div class="px-3">
        <label>Reason</label>
        <v-textarea rows="3" class="form-control" disabled>{{ data.reason }}</v-textarea>
      </div> -->

    </tbody>

    <!-- 👉 table footer  -->
    <tfoot v-show="!paginatedDataLeave.length">
      <tr>
        <td colspan="7" class="text-center">
          Nothing to see here
        </td>
      </tr>
    </tfoot>

  </VTable>



  <!-- Pagination-->
  <VPagination v-model="paginationPendingPage" size="small" :length="totalPagesLeave" @update:model-value="updatePage"
    class="mb-5" />

  <!-- Dialog For Accepting Leave Request-->
  <VDialog v-model="acceptLeaveRequest" max-width="600">
    <AcceptRequest @closeDialog="acceptLeaveRequest = false" :approvedData="approvedData"
      :requestApproved="requestApproved" />
  </VDialog>

  <!-- Dialog For Declining Leave Request -->
  <VDialog v-model="declineLeaveRequest" max-width="600">
    <DeclineRequest @closeDialog="declineLeaveRequest = false" :declinedData="declinedData"
      :requestDeclined="requestDeclined" />
  </VDialog>
</template>
