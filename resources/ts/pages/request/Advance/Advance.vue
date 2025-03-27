<script lang="ts" setup>
import { ref } from 'vue'
import { debounce } from 'lodash';
import axios from 'axios';
import moment from 'moment';
import DeclineRequest from './DeclineRequest.vue';
import EditDataVue from './EditData.vue';
import ViewAccepted from './ViewAccepted.vue';
import ViewDeclined from './ViewDeclined.vue';
import { environment } from '@/environments/environment';
import { toast } from 'vue3-toastify';

const props = defineProps(['paginatedDataPending', 'paginatedDataApproved', 'paginatedDataDeclined', 'editrequest', 'viewRequestData',
    'getCashAdvance', 'getApprovedCashAdvance', 'getCancelledCashAdvance', 'handleFormUpdate', 'totalPages', 'totalPagesApproved',
    'totalPagesDeclined', 'currentPage', 'currentPageApproved', 'currentPageDeclined', 'itemsPerPage', 'itemsPerApproved', 'itemsPerDeclined',
    'perPages', 'perPagesApproved', 'perPagesDeclined', 'selectedPerPage', 'selectedPerPageApproved', 'selectedPerPageDeclined'])
const emit = defineEmits(['update-search-query', 'update-search-query-approved', 'update-search-query-declined',
    'updateCurrentPage', 'updateCurrentPageApproved', 'updateCurrentPageDeclined',
    'selected-per-page-change', 'selected-approved', 'selected-declined'])

const currentTab = ref('pending')
const searchQuery = ref('')
const searchQueryApproved = ref('')
const searchQueryDeclined = ref('')
const selected = ref(props.itemsPerPage)
const menusVariant = ['primary']
const approvedData = ref()
const declinedData = ref()
const editData = ref()
const declineCashRequest = ref(false)
const editCashRequest = ref(false)
const viewAcceptedRequest = ref(false)
const viewDeclinedRequest = ref(false)
const success = ref(false)
const updateSuccess = ref(false)
const canceledSuccess = ref(false)
const paginationPendingPage = ref(props.currentPage)
const paginationApprovedPage = ref(props.currentPageApproved)
const paginationDeclinedPage = ref(props.currentPageDeclined)



const handleFormSubmit = () => {
    updateSuccess.value = true
}
const handleFormCancel = () => {
    canceledSuccess.value = true
}

//For the date Format in mm/dd/yyyy
function formatDate(dateString: any) {
    const date = new Date(dateString);
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    const year = date.getFullYear();
    return `${month}/${day}/${year}`;

}//end

//handle the pagination in pending request that will emitted to the parent component
function updatePage(newPage: number) {
    paginationPendingPage.value = newPage
    emit('updateCurrentPage', newPage)
    console.log(paginationPendingPage.value)
};
//handle the pagination in approved request that will emitted to the parent component
function updatePageApproved(newPageApproved: number) {
    paginationApprovedPage.value = newPageApproved
    emit('updateCurrentPageApproved', newPageApproved)
    console.log(paginationApprovedPage.value)
};

//handle the pagination in declined request that will emitted to the parent component
function updatePageDeclined(newPageDeclined: number) {
    paginationDeclinedPage.value = newPageDeclined
    emit('updateCurrentPageDeclined', newPageDeclined)
    console.log(paginationDeclinedPage.value)
};


// watch the data input search by the user for pending request
watch(searchQuery, debounce(() => {
    emit('update-search-query', searchQuery.value);
}, 100));

// watch the data input search by the user for approved request
watch(searchQueryApproved, debounce(() => {
    emit('update-search-query-approved', searchQueryApproved.value);
}, 100));

//watch the data input search by the user for declined request
watch(searchQueryDeclined, debounce(() => {
    emit('update-search-query-declined', searchQueryDeclined.value);
}, 100));

const fetchID = (id: any) => {
    axios.get('/api/user/cash/advance/fetchdata' + id)
}

// for changing the item per page for pending
function onChangeSelectedPerPage(selectedValue: number) {
    emit('selected-per-page-change', selectedValue);
}

// for changing the item per page for approved
function onChangeSelectedPerPageApproved(selectedValue: number) {
    emit('selected-approved', selectedValue);
}

