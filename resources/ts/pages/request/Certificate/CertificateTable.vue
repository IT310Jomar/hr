<script lang="ts" setup>
import axios from 'axios';
import moment from 'moment';
import { ref } from 'vue';
import { debounce } from 'lodash';
import DeclineAttendance from './DeclineAttendance.vue';
import ViewAttendanceAccepted from './ViewAttendanceAccepted.vue';
import ViewAttendanceDeclinedVue from './ViewAttendanceDeclined.vue';
import EditAttendanceData from './EditAttendanceData.vue';
import { environment } from '@/environments/environment';
import { toast } from 'vue3-toastify';

const props = defineProps(['paginatedDataPending', 'paginatedDataApproved', 'paginatedDataDeclined', 'editLeaverequest', 'viewLeaveRequestData',
    'handleFormUpdate', 'getAttendanceApproved', 'getAttendancePending', 'getAttendanceDeclined', 'totalPages', 'totalPagesApproved', 'totalPagesDeclined',
    'currentPage', 'currentPageApproved', 'currentPageDeclined', 'itemsPerPage', 'itemsPerApproved', 'itemsPerDeclined', 'perPages',
    'perPagesApproved', 'perPagesDeclined', 'selectedPerPage', 'selectedPerPageApproved', 'selectedPerPageDeclined'])
const emit = defineEmits(['update-search-query', 'update-search-query-approved', 'update-search-query-declined',
    'updateCurrentPage', 'updateCurrentPageApproved', 'updateCurrentPageDeclined',
    'selected-per-page-change', 'selected-approved', 'selected-declined', 'sick-leave-count', 'vacation-leave-count', 'total-leaves'])
const searchQuery = ref('')
const searchQueryApproved = ref('')
const searchQueryDeclined = ref('')
const selected = ref(props.itemsPerPage)
const paginationPendingPage = ref(props.currentPage)
const paginationApprovedPage = ref(props.currentPageApproved)
const paginationDeclinedPage = ref(props.currentPageDeclined)
const approvedData = ref()
const declineData = ref()
const editData = ref()
const acceptAttendanceRequest = ref(false)
const declineAttendanceRequest = ref(false)
const editAttendanceDialog = ref(false)
const viewAcceptedRequest = ref(false)
const viewDeclinedRequest = ref(false)
const canceledSuccess = ref(false)
const updateSuccess = ref(false)
const menusVariant = ['primary']
const navigationTab = ref('ITEM ONE')
const tabItems = [
    'Pending/Resubmitted For Editing',
    'Approved',
    'Reject/Canceled'
]


const handleFormUpdate = () => {
    updateSuccess.value = true
}

