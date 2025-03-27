<script lang="ts" setup>
import { formatDate } from '@/helper';
import { debounce } from 'lodash'
import axios from 'axios';
import { ref } from 'vue'
import { useToastr } from '@/toastr';
import DeclineUndertime from '@/pages/request/Undertime/DeclineUndertime.vue'
import ApprovedUndertime from '@/pages/request/Undertime/AcceptUndertime.vue'
const props = defineProps<Props>()
const emit = defineEmits(['updateCurrentPage','update-search-query','selected-per-page-change-undertime'])
const menusVariant = ['primary']
const searchQuery = ref('');
const approvedUndertimeData = ref()
const declinedUndertimeData = ref()
const acceptUndertimeRequest = ref(false)
const declineUndertimeRequest = ref(false)
const loading = ref(false);
const success = ref(false);
const toastr = useToastr();
const rowPerPage = ref(5);
const selected = ref('5')

type FormSubmittedEvent = (value: boolean) => void;
interface Emit {
  (e: 'submitted', callback: FormSubmittedEvent): void;
}

interface Props {
  paginatedDataUndertime: any
  totalPagesUndertime: any
  currentPage: any
  getUndertimeRequestPending: any
  perPages: any
  selectedPerPage: any
  itemsPerPage: any
}

//PaginitionPage
const paginationPendingPage = ref(props.currentPage)

const fetchID = (id: any) => {
    axios.get('/api/user/undertime/request/fetchdata' + id)
}

//decline
const requestDeclined = (id: any) => {
    axios.put(`/api/user/undertime/request/declined/undertimerequest/${id}`)
        .then((response) => {
            declinedUndertimeData.value = response.data
            props.getUndertimeRequestPending()
            toastr.success('Declined Successfully!')
        }).catch((error) => {

        })
};

//aprove
const requestApproved = (id: any) => {
    axios.put(`/api/user/undertime/request/approved/undertimerequest/${id}`)
        .then((response) => {
          approvedUndertimeData.value = response.data
            props.getUndertimeRequestPending()
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
  emit('selected-per-page-change-undertime', selectedValue);
}

// watch the data input search by the user for pending request
watch(searchQuery, debounce(() => {
    emit('update-search-query', searchQuery.value);
}, 100));

const acceptUndertime = (data: any) => {
  approvedUndertimeData.value = data
    acceptUndertimeRequest.value = true
}

const declineUndertime = (data: any) => {
  declinedUndertimeData.value = data
  declineUndertimeRequest.value = true
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
            <tr v-for="(data, index) in paginatedDataUndertime" :key="data.id" style="height: 3.75rem;"
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
                      <v-list-item title="Accept" @click="acceptUndertime(data)" />
                      <v-list-item title="Decline" @click="declineUndertime(data)" />
                    </v-list>
                  </VMenu>
                </td>
            </tr>
        </tbody>
        <!-- 👉 table footer  -->
        <tfoot v-show="!paginatedDataUndertime.length">
            <tr>
                <td colspan="7" class="text-center">
                  Nothing to see here
                </td>
            </tr>
        </tfoot>
    </VTable>

    <VPagination v-model="paginationPendingPage" size="small" :length="totalPagesUndertime" @update:model-value="updatePage"
    class="mb-5" />

        <!-- Dialog For Approved Undertime Request -->
        <VDialog v-model="acceptUndertimeRequest" max-width="600">
            <ApprovedUndertime @closeDialog="acceptUndertimeRequest = false" :approvedUndertimeData="approvedUndertimeData"
                :requestApproved="requestApproved" />
        </VDialog>

        <!-- Dialog For Declining Undertime Request -->
        <VDialog v-model="declineUndertimeRequest" max-width="600">
            <DeclineUndertime @closeDialog="declineUndertimeRequest = false" :declinedUndertimeData="declinedUndertimeData"
                :requestDeclined="requestDeclined" />
        </VDialog>

</template>
