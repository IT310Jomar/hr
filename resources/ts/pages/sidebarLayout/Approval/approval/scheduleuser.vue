<script lang="ts" setup>
import { formatDate } from '@/helper';
import { debounce } from 'lodash'
import axios from 'axios';
import { ref } from 'vue'
import { useToastr } from '@/toastr';
import DeclineSchedule from '@/pages/request/Schedule/DeclineSchedule.vue'
import ApprovedSchedule from '@/pages/request/Schedule/AcceptSchedule.vue'

type FormSubmittedEvent = (value: boolean) => void;
interface Emit {
  (e: 'submitted', callback: FormSubmittedEvent): void;
}

const props = defineProps<Props>()
const emit = defineEmits(['updateCurrentPage','update-search-query','selected-per-page-change-schedule-adjustment'])

const menusVariant = ['primary']
const searchQuery = ref('');
const approvedData = ref()
const declinedScheduleData = ref()
const acceptScheduleAdjustmentRequest = ref(false)
const declineScheduleAdjustmentRequest = ref(false)
const loading = ref(false);
const success = ref(false);
const toastr = useToastr();
const rowPerPage = ref(5);
const selected = ref('5');

interface Props {
  paginatedDataScheduleAdjustment: any
  totalPagesScheduleAdjustment: any
  currentPage: any
  getScheduleAdjustmentRequestPending: any
  perPages: any
  selectedPerPage: any
  itemsPerPage: any
}

//PaginitionPage
const paginationPendingPage = ref(props.currentPage)

//decline
const requestDeclined = (id: any) => {
    axios.put(`/api/user/schedule/adjustment/declined/schedulerequest/${id}`)
        .then((response) => {
          declinedScheduleData.value = response.data
            props.getScheduleAdjustmentRequestPending()
            toastr.success('Declined Successfully!')
        }).catch((error) => {

        })
};

//aprove
const requestApproved = (id: any) => {
    axios.put(`/api/user/schedule/adjustment/approved/schedulerequest/${id}`)
        .then((response) => {
            approvedData.value = response.data
            props.getScheduleAdjustmentRequestPending()
            toastr.success('Approved Successfully!')
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
  emit('selected-per-page-change-schedule-adjustment', selectedValue);
}

// watch the data input search by the user for pending request
watch(searchQuery, debounce(() => {
    emit('update-search-query', searchQuery.value);
}, 100));

const acceptScheduleAdjustment = (data: any) => {
    approvedData.value = data
    acceptScheduleAdjustmentRequest.value = true
}

const declineScheduleAdjustment= (data: any) => {
  declinedScheduleData.value = data
    declineScheduleAdjustmentRequest.value = true
}

</script>
<template>
  <VCardText class="d-flex flex-wrap py-4 gap-4">
    <div class="me-3" style="width: 80px;">
      <v-select
        v-model="selected"
        :items="perPages" :item-value="itemsPerPage" :item-title="selectedPerPage" @update:modelValue="onChangeSelectedPerPage">
      </v-select>
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
            <tr v-for="(data, index) in paginatedDataScheduleAdjustment" :key="data.id" style="height: 3.75rem;"
                class="text-center">
                <td class="text-center">{{ index + 1 }}</td>
                <td class="text-center">{{ data.employee?.first_name }} {{ data.employee?.middle_name }} {{ data.employee?.last_name }}</td>
                <td class="text-center">{{ formatDate(data.created_at) }}</td>
                <td class="text-center">
                  <VMenu v-for="menu in menusVariant" :key="menu">
                    <template #activator="{ props }">
                      <VBtn icon size="small" color="default" v-bind="props" variant="text">
                        <VIcon icon="tabler:dots-vertical"></VIcon>
                      </VBtn>
                    </template>
                    <v-list class="text-center">
                      <v-list-item title="Accept" @click="acceptScheduleAdjustment(data)" />
                      <v-list-item title="Decline" @click="declineScheduleAdjustment(data)" />
                    </v-list>
                  </VMenu>
                </td>
            </tr>
        </tbody>
        <!-- 👉 table footer  -->
        <tfoot v-show="!paginatedDataScheduleAdjustment.length">
            <tr>
                <td colspan="7" class="text-center">
                  Nothing to see here
                </td>
            </tr>
        </tfoot>
    </VTable>

    <VPagination v-model="paginationPendingPage" size="small" :length="totalPagesScheduleAdjustment" @update:model-value="updatePage"
    class="mb-5" />

        <!-- Dialog For Approved ScheduleAdjustment Request -->
        <VDialog v-model="acceptScheduleAdjustmentRequest" max-width="600">
            <ApprovedSchedule @closeDialog="acceptScheduleAdjustmentRequest = false" :approvedData="approvedData"
                :requestApproved="requestApproved" />
        </VDialog>

        <!-- Dialog For Declining ScheduleAdjustment Request -->
        <VDialog v-model="declineScheduleAdjustmentRequest" max-width="600">
            <DeclineSchedule @closeDialog="declineScheduleAdjustmentRequest = false"
                :requestDeclined="requestDeclined" :declinedScheduleData="declinedScheduleData" />
        </VDialog>

</template>