const handleFormCancel = () => {
    canceledSuccess.value = true
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

const declineAttendance = (data: any) => {
    declineData.value = data
    declineAttendanceRequest.value = true
}

const editAttendance = (data: any) => {
    editData.value = data
    editAttendanceDialog.value = true
}

const viewAcceptedAttendanceRequest = (approved: any) => {
    approvedData.value = approved
    viewAcceptedRequest.value = true
}

const viewDeclinedAttendanceRequest = (declined: any) => {
    declineData.value = declined
    viewDeclinedRequest.value = true
}



const declinedReqeuest = (id: any) => {
    axios.put(environment.API_URL + `user/attendance/request/declinedreq/${id}`)
        .then(response => {
            toast("Canceled Successfully.", {
                autoClose: 4000,
                type: 'success',
                theme: 'colored',
                style: {
                    width: '350px' // Set the width to 400 pixels
                }
            })
            declineData.value = response.data
            props.getAttendancePending()
            props.getAttendanceDeclined()
        }).catch(error => {
            toast("Cancel Error!", {
                autoClose: 4000,
                type: 'error',
                theme: 'colored',
                style: {
                    width: '350px' // Set the width to 400 pixels
                }
            })
        })
}

const onUpdate = (viewAttendanceRequestData: any, id: any) => {
    axios.put(`/api/user/attendance/request/update/${id}`, {
        id: viewAttendanceRequestData.id,
        timeIn: viewAttendanceRequestData.timeIn,
        type: viewAttendanceRequestData.type,
        remarks: viewAttendanceRequestData.remarks
    }).then(response => {
        toast("Successfully Updated.", {
            autoClose: 4000,
            type: 'success',
            theme: 'colored',
            style: {
                width: '350px' // Set the width to 400 pixels
            }
        })
    }).catch(error => {
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

</script>

<template>
    <section>
        <VTabs v-model="navigationTab">
            <VTab v-for="item in tabItems" :key="item" :value="item">
                {{ item }}
            </VTab>
        </VTabs>

        <!-- content -->
        <VWindow v-model="navigationTab">
            <VWindowItem :value="'Pending/Resubmitted For Editing'">
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
                <VTable>
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">
                                #
                            </th>
                            <th class="text-center" scope="col">
                                Requested Date
                            </th>
                            <th class="text-center" scope="col">
                                Attendance Log
                            </th>
                            <th class="text-center" scope="col">
                                State
                            </th>
                            <th class="text-center" scope="col">
                                Type
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
                            <td class="text-center">{{ moment(data.created_at).format('MM/DD/YYYY') }}</td>
                            <td class="text-center">
                                <template v-if="data.state === 'Check In'">
                                    {{ moment(data.login).format('MM/DD/YYYY') + ' - ' + moment(data.timeIn,
                                        'hh:mm:A').format('hh:mm:A') }}
                                </template>
                                <template v-else-if="data.state === 'Check Out'">
                                    {{ moment(data.logout).format('MM/DD/YYYY') + ' - ' + moment(data.timeOut,
                                        'hh:mm:A').format('hh:mm:A') }}
                                </template>
                            </td>
                            <td class="text-center">{{ data.state }}</td>
                            <td class="text-center">{{ data.type }}</td>
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
                                        <v-list-item title="Cancel" @click="declineAttendance(data)" />
                                        <v-list-item title="Edit" @click="editAttendance(data)" />
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
            </VWindowItem>
            <VWindowItem :value="'Approved'">
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
                <VTable>
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">
                                #
                            </th>
                            <th class="text-center" scope="col">
                                Requested Date
                            </th>
                            <th class="text-center" scope="col">
                                Attendance Log
                            </th>
                            <th class="text-center" scope="col">
                                State
                            </th>
                            <th class="text-center" scope="col">
                                Type
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
                            <td class="text-center">{{ moment(data.created_at).format('MM/DD/YYYY') }}</td>
                            <td class="text-center">{{ moment(data.login).format('MM/DD/YYYY') + ' - ' + moment(data.timeIn,
                                'hh:mm:A').format('hh:mm:A') }}</td>
                            <td class="text-center">{{ data.state }}</td>
                            <td class="text-center">{{ data.type }}</td>
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
                                        <v-list-item title="View" @click="viewAcceptedAttendanceRequest(data)" />
                                    </VList>
                                </VMenu>
                            </td>
                        </tr>
                    </tbody>
                    <!-- 👉 table footer  -->
                    <tfoot v-show="!paginatedDataApproved.length" class="py-100">
                        <tr>
                            <td colspan="10" class="text-center">
                                No data available
                            </td>
                        </tr>
                    </tfoot>
                </VTable>
            </VWindowItem>
            <VWindowItem :value="'Reject/Canceled'">
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
                <VTable>
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">
                                #
                            </th>
                            <th class="text-center" scope="col">
                                Requested Date
                            </th>
                            <th class="text-center" scope="col">
                                Attendance Log
                            </th>
                            <th class="text-center" scope="col">
                                State
                            </th>
                            <th class="text-center" scope="col">
                                Type
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
                            <td class="text-center">{{ moment(data.created_at).format('MM/DD/YYYY') }}</td>
                            <td class="text-center">{{ moment(data.login).format('MM/DD/YYYY') + ' - ' + moment(data.timeIn,
                                'hh:mm:A').format('hh:mm:A') }}</td>
                            <td class="text-center">{{ data.state }}</td>
                            <td class="text-center">{{ data.type }}</td>
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
                                        <v-list-item title="View" @click="viewDeclinedAttendanceRequest(data)" />
                                    </VList>
                                </VMenu>
                            </td>
                        </tr>
                    </tbody>
                    <!-- 👉 table footer  -->
                    <tfoot v-show="!paginatedDataDeclined.length" class="py-100">
                        <tr>
                            <td colspan="10" class="text-center">
                                No data available
                            </td>
                        </tr>
                    </tfoot>
                </VTable>
            </VWindowItem>
        </VWindow>
        <!-- Dialog For Declining Leave Request -->
        <VDialog v-model="declineAttendanceRequest" max-width="600" persistent>
            <DeclineAttendance @closeDialog="declineAttendanceRequest = false" :declineData="declineData"
                :declinedReqeuest="declinedReqeuest" @handle-form-cancel="handleFormCancel" />
        </VDialog>

        <!-- Dialog For Edit/Update Leave Request -->
        <VDialog v-model="editAttendanceDialog" max-width="600" persistent>
            <EditAttendanceData @closeDialog="editAttendanceDialog = false" :editData="editData" :onUpdate="onUpdate"
                @form-updated="handleFormUpdate" />
        </VDialog>

        <!-- Dialog For View Accepted Attendance Request -->
        <VDialog v-model="viewAcceptedRequest" max-width="600" persistent>
            <ViewAttendanceAccepted @closeDialog="viewAcceptedRequest = false" :approvedData="approvedData" />
        </VDialog>

        <!-- Dialog For View Declined Attendance Request -->
        <VDialog v-model="viewDeclinedRequest" max-width="600" persistent>
            <ViewAttendanceDeclinedVue @closeDialog="viewDeclinedRequest = false" :declineData="declineData" />
        </VDialog>
    </section>
</template>