// for changing the item per page for declined
function onChangeSelectedPerPageDeclined(selectedValue: number) {
    emit('selected-declined', selectedValue);
}


const declineCashAdvance = (data: any) => {
    declinedData.value = data
    declineCashRequest.value = true
}

const editCashAdvance = (data: any) => {
    editData.value = data
    editCashRequest.value = true
}

const viewAcceptedCashAdvance = (approved: any) => {
    approvedData.value = approved
    viewAcceptedRequest.value = true
}

const viewDeclineddCashAdvance = (declined: any) => {
    declinedData.value = declined
    viewDeclinedRequest.value = true
}

const requestDeclined = (id: any) => {
    axios.put(environment.API_URL + `user/cash/advance/declinerequest/${id}`)
        .then((response) => {
            if (response.data.success) {
                toast("Canceled Successfully!", {
                    autoClose: 4000,
                    type: 'success',
                    theme: 'colored',
                    style: {
                        width: '350px' // Set the width to 400 pixels
                    }
                })
                declinedData.value = response.data.dataDeclined
                props.getCashAdvance()
                props.getCancelledCashAdvance()
            }
        }).catch((error) => {
            toast("Cancel Error.", {
                autoClose: 4000,
                type: 'error',
                theme: 'colored',
                style: {
                    width: '350px' // Set the width to 400 pixels
                }
            })
        })
};

const updateRequest = (viewRequestData: any, id: any) => {
    axios.put(environment.API_URL + `user/cash/advance/update/${id}`, {
        id: viewRequestData.id,
        amount: viewRequestData.amount,
        requested_date: viewRequestData.requested_date,
        reasons: viewRequestData.reasons
    }).then((response) => {
        toast("Successfully Updated!", {
            autoClose: 4000,
            type: 'success',
            theme: 'colored',
            style: {
                width: '350px' // Set the width to 400 pixels
            }
        })
    })
        .catch((error) => {
            toast("Update Error", {
                autoClose: 4000,
                type: 'error',
                theme: 'colored',
                style: {
                    width: '350px' // Set the width to 400 pixels
                }
            })
        })
}

onMounted(() => {

})

</script>

