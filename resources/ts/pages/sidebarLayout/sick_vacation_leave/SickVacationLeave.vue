<script setup lang="ts">
import axios from 'axios';
import { onMounted,ref} from 'vue';
import LeaveTable from '@/pages/request/Leave/LeaveTable.vue';
import LeaveApplicationForm from '@/pages/request/Leave/LeaveApplicationForm.vue';
import { environment } from '@/environments/environment';

const currentPage = ref(1)
const currentPageDeclined = ref(1)
const currentPageApproved = ref(1)
const perPages = [5, 10, 20, 50, 100, 500]
const perPagesApproved = [5, 10, 20, 50, 100, 500]
const perPagesDeclined = [5, 10, 20, 50, 100, 500]
const itemsPerPage = ref(perPages[0])
const itemsPerApproved = ref(perPagesApproved[0])
const itemsPerDeclined = ref(perPagesDeclined[0])
const selectedPerPage = ref(itemsPerPage.value)
const selectedPerPageApproved = ref(itemsPerApproved.value)
const selectedPerPageDeclined = ref(itemsPerDeclined.value)
const requestLeave = ref([''])
const requestLeaveApproved = ref([''])
const requestLeaveDeclined = ref([''])
const sick_leave_count = ref('')
const vacation_leave_count = ref('')
const total_leaves = ref('')
const current_leave = ref('')
const leave_type = ref('')
const user_id = ref()
const employee_id = ref()

const token = JSON.parse(localStorage.getItem('accessToken') || 'null')

//Leave  || Pending Data
const getLeaveRequestPending = () => {
    axios.get(environment.API_URL + 'user/leave/request')
        .then((response) => {
            requestLeave.value = response.data.requestLeave
        }).catch(error => {
            console.log('errror')
        })
}
//Leave Request || Approved Data
const getLeaveRequestApproved = () => {
    axios.get(environment.API_URL + 'user/leave/request/approved')
        .then((response) => {
            requestLeaveApproved.value = response.data.requestLeaveApproved
        }).catch(error => {
            console.log('errror')
        })
}
//Leave Request|| Declined Data
const getLeaveRequestDeclined = () => {
    axios.get(environment.API_URL + 'user/leave/request/declined')
        .then((response) => {
            requestLeaveDeclined.value = response.data.requestLeaveDeclined
        }).catch(error => {
            console.log('errror')
        })
}
const viewLeaveRequestData = ref([])
//  View Data in Edit
const editLeaverequest = (id: any) => {
    axios.get(environment.API_URL + `user/leave/request/view/${id}`)
        .then((response) => {
            viewLeaveRequestData.value = response.data;
            console.log(viewLeaveRequestData.value)
        })
};


//For updatating the default sick leave
const updateSickCount = (newVal: any) =>{
    sick_leave_count.value = newVal
}

//For updating the default vacation leave
const updateVacationCount = (newVal: any) =>{
    vacation_leave_count.value = newVal
}

//For  updating the Available Leave Credits
const updateTotalLeave = (newVal: any) =>{
  total_leaves.value = newVal
}

const handleFormUpdate = () => {
    getLeaveRequestPending();
}

//Getting Leave Data && Leave Counts
const getData = () =>{
    axios.get(environment.API_URL + 'user/leave/request/getdata',{
        params: {
            token: token
        }
    }).then(response =>{
        for(let i = 0; i < response.data.leaveRequest.length; i++){
            user_id.value = response.data.leaveRequest[i].user_id
            employee_id.value = response.data.leaveRequest[i].id
            for(let j = 0; j < response.data.leaveRequest[i].leave_credits.length; j++){
                sick_leave_count.value = response.data.leaveRequest[i].leave_credits[j].sick_leave_credits
                vacation_leave_count.value = response.data.leaveRequest[i].leave_credits[j].vacation_leave_credits
            }
        }
        total_leaves.value = sick_leave_count.value + vacation_leave_count.value
    }).catch(error =>{
        console.log('error')
    })
}


//Search for pending request
const searchrequestPending = (query: any) => {
    axios.get(environment.API_URL + 'user/leave/request/search', {
        params: {
            query: query
        }
    }).then(response => {
        if (response.data.success) {
            requestLeave.value = response.data.requestLeave
        }
    }).catch(error => {
        console.log('Error')
    });
};

