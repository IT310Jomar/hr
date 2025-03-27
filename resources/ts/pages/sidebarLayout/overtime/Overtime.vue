<script setup lang="ts">
import axios from 'axios';
import OvertimeTable from '@/pages/request/Overtime/OvertimeTable.vue';
import OvertimeRequestForm from '@/pages/request/Overtime/OvertimeRequestForm.vue';
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
const requesOvertimePending = ref([''])
const requestOvertimeApproved = ref([''])
const requestOvertimeDeclined = ref([''])
const viewOvertimeRequestData = ref([])
const isEditDataVisible = ref(false)
const user_id = ref()
const employee_id = ref()

const token = JSON.parse(localStorage.getItem('accessToken') || 'null')

//Overtime  || Pending Data
const getOvertimeRequestPending = () => {
    axios.get(environment.API_URL + 'user/overtime/request')
        .then((response) => {
            requesOvertimePending.value = response.data.requesOvertimePending
        }).catch(error => {
            console.log('errror')
        })
}
//Overtime Request || Approved Data
const getOvertimeRequestApproved = () => {
    axios.get(environment.API_URL + 'user/overtime/request/approved')
        .then((response) => {
            requestOvertimeApproved.value = response.data.requestOvertimeApproved
        }).catch(error => {
            console.log('errror')
        })
}
//Overtime Request|| Declined Data
const getOvertimeRequestDeclined = () => {
    axios.get(environment.API_URL + 'user/overtime/request/declined')
        .then((response) => {
            requestOvertimeDeclined.value = response.data.requestOvertimeDeclined
        }).catch(error => {
            console.log('errror')
        })
}


//  View Data in Edit
const editOvertimerequest = (id: any) => {
    isEditDataVisible.value = true
    axios.get(environment.API_URL + `user/leave/request/view/${id}`)
        .then((response) => {
            viewOvertimeRequestData.value = response.data;
            console.log(viewOvertimeRequestData.value)
        })
};

const handleFormUpdate = () => {
    getOvertimeRequestPending();
}

const handleFormSubmit = () => {
    getOvertimeRequestPending()
}

const getData = () =>{
    axios.get(environment.API_URL + 'user/overtime/request/getdata',{
        params:{
            token: token
        }
    }).then(response =>{
        for(let i = 0; i < response.data.overtimeRequest.length; i++){
            user_id.value = response.data.overtimeRequest[i].user_id
            employee_id.value = response.data.overtimeRequest[i].id
        }
    }).catch(error =>{
        console.log('error')
    })
}

onMounted(() => {
    getData()
    getOvertimeRequestPending();
    getOvertimeRequestApproved();
    getOvertimeRequestDeclined();
});
//Search for pending request
const searchrequestPending = (query: any) => {
    axios.get(environment.API_URL + 'user/overtime/request/search', {
        params: {
            query: query
        }
    }).then(response => {
        if (response.data.success) {
            requesOvertimePending.value = response.data.requesOvertimePending;
        }
    }).catch(error => {
        console.log('Error')
    });
};

//Search for Approved request
const searchrequestApproved = (query: string) => {
    axios.get(environment.API_URL + 'user/overtime/request/search/approved', {
        params: {
            query: query
        }
    }).then(response => {
        if (response.data.success) {
            requestOvertimeApproved.value = response.data.requestOvertimeApproved;
        }
    }).catch(error => {
        console.log('Error')
    });
};

//Search for Declined request
const searchrequestDeclined = (query: string) => {
    axios.get(environment.API_URL + 'user/overtime/request/search/declined', {
        params: {
            query: query
        }
    }).then(response => {
        if (response.data.success) {
            requestOvertimeDeclined.value = response.data.requestOvertimeDeclined;
        }

    }).catch(error => {
        console.log('Error')
    });
};

//Pending Pagination
const paginatedDataPending = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage.value
    const endIndex = startIndex + itemsPerPage.value
    return requesOvertimePending.value.slice(startIndex, endIndex)
})

//Approved Pagination
const paginatedDataApproved = computed(() => {
    const startIndex = (currentPageApproved.value - 1) * itemsPerApproved.value
    const endIndex = startIndex + itemsPerApproved.value
    return requestOvertimeApproved.value.slice(startIndex, endIndex)
})

//Cancelled Pagination
const paginatedDataDeclined = computed(() => {
    const startIndex = (currentPageDeclined.value - 1) * itemsPerDeclined.value
    const endIndex = startIndex + itemsPerDeclined.value
    return requestOvertimeDeclined.value.slice(startIndex, endIndex)
})

let totalPages = computed(() => {
    if (requesOvertimePending.value.length > 0) {
        return Math.ceil(requesOvertimePending.value.length / itemsPerPage.value)
    } else {
        return 0
    }
})

let totalPagesApproved = computed(() => {
    if (requestOvertimeApproved.value.length > 0) {
        return Math.ceil(requestOvertimeApproved.value.length / itemsPerApproved.value)
    } else {
        return 0
    }
})

let totalPagesDeclined = computed(() => {
    if (requestOvertimeDeclined.value.length > 0) {
        return Math.ceil(requestOvertimeDeclined.value.length / itemsPerDeclined.value)
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
            <VCol cols="12" class="d-flex flex-column">
                <VCard class="pa-5 flex-grow-1">
                    <OvertimeTable :paginatedDataPending="paginatedDataPending"
                        :paginatedDataApproved="paginatedDataApproved" :paginatedDataDeclined="paginatedDataDeclined"
                        :getOvertimeRequestPending="getOvertimeRequestPending"
                        :getOvertimeRequestApproved="getOvertimeRequestApproved"
                        :getOvertimeRequestDeclined="getOvertimeRequestDeclined" :handleFormUpdate="handleFormUpdate"
                        :editOvertimerequest="editOvertimerequest" :viewOvertimeRequestData="viewOvertimeRequestData"
                        @update-search-query="searchrequestPending" 
                        @update-search-query-declined="searchrequestDeclined"
                        @update-search-query-approved="searchrequestApproved"
                        v-bind="{ currentPage, totalPages, currentPageApproved, totalPagesApproved, totalPagesDeclined, currentPageDeclined }"
                        @updateCurrentPage="currentPage = $event" 
                        @updateCurrentPageApproved="currentPageApproved = $event"
                        @updateCurrentPageDeclined="currentPageDeclined = $event"
                        @selected-per-page-change="itemPerPagePending" 
                        @selected-approved="itemPerPageApproved"
                        @selected-declined="itemPerPageDeclined" 
                        :itemsPerPage="itemsPerPage"
                        :itemsPerApproved="itemsPerApproved" 
                        :itemsPerDeclined="itemsPerDeclined" 
                        :totalPages="totalPages"
                        :totalPagesApproved="totalPagesApproved" 
                        :totalPagesDeclined="totalPagesDeclined"
                        :perPages="perPages" 
                        :perPagesApproved="perPagesApproved" 
                        :perPagesDeclined="perPagesDeclined"
                        :selectedPerPage="selectedPerPage" 
                        :selectedPerPageApproved="selectedPerPageApproved"
                        :selectedPerPageDeclined="selectedPerPageDeclined" />
                </VCard>
            </VCol>
            <VCol class="d-flex flex-column">
                <VCard class="pa-5 flex-grow-1">
                    <OvertimeRequestForm @form-submit="handleFormSubmit" :user_id="user_id" :employee_id="employee_id"/>
                </VCard>
            </VCol>
        </VRow>
    </section>
</template>