<template>
    <section>

        <v-card-title>Cash Advance</v-card-title>
        <v-tabs v-model="currentTab" class="mt-5 mb-5">
            <VTab value="pending"> Pending / Resubmitted For Editing</VTab>
            <VTab value="approved"> Approved</VTab>
            <VTab value="rejected">Rejected / Cancelled</VTab>
        </v-tabs>

        <v-window v-model="currentTab">
            <v-window-item value="pending">
                <v-card-text class="d-flex flex-wrap py-4 gap-4">
                    <div class="me-3" style="width: 80px;">
                        <VSelect v-model="selected" :items="perPages" :item-value="itemsPerPage"
                            :item-title="selectedPerPage" @update:modelValue="onChangeSelectedPerPage" />
                    </div>
                    <VSpacer />
                    <div class="app-user-search-filter d-flex align-center flex-wrap gap-4 justify-end"
                        style="width: 15rem;">
                        <v-text-field v-model="searchQuery" label="Search" class="search-field" solo
                            append-inner-icon="mdi-magnify">
                        </v-text-field>
                    </div>
                </v-card-text>
                <!-- 👉 table head -->
                <VTable class="text-no-wrap mt-5 mb-5">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">
                                #
                            </th>
                            <th class="text-center" scope="col">
                                Date Requested
                            </th>
                            <th class="text-center" scope="col">
                                Amount
                            </th>
                            <th class="text-center" scope="col">
                                Reason
                            </th>
                            <th class="text-center" scope="col">
                                Status
                            </th>
                            <th class="text-center" scope="col">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <!-- 👉 table body -->
                    <tbody>
                        <tr v-for="(data, index) in paginatedDataPending" :key="data.id" style="height: 3.75rem;">

                            <td class="text-center">{{ index + 1 }}</td>
                            <td class="text-center">{{ formatDate(data.requested_date) }}</td>
                            <td class="text-center">{{ data.amount }}</td>
                            <td class="text-center" style="width: 100px">{{ data.reasons }}</td>
                            <td class="text-center">
                                <VChip color="warning">{{ data.request_status }}
                                    <VIcon end size="16" icon="ph:clock-clockwise" />
                                </VChip>
                            </td>
                            <td class="text-center">
                                <VMenu v-for="menu in menusVariant" :key="menu">
                                    <template #activator="{ props }">
                                        <VBtn icon size="small" color="default" v-bind="props" variant="text">
                                            <VIcon icon="tabler:dots-vertical"></VIcon>
                                        </VBtn>
                                    </template>
                                    <v-list class="text-center">
                                        <v-list-item title="Cancel" @click="declineCashAdvance(data)" />
                                        <v-list-item title="Edit" @click="editCashAdvance(data)" />
                                    </v-list>
                                </VMenu>
                            </td>
                        </tr>
                    </tbody>
                    <!-- 👉 table footer  -->
                    <tfoot v-show="!paginatedDataPending.length" class="py-100">
                        <tr>
                            <td colspan="7" class="text-center">
                                No data available
                            </td>
                        </tr>
                    </tfoot>
                </VTable>
                <VPagination :length="totalPages" v-model="paginationPendingPage" @update:model-value="updatePage" />
            </v-window-item>

            <v-window-item value="approved">
                <v-card-text class="d-flex flex-wrap py-4 gap-4">
                    <div class="me-3" style="width: 80px;">
                        <VSelect v-model="selected" :items="perPagesApproved" :item-value="itemsPerApproved"
                            :item-title="selectedPerPageApproved" @update:modelValue="onChangeSelectedPerPageApproved" />
                    </div>
                    <VSpacer />
                    <div class="app-user-search-filter d-flex align-center flex-wrap gap-4 justify-end"
                        style="width: 15rem;">
                        <v-text-field v-model="searchQueryApproved" label="Search" class="search-field" solo
                            append-inner-icon="mdi-magnify">
                        </v-text-field>
                    </div>
                </v-card-text>
                <VTable class="text-no-wrap mt-5 mb-5">
                    <!-- 👉 table head -->
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">
                                #
                            </th>
                            <th class="text-center" scope="col">
                                Requested Date
                            </th>
                            <th class="text-center" scope="col">
                                Amount
                            </th>
                            <th class="text-center" scope="col">
                                Reason
                            </th>
                            <th class="text-center" scope="col">
                                Date Approved
                            </th>
                            <th class="text-center" scope="col">
                                Status
                            </th>
                            <th class="text-center" scope="col">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <!-- 👉 table body -->
                    <tbody>
                        <tr v-for="(data, index) in paginatedDataApproved" :key="data.id" style="height: 3.75rem;">

                            <td class="text-center">{{ index + 1 }}</td>
                            <td class="text-center">{{ moment(data.requested_date).format('MM/DD/YYYY') }}</td>
                            <td class="text-center">{{ data.amount }}</td>
                            <td class="text-center break-text">{{ data.reasons }}</td>
                            <td class="text-center">{{ moment(data.date_approved).format('MM/DD/YYYY') }}</td>
                            <td class="text-center">
                                <VChip color="success">
                                    {{ data.request_status }}
                                    <VIcon end size="16" icon="ic:baseline-check-circle-outline" />
                                </VChip>
                            </td>
                            <td class="text-center">
                                <VMenu v-for="menu in menusVariant" :key="menu">
                                    <template #activator="{ props }">
                                        <VBtn icon size="small" color="default" v-bind="props" variant="text">
                                            <VIcon icon="tabler:dots-vertical"></VIcon>
                                        </VBtn>
                                    </template>

                                    <v-list>
                                        <v-list-item title="View" @click="viewAcceptedCashAdvance(data)" />
                                    </v-list>
                                </VMenu>
                            </td>
                        </tr>
                    </tbody>
                    <!-- 👉 table footer  -->
                    <tfoot v-show="!paginatedDataApproved.length">
                        <tr>
                            <td colspan="7" class="text-center">
                                No data available
                            </td>
                        </tr>
                    </tfoot>

                </VTable>
                <VPagination :length="totalPagesApproved" v-model="paginationApprovedPage"
                    @update:model-value="updatePageApproved" />
            </v-window-item>

            <v-window-item value="rejected">
                <v-card-text class="d-flex flex-wrap py-4 gap-4">
                    <div class="me-3" style="width: 80px;">
                        <VSelect v-model="selected" :items="perPagesDeclined" :item-value="itemsPerDeclined"
                            :item-title="selectedPerPageDeclined" @update:modelValue="onChangeSelectedPerPageDeclined" />
                    </div>
                    <VSpacer />
                    <div class="app-user-search-filter d-flex align-center flex-wrap gap-4 justify-end"
                        style="width: 15rem;">
                        <v-text-field v-model="searchQueryDeclined" label="Search" class="search-field" solo
                            append-inner-icon="mdi-magnify">
                        </v-text-field>
                    </div>
                </v-card-text>
                <VTable class="text-no-wrap mt-5 mb-5">
                    <!-- 👉 table head -->
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">
                                #
                            </th>
                            <th class="text-center" scope="col">
                                Requested Date
                            </th>
                            <th class="text-center" scope="col">
                                Amount
                            </th>
                            <th class="text-center" scope="col">
                                Reason
                            </th>
                            <th class="text-center" scope="col">
                                Date Declined
                            </th>
                            <th class="text-center" scope="col">
                                Status
                            </th>
                            <th class="text-center" scope="col">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <!-- 👉 table body -->
                    <tbody>
                        <tr v-for="(data, index) in paginatedDataDeclined" :key="data.id" style="height: 3.75rem;">

                            <td class="text-center">{{ index + 1 }}</td>
                            <td class="text-center">{{ moment(data.requested_date).format('MM/DD/YYYY') }}</td>
                            <td class="text-center">{{ data.amount }}</td>
                            <td class="text-center break-text" >{{ data.reasons }}</td>
                            <td class="text-center">{{ moment(data.date_decline).format('MM/DD/YYYY') }}</td>
                            <td class="text-center">
                                <VChip color="error">
                                    {{ data.request_status }}
                                    <VIcon end size="16" icon="ph:x-circle" />
                                </VChip>
                            </td>
                            <td class="text-center">
                                <VMenu v-for="menu in menusVariant" :key="menu">
                                    <template #activator="{ props }">
                                        <VBtn icon size="small" color="default" v-bind="props" variant="text">
                                            <VIcon icon="tabler:dots-vertical"></VIcon>
                                        </VBtn>
                                    </template>
                                    <v-list class="text-center">
                                        <v-list-item title="View" @click="viewDeclineddCashAdvance(data)" />
                                    </v-list>
                                </VMenu>
                            </td>
                        </tr>
                    </tbody>
                    <!-- 👉 table footer  -->
                    <tfoot v-show="!paginatedDataDeclined.length">
                        <tr>
                            <td colspan="7" class="text-center">
                                No data available
                            </td>
                        </tr>
                    </tfoot>
                </VTable>
                <VPagination :length="totalPagesDeclined" :v-menu="paginationDeclinedPage"
                    @update:model-value="updatePageDeclined" />
            </v-window-item>
        </v-window>

        <!-- Dialog For Declining Cash Advance Request -->
        <VDialog v-model="declineCashRequest" max-width="600" persistent>
            <DeclineRequest @handle-form-cancel="handleFormCancel" @closeDialog="declineCashRequest = false"
                :declinedData="declinedData" :requestDeclined="requestDeclined" />
        </VDialog>

        <!-- Dialog For Editing Cash Advance Request Data -->
        <VDialog v-model="editCashRequest" max-width="600" persistent>
            <EditDataVue @form-submitted="handleFormSubmit" @closeDialog="editCashRequest = false" :editData="editData"
                :updateRequest="updateRequest" :formatDate="formatDate" />
        </VDialog>

        <!-- Dialog For Viewing Approved Cash Advance Request Data -->
        <VDialog v-model="viewAcceptedRequest" max-width="600" persistent>
            <ViewAccepted @closeDialog="viewAcceptedRequest = false" :approvedData="approvedData" />
        </VDialog>

        <!-- Dialog For Viewing Declined Cash Advance Request Data -->
        <VDialog v-model="viewDeclinedRequest" max-width="600" persistent>
            <ViewDeclined @closeDialog="viewDeclinedRequest = false" :declinedData="declinedData" />
        </VDialog>
    </section>
</template>


<style>

.break-text {
  overflow-wrap: break-word;
  word-wrap: break-word;
  hyphens: auto;
}

</style>