//Search for Approved request
const searchrequestApproved = (query: any) => {
    axios.get(environment.API_URL + 'user/leave/request/search/approved', {
        params: {
            query: query
        }
    }).then(response => {
        if (response.data.success) {
            requestLeaveApproved.value = response.data.requestLeaveApproved;
        }
    }).catch(error => {
        console.log('Error')
    });
};

//Search for Declined request
const searchrequestDeclined = (query: any) => {
    axios.get(environment.API_URL + 'user/leave/request/search/declined', {
        params: {
            query: query
        }
    }).then(response => {
        if (response.data.success) {
            requestLeaveDeclined.value = response.data.requestLeaveDeclined;
        }
    }).catch(error => {
        console.log('Error')
    });
};

onMounted(() => {
    getData();
    getLeaveRequestPending();
    getLeaveRequestApproved();
    getLeaveRequestDeclined();
});

//Pending Pagination
const paginatedDataPending = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage.value
    const endIndex = startIndex + itemsPerPage.value
    return requestLeave.value.slice(startIndex, endIndex)
})

//Approved Pagination
const paginatedDataApproved = computed(() => {
    const startIndex = (currentPageApproved.value - 1) * itemsPerApproved.value
    const endIndex = startIndex + itemsPerApproved.value
    return requestLeaveApproved.value.slice(startIndex, endIndex)
})

//Cancelled Pagination
const paginatedDataDeclined = computed(() => {
    const startIndex = (currentPageDeclined.value - 1) * itemsPerDeclined.value
    const endIndex = startIndex + itemsPerDeclined.value
    return requestLeaveDeclined.value.slice(startIndex, endIndex)
})

let totalPages = computed(() => {
    if (requestLeave.value.length > 0) {
        return Math.ceil(requestLeave.value.length / itemsPerPage.value)
    } else {
        return 0
    }
})

let totalPagesApproved = computed(() => {
    if (requestLeaveApproved.value.length > 0) {
        return Math.ceil(requestLeaveApproved.value.length / itemsPerApproved.value)
    } else {
        return 0
    }
})

let totalPagesDeclined = computed(() => {
    if (requestLeaveDeclined.value.length > 0) {
        return Math.ceil(requestLeaveDeclined.value.length / itemsPerDeclined.value)
    } else {
        return 0
    }
})

//function for changing the number of pages in pending
function itemPerPagePending(selectedPerPageValue: number) {
    itemsPerPage.value = selectedPerPageValue;

    if (itemsPerPage.value == 5) {
        const index = 0
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        console.log(index)
    } else if (itemsPerPage.value == 10) {
        const index = 1
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        console.log(index)

    }
    else if (itemsPerPage.value == 20) {
        const index = 2
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        console.log(index)

    }
    else if (itemsPerPage.value == 50) {
        const index = 3
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        console.log(index)

    }
    else if (itemsPerPage.value == 100) {
        const index = 4
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        console.log(index)

    }
    else if (itemsPerPage.value == 500) {
        const index = 5
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        console.log(index)

    }
    else {
        console.log('Error')
    }
};//end of function

//function for changing the number of pages in approved
function itemPerPageApproved(dataApproved: number) {
    itemsPerApproved.value = dataApproved;
    if (itemsPerApproved.value == 5) {
        const index = 0;
        itemsPerApproved.value = perPagesApproved[index];
        currentPageApproved.value = 1;
        console.log(index)
    } else if (itemsPerApproved.value == 10) {
        const index = 1;
        itemsPerApproved.value = perPagesApproved[index];
        currentPageApproved.value = 1;
        console.log(index)

    } else if (itemsPerApproved.value == 20) {
        const index = 2;
        itemsPerApproved.value = perPagesApproved[index];
        currentPageApproved.value = 1;
        console.log(index)

    } else if (itemsPerApproved.value == 50) {
        const index = 3;
        itemsPerApproved.value = perPagesApproved[index];
        currentPageApproved.value = 1;
        console.log(index)

    } else if (itemsPerApproved.value == 100) {
        const index = 4;
        itemsPerApproved.value = perPagesApproved[index];
        currentPageApproved.value = 1;
        console.log(index)

    } else if (itemsPerApproved.value == 500) {
        const index = 5;
        itemsPerApproved.value = perPagesApproved[index];
        currentPageApproved.value = 1;
        console.log(index)

    } else {
        console.log('Error')
    }
};//end of function

