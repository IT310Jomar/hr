<script setup lang="ts">
import axios from 'axios';
import { debounce } from 'lodash';
import moment from 'moment';
import EditOfficialBusiness from './EditOfficcialBusiness.vue';
import ViewBusinessAccepted from './ViewBusinessAccepted.vue';
import ViewBusinessDeclined from './ViewBusinessDeclined.vue';
import DeclineBusinessRequest from './DeclineBusinessRequest.vue';
import { environment } from '@/environments/environment';
import { toast } from 'vue3-toastify';

const props = defineProps(['paginatedDataPending', 'paginatedDataApproved', 'paginatedDataDeclined', 'editLeaverequest', 'viewLeaveRequestData',
    'handleFormUpdate', 'getBusinessRequestPending', 'getBusinessRequestApproved', 'getBusinessRequestDeclined', 'totalPages', 'totalPagesApproved', 'totalPagesDeclined',
    'currentPage', 'currentPageApproved', 'currentPageDeclined', 'itemsPerPage', 'itemsPerApproved', 'itemsPerDeclined', 'perPages',
    'perPagesApproved', 'perPagesDeclined', 'selectedPerPage', 'selectedPerPageApproved', 'selectedPerPageDeclined'])
const emit = defineEmits(['update-search-query', 'update-search-query-approved', 'update-search-query-declined',
    'updateCurrentPage', 'updateCurrentPageApproved', 'updateCurrentPageDeclined',
    'selected-per-page-change', 'selected-approved', 'selected-declined'])

const currentTab = ref('pending')
const searchQuery = ref('')
const searchQueryApproved = ref('')
const searchQueryDeclined = ref('')
const selected = ref(props.itemsPerPage)
const paginationPendingPage = ref(props.currentPage)
const paginationApprovedPage = ref(props.currentPageApproved)
const paginationDeclinedPage = ref(props.currentPageDeclined)
const approvedBusinessData = ref()
const declinedBusinessData = ref()
const editBusinessData = ref()
const businesRequestDecline = ref(false)
const editBusinessRequestData = ref(false)
const viewAcceptedBusinessData = ref(false)
const viewDeclinedBusinessData = ref(false)
const canceledSuccess = ref(false)
const updateSuccess = ref(false)
const menusVariant = ['primary']

const declineBusiness = (data: any) => {
    declinedBusinessData.value = data
    businesRequestDecline.value = true
}

const editBusiness = (data: any) => {
    editBusinessData.value = data
    editBusinessRequestData.value = true
}

const viewAcceptedBusiness = (Approved: any) => {
    approvedBusinessData.value = Approved
    viewAcceptedBusinessData.value = true
}

