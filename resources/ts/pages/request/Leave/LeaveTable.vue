<script setup lang="ts">
import axios from 'axios';
import { ref } from 'vue';
import { debounce } from 'lodash';
import moment from 'moment';
import EditLeave from './EditLeave.vue';
import DeclineLeave from './DeclineLeave.vue';
import ViewLeaveAccepted from './ViewLeaveAccepted.vue';
import ViewLeaveDeclined from './ViewLeaveDeclined.vue';
import { environment } from '@/environments/environment';
import { toast } from 'vue3-toastify';

const props = defineProps(['paginatedDataPending', 'paginatedDataApproved', 'paginatedDataDeclined', 'editLeaverequest', 'viewLeaveRequestData',
    'handleFormUpdate', 'getLeaveRequestApproved', 'getLeaveRequestPending', 'getLeaveRequestDeclined', 'totalPages', 'totalPagesApproved', 'totalPagesDeclined',
    'currentPage', 'currentPageApproved', 'currentPageDeclined', 'itemsPerPage', 'itemsPerApproved', 'itemsPerDeclined', 'perPages',
    'perPagesApproved', 'perPagesDeclined', 'selectedPerPage', 'selectedPerPageApproved', 'selectedPerPageDeclined'])
const emit = defineEmits(['update-search-query', 'update-search-query-approved', 'update-search-query-declined',
    'updateCurrentPage', 'updateCurrentPageApproved', 'updateCurrentPageDeclined',
    'selected-per-page-change', 'selected-approved', 'selected-declined', 'sick-leave-count', 'vacation-leave-count', 'total-leaves'])

const currentTab = ref('pending')
const searchQuery = ref('')
const searchQueryApproved = ref('')
const searchQueryDeclined = ref('')
const selected = ref(props.itemsPerPage)
const paginationPendingPage = ref(props.currentPage)
const paginationApprovedPage = ref(props.currentPageApproved)
const paginationDeclinedPage = ref(props.currentPageDeclined)
const menusVariant = ['primary']
const approvedData = ref()
const declinedData = ref()
const editData = ref()
const acceptLeaveRequest = ref()
const declineLeavRequest = ref(false)
const editLeaveDialog = ref(false)
const viewAcceptedRequest = ref(false)
const viewDeclinedRequest = ref(false)
const acceptedSucess = ref(false)
const canceledSuccess = ref(false)
const updateSuccess = ref(false)

const handleFormSubmit = () => {
    updateSuccess.value = true
}
const handleFormCancel = () => {
    canceledSuccess.value = true
}
const handleFormAccept = () => {
    acceptedSucess.value = true
}

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

const acceptLeave = (data: any) => {
    approvedData.value = data
    acceptLeaveRequest.value = true
}

const declineLeave = (data: any) => {
    declinedData.value = data
    declineLeavRequest.value = true
}

const editLeaveData = (data: any) => {
    editData.value = data
    editLeaveDialog.value = true
}

const viewAcceptedLeaveRequest = (approved: any) => {
    approvedData.value = approved
    viewAcceptedRequest.value = true
}

const viewDeclinedLeaveRequest = (declined: any) => {
    declinedData.value = declined
    viewDeclinedRequest.value = true
}

//Declining Leave Request
const requestDeclined = (id: any) => {
    axios.put(environment.API_URL + `user/leave/request/declined/leaverequest/${id}`)
        .then((response) => {
            toast("Canceled Successfully.", {
                autoClose: 4000,
                type: 'success',
                theme: 'colored',
                style: {
                    width: '350px' // Set the width to 400 pixels
                }
            })
            declinedData.value = response.data
            props.getLeaveRequestPending()
            props.getLeaveRequestDeclined()
        }).catch((error) => {
            toast("Cancel Error!", {
                autoClose: 4000,
                type: 'error',
                theme: 'colored',
                style: {
                    width: '350px' // Set the width to 400 pixels
                }
            })
        })
};