//function for changing the number of pages in declined
function itemPerPageDeclined(dataDeclined: number) {
    itemsPerDeclined.value = dataDeclined;
    if (itemsPerDeclined.value == 5) {
        const index = 0;
        itemsPerDeclined.value = perPagesDeclined[index];
        currentPageDeclined.value = 1;
        console.log(index)
    } else if (itemsPerDeclined.value == 10) {
        const index = 1;
        itemsPerDeclined.value = perPagesDeclined[index];
        currentPageDeclined.value = 1;
        console.log(index)

    } else if (itemsPerDeclined.value == 20) {
        const index = 2;
        itemsPerDeclined.value = perPagesDeclined[index];
        currentPageDeclined.value = 1;
        console.log(index)

    } else if (itemsPerDeclined.value == 50) {
        const index = 3;
        itemsPerDeclined.value = perPagesDeclined[index];
        currentPageDeclined.value = 1;
        console.log(index)

    } else if (itemsPerDeclined.value == 100) {
        const index = 4;
        itemsPerDeclined.value = perPagesDeclined[index];
        currentPageDeclined.value = 1;
        console.log(index)

    } else if (itemsPerDeclined.value == 500) {
        const index = 5;
        itemsPerDeclined.value = perPagesDeclined[index];
        currentPageDeclined.value = 1;
        console.log(index)

    } else {
        console.log('Error')
    }
};//end of function
</script>
<template>
    <section>
        <VRow>
            <VCol cols="12" class="d-flex flex-column>">
                <v-card class="pa-5 flex-grow-1">
                    <VCardTitle>My Leaves</VCardTitle>
                   
                    <VTable>
                        <thead>
                            <th>Current Leave</th>
                        </thead>
                        <thead>
                            <th>Leave Type</th>
                            <th>Credit</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Sick : Default Sick leave policy</td>
                                <td>{{sick_leave_count}}</td>
                            </tr>

                            <tr>
                                <td>Vacation : Default Vacation leave policy</td>
                                <td>{{vacation_leave_count}}</td>
                            </tr>
                        </tbody>
                    </VTable>
                </v-card>
            </VCol>

            <VCol cols="12" class="d-flex flex-column">
                <VCard class="pa-5 flex-grow-1">
                    <LeaveTable :getLeaveRequestPending="getLeaveRequestPending"
                        :getLeaveRequestApproved="getLeaveRequestApproved" :paginatedDataApproved="paginatedDataApproved"
                        :paginatedDataDeclined="paginatedDataDeclined" :paginatedDataPending="paginatedDataPending"
                        :editLeaverequest="editLeaverequest" :viewLeaveRequestData="viewLeaveRequestData"
                        :handleFormUpdate="handleFormUpdate" :getLeaveRequestDeclined="getLeaveRequestDeclined"
                        @update-search-query="searchrequestPending" @update-search-query-declined="searchrequestDeclined"
                        @update-search-query-approved="searchrequestApproved"
                        v-bind="{ currentPage, totalPages, currentPageApproved, totalPagesApproved, totalPagesDeclined, currentPageDeclined }"
                        @updateCurrentPage="currentPage = $event" @updateCurrentPageApproved="currentPageApproved = $event"
                        @updateCurrentPageDeclined="currentPageDeclined = $event"
                        @selected-per-page-change="itemPerPagePending" @selected-approved="itemPerPageApproved"
                        @selected-declined="itemPerPageDeclined" :itemsPerPage="itemsPerPage"
                        :itemsPerApproved="itemsPerApproved" :itemsPerDeclined="itemsPerDeclined" :totalPages="totalPages"
                        :totalPagesApproved="totalPagesApproved" :totalPagesDeclined="totalPagesDeclined"
                        :perPages="perPages" :perPagesApproved="perPagesApproved" :perPagesDeclined="perPagesDeclined"
                        :selectedPerPage="selectedPerPage" :selectedPerPageApproved="selectedPerPageApproved"
                        :selectedPerPageDeclined="selectedPerPageDeclined"
                        @sick-leave-count="updateSickCount" @vacation-leave-count="updateVacationCount" @total-leaves="updateTotalLeave"
                        />
                </VCard>
            </VCol>

            <VCol cols="12" class="d-flex flex-column>">
                <v-card class="pa-5 flex-grow-1">
                    <LeaveApplicationForm :leave_type="leave_type" :vacation_leave_count="vacation_leave_count" :sick_leave_count="sick_leave_count" @form-submitted="getLeaveRequestPending" 
                    :total_leaves="total_leaves" :current_leave="current_leave" :user_id="user_id" :employee_id="employee_id"/>
                </v-card>
            </VCol>
        </VRow>
    </section>
</template>