const viewDeclinedBusiness = (Declined: any) => {
    declinedBusinessData.value = Declined
    viewDeclinedBusinessData.value = true
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

const BusinessRequestDeclined = (id: any) => {
    axios.put(environment.API_URL + `user/business/request/declined/businessrequest/${id}`)
        .then((response) => {
            toast("Canceled Successfully.", {
                autoClose: 4000,
                type: 'success',
                theme: 'colored',
                style: {
                    width: '350px' // Set the width to 400 pixels
                }
            })
            declinedBusinessData.value = response.data
            props.getBusinessRequestPending()
            props.getBusinessRequestDeclined()
            canceledSuccess.value = true
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
const updateBusinessData = (viewUndertimeRequestData: any, id: any) => {
    axios.put(environment.API_URL + `user/business/request/update/${id}`, {
        id: viewUndertimeRequestData.id,
        date_from: viewUndertimeRequestData.date_from,
        date_to: viewUndertimeRequestData.date_to,
        time_from: viewUndertimeRequestData.time_from,
        time_to: viewUndertimeRequestData.time_to,
        location: viewUndertimeRequestData.location,
        purpose: viewUndertimeRequestData.purpose,
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
</script>
<template>
    <section>
        <v-card-title>Official Business</v-card-title>
        <VDivider />
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
                <VTable>
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">
                                #
                            </th>
                            <th class="text-center" scope="col">
                                Date From
                            </th>
                            <th class="text-center" scope="col">
                                Date To
                            </th>
                            <th class="text-center" scope="col">
                                Time From
                            </th>
                            <th class="text-center" scope="col">
                                Time To
                            </th>
                            <th class="text-center" scope="col">
                                Location
                            </th>
                            <th class="text-center" scope="col">
                                Purpose
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
                        <tr v-for="(data, index) in paginatedDataPending" :key="data.id" style="height: 3.105rem;">
                            <td class="text-center">{{ index + 1 }}</td>
                            <td class="text-center">{{ moment(data.date_from).format('MM/DD/YYYY') }}</td>
                            <td class="text-center">{{ moment(data.date_to).format('MM/DD/YYYY') }}</td>
                            <td class="text-center">{{ moment(data.time_from, 'hh:mm A').format('hh:mm A') }}</td>
                            <td class="text-center">{{ moment(data.time_to, 'hh:mm A').format('hh:mm A') }}</td>
                            <td class="text-center">{{ data.location }}</td>
                            <td class="text-center">{{ data.purpose }}</td>
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
                                        <v-list-item title="Cancel" @click="declineBusiness(data)" />
                                        <v-list-item title="Edit" @click="editBusiness(data)" />
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
                <VTable>
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">
                                #
                            </th>
                            <th class="text-center" scope="col">
                                Date From
                            </th>
                            <th class="text-center" scope="col">
                                Date To
                            </th>
                            <th class="text-center" scope="col">
                                Time From
                            </th>
                            <th class="text-center" scope="col">
                                Time To
                            </th>
                            <th class="text-center" scope="col">
                                Location
                            </th>
                            <th class="text-center" scope="col">
                                Purpose
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
                        <tr v-for="(data, index) in paginatedDataApproved" :key="data.id" style="height: 3.105rem;">
                            <td class="text-center">{{ index + 1 }}</td>
                            <td class="text-center">{{ moment(data.date_from).format('MM/DD/YYYY') }}</td>
                            <td class="text-center">{{ moment(data.date_to).format('MM/DD/YYYY') }}</td>
                            <td class="text-center">{{ moment(data.time_from, 'hh:mm A').format('hh:mm A') }}</td>
                            <td class="text-center">{{ moment(data.time_to, 'hh:mm A').format('hh:mm A') }}</td>
                            <td class="text-center">{{ data.location }}</td>
                            <td class="text-center">{{ data.purpose }}</td>
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
                                        <v-list-item title="View" @click="viewAcceptedBusiness(data)" />
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
                <VTable>
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">
                                #
                            </th>
                            <th class="text-center" scope="col">
                                Date From
                            </th>
                            <th class="text-center" scope="col">
                                Date To
                            </th>
                            <th class="text-center" scope="col">
                                Time From
                            </th>
                            <th class="text-center" scope="col">
                                Time To
                            </th>
                            <th class="text-center" scope="col">
                                Location
                            </th>
                            <th class="text-center" scope="col">
                                Purpose
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
                        <tr v-for="(data, index) in paginatedDataDeclined" :key="data.id" style="height: 3.105rem;">
                            <td class="text-center">{{ index + 1 }}</td>
                            <td class="text-center">{{ moment(data.date_from).format('MM/DD/YYYY') }}</td>
                            <td class="text-center">{{ moment(data.date_to).format('MM/DD/YYYY') }}</td>
                            <td class="text-center">{{ moment(data.time_from, 'hh:mm A').format('hh:mm A') }}</td>
                            <td class="text-center">{{ moment(data.time_to, 'hh:mm A').format('hh:mm A') }}</td>
                            <td class="text-center">{{ data.location }}</td>
                            <td class="text-center">{{ data.purpose }}</td>
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
                                        <v-list-item title="View" @click="viewDeclinedBusiness(data)" />
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
                <VPagination :length="totalPagesDeclined" v-model="paginationDeclinedPage"
                    @update:model-value="updatePageDeclined" />
            </VWindowItem>
        </VWindow>
        <!-- Dialog For Declining Business Request  -->
        <VDialog v-model="businesRequestDecline" max-width="600" persistent>
            <DeclineBusinessRequest @closeDialog="businesRequestDecline = false"
                :declinedBusinessData="declinedBusinessData" :BusinessRequestDeclined="BusinessRequestDeclined" />
        </VDialog>

        <!-- Dialog For Editing/Updating Business Request  -->
        <VDialog v-model="editBusinessRequestData" max-width="600" persistent>
            <EditOfficialBusiness @closeDialog="editBusinessRequestData = false" :updateBusinessData="updateBusinessData"
                :editBusinessData="editBusinessData" />
        </VDialog>

        <!-- Dialog For Viewing Accepted Business Request  -->
        <VDialog v-model="viewAcceptedBusinessData" max-width="600" persistent>
            <ViewBusinessAccepted @closeDialog="viewAcceptedBusinessData = false"
                :approvedBusinessData="approvedBusinessData" />
        </VDialog>
        <!-- Dialog For Viewing Declined Business Request  -->
        <VDialog v-model="viewDeclinedBusinessData" max-width="600" persistent>
            <ViewBusinessDeclined @closeDialog="viewDeclinedBusinessData = false"
                :declinedBusinessData="declinedBusinessData" />
        </VDialog>
    </section>
</template>