//Update the data of the request
const updateLeaveData = (viewLeaveRequestData: any, id: any) => {
    axios.put(environment.API_URL + `user/leave/request/update/${id}`, {
        id: viewLeaveRequestData.id,
        leave_type: viewLeaveRequestData.leave_type,
        date_from: viewLeaveRequestData.date_from,
        date_to: viewLeaveRequestData.date_to,
        reason: viewLeaveRequestData.reason
    }).then((response) => {
        toast("Successfully Updated.", {
            autoClose: 4000,
            type: 'success',
            theme: 'colored',
            style: {
                width: '350px' // Set the width to 400 pixels
            }
        })
    })
    .catch((error) => {
        toast("Update Error!", {
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
        <VTabs v-model="currentTab">
            <VTab value="pending"> Pending / Resubmitted For Editing</VTab>
            <VTab value="approved"> Approved</VTab>
            <VTab value="rejected">Rejected / Cancelled</VTab>
        </VTabs>

        <!-- content -->
        <VWindow v-model="currentTab">
            <VWindowItem value="pending">
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
                                Leave Type
                            </th>
                            <th class="text-center" scope="col">
                                Date From
                            </th>
                            <th class="text-center" scope="col">
                                Date To
                            </th>
                            <th class="text-center" scope="col">
                                Reason
                            </th>
                            <!-- <th class="text-center" scope="col">
                                                                        File
                                                                    </th> -->
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
                            <td class="text-center">{{ data.leave_type }}</td>
                            <td class="text-center">{{ moment(data.date_from).format('hh:mm A') }}</td>
                            <td class="text-center">{{ moment(data.date_to).format('hh:mm A') }}</td>
                            <td class="text-center">{{ data.reason }}</td>
                            <!-- <td>
                                                                        <VImg :src="data.file_attachment" />

                                                                    </td> -->
                            <td class="text-center">
                                <VChip color="warning">
                                    {{ data.status_id }}
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
                                    <VList>
                                        <v-list-item title="Cancel" @click="declineLeave(data)" />
                                        <v-list-item title="Edit" @click="editLeaveData(data)" />
                                    </VList>
                                </VMenu>
                            </td>
                        </tr>
                    </tbody>
                    <!-- 👉 table footer  -->
                    <tfoot v-show="!paginatedDataPending.length" class="py-100">
                        <tr>
                            <td colspan="10" class="text-center">
                                No data available
                            </td>
                        </tr>
                    </tfoot>
                </VTable>
                <VPagination :length="totalPages" v-model="paginationPendingPage" @update:model-value="updatePage" />
            </VWindowItem>
            <VWindowItem value="approved">
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
                <!-- 👉 table head -->
                <VTable class="text-no-wrap mt-5 mb-5">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">
                                #
                            </th>
                            <th class="text-center" scope="col">
                                Leave Type
                            </th>
                            <th class="text-center" scope="col">
                                Date From
                            </th>
                            <th class="text-center" scope="col">
                                Date To
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
                        <tr v-for="(data, index) in paginatedDataApproved" :key="data.id" style="height: 3.75rem;">

                            <td class="text-center">{{ index + 1 }}</td>
                            <td class="text-center">{{ data.leave_type }}</td>
                            <td class="text-center">{{ moment(data.date_from).format('hh:mm A') }}</td>
                            <td class="text-center">{{ moment(data.date_to).format('hh:mm A') }}</td>
                            <td class="text-center">{{ data.reason }}</td>
                            <td class="text-center">
                                <VChip color="success">
                                    {{ data.status_id }}
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
                                    <VList>
                                        <v-list-item title="View" @click="viewAcceptedLeaveRequest(data)" />
                                    </VList>
                                </VMenu>
                            </td>
                        </tr>
                    </tbody>
                    <!-- 👉 table footer  -->
                    <tfoot v-show="!paginatedDataApproved.length" class="py-100">
                        <tr>
                            <td colspan="7" class="text-center">
                                No data available
                            </td>
                        </tr>
                    </tfoot>
                </VTable>
                <VPagination :length="totalPagesApproved" v-model="paginationApprovedPage"
                    @update:model-value="updatePageApproved" />
            </VWindowItem>
            <VWindowItem value="rejected">
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
                <!-- 👉 table head -->
                <VTable class="text-no-wrap mt-5 mb-5">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">
                                #
                            </th>
                            <th class="text-center" scope="col">
                                Leave Type
                            </th>
                            <th class="text-center" scope="col">
                                Date From
                            </th>
                            <th class="text-center" scope="col">
                                Date To
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
                        <tr v-for="(data, index) in paginatedDataDeclined" :key="data.id" style="height: 3.75rem;">

                            <td class="text-center">{{ index + 1 }}</td>
                            <td class="text-center">{{ data.leave_type }}</td>
                            <td class="text-center">{{ moment(data.date_from).format('hh:mm A') }}</td>
                            <td class="text-center">{{ moment(data.date_to).format('hh:mm A') }}</td>
                            <td class="text-center">{{ data.reason }}</td>
                            <td class="text-center">
                                <VChip color="error">
                                    {{ data.status_id }}
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
                                    <VList>
                                        <v-list-item title="View" @click="viewDeclinedLeaveRequest(data)" />
                                    </VList>
                                </VMenu>
                            </td>
                        </tr>
                    </tbody>
                    <!-- 👉 table footer  -->
                    <tfoot v-show="!paginatedDataDeclined.length" class="py-100">
                        <tr>
                            <td colspan="7" class="text-center">
                                No data available
                            </td>
                        </tr>
                    </tfoot>
                </VTable>
                <VPagination :length="totalPagesDeclined" v-model="paginationDeclinedPage"
                    @update:model-value="updatePageDeclined" />
            </VWindowItem>
        </VWindow>
        <!-- Dialog For Declining Leave Request -->
        <VDialog v-model="declineLeavRequest" max-width="600" persistent>
            <DeclineLeave @closeDialog="declineLeavRequest = false" :declinedData="declinedData"
                :requestDeclined="requestDeclined" @handle-form-cancel="handleFormCancel" />
        </VDialog>

        <!-- Dialog For Edit/Update Leave Request -->
        <VDialog v-model="editLeaveDialog" max-width="600" persistent>
            <EditLeave @closeDialog="editLeaveDialog = false" :editData="editData" :updateLeaveData="updateLeaveData"
                @formSubmitted="handleFormSubmit" />
        </VDialog>

        <!-- Dialog For View Accepted Leave Request -->
        <VDialog v-model="viewAcceptedRequest" max-width="600" persistent>
            <ViewLeaveAccepted @closeDialog="viewAcceptedRequest = false" :approvedData="approvedData" />
        </VDialog>

        <!-- Dialog For View Declined Leave Request -->
        <VDialog v-model="viewDeclinedRequest" max-width="600" persistent>
            <ViewLeaveDeclined @closeDialog="viewDeclinedRequest = false" :declinedData="declinedData" />
        </VDialog>
    </section>
</template>
