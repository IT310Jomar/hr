<script lang="ts" setup>
import axios from 'axios';
import {onMounted,ref} from 'vue';
import Advance from '@/pages/request/Advance/Advance.vue';
import RequestAdvance from '@/pages/request/Advance/RequestAdvance.vue';
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
const cashAdvancePending = ref([''])
const cashAdvanceApproved = ref([''])
const cashAdvanceDeclined = ref([''])
const isEditDataVisible = ref(false)
const user_id = ref()
const employee_id = ref()


const token = JSON.parse(localStorage.getItem('accessToken') || 'null')

//Cash Advance Data || Pending Data
const getCashAdvance = () => {
    axios.get(environment.API_URL + 'user/cash/advance')
        .then((response) => {
            cashAdvancePending.value = response.data.cashAdvancePending
        }).catch(error => {
            console.log('errror')
        })
}
//Approved Data
const getApprovedCashAdvance = () => {
    axios.get(environment.API_URL + 'user/cash/advance/approved')
        .then((response) => {
            cashAdvanceApproved.value = response.data.cashAdvanceApproved
        }).catch(error => {
            console.log('errror')
        })
}
//Cancelled Data
const getCancelledCashAdvance = () => {
    axios.get(environment.API_URL + 'user/cash/advance/declined')
        .then((response) => {
            cashAdvanceDeclined.value = response.data.cashAdvanceDeclined
        }).catch(error => {
            console.log('errror')
        })
}
const viewRequestData = ref([])
// View Data in Edit
const editrequest = (id: any) => {
    isEditDataVisible.value = true
    axios.get(environment.API_URL + `user/cash/advance/view/${id}`)
        .then((response) => {
            viewRequestData.value = response.data;
            console.log(viewRequestData.value)
        })
};
const handleFormUpdate = () => {
    getCashAdvance();
}

const getEmployee = () =>{
    axios.get(environment.API_URL + 'user/cash/advance/getdata',{
        params: {
            token: token
        }
    })
    .then(response =>{
        for(let i = 0; i < response.data.cashAdvance.length; i++){
            employee_id.value = response.data.cashAdvance[i].id
            user_id.value = response.data.cashAdvance[i].user_id
        }
    }).catch(error =>{
        console.log('error')
    })
}

onMounted(() => {
    getEmployee()
    getCashAdvance();
    getApprovedCashAdvance();
    getCancelledCashAdvance();

});

//Search for pending request
const searchrequestPending = (query: any) => {
    axios.get(environment.API_URL + 'user/cash/advance/search', {
        params: {
            query: query
        }

    }).then(response => {
        if (response.data.success) {
            cashAdvancePending.value = response.data.cashAdvancePending;
        }
    }).catch(error => {
        console.log('Error')
    });
};

//Search for Approved request
const searchrequestApproved = (query: string) => {
    axios.get(environment.API_URL + 'user/cash/advance/search/approved', {
        params: {
            query: query
        }

    }).then(response => {
        if (response.data.success) {
            cashAdvanceApproved.value = response.data.cashAdvanceApproved;
        }
    }).catch(error => {
        console.log('Error')
    });
};

//Search for Declined request
const searchrequestDeclined = (query: string) => {
    axios.get(environment.API_URL + 'user/cash/advance/search/declined', {
        params: {
            query: query
        }

    }).then(response => {
        if (response.data.success) {
            cashAdvanceDeclined.value = response.data.cashAdvanceDeclined;
        }
    }).catch(error => {
        console.log('Error')
    });
};


//Pending Pagination
const paginatedDataPending = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage.value
    const endIndex = startIndex + itemsPerPage.value
    return cashAdvancePending.value.slice(startIndex, endIndex)
})

//Approved Pagination
const paginatedDataApproved = computed(() => {
    const startIndex = (currentPageApproved.value - 1) * itemsPerApproved.value
    const endIndex = startIndex + itemsPerApproved.value
    return cashAdvanceApproved.value.slice(startIndex, endIndex)
})

//Cancelled Pagination
const paginatedDataDeclined = computed(() => {
    const startIndex = (currentPageDeclined.value - 1) * itemsPerDeclined.value
    const endIndex = startIndex + itemsPerDeclined.value
    return cashAdvanceDeclined.value.slice(startIndex, endIndex)
})

let totalPages = computed(() => {
    if (cashAdvancePending.value.length > 0) {
        return Math.ceil(cashAdvancePending.value.length / itemsPerPage.value)
    } else {
        return 0
    }
})

let totalPagesApproved = computed(() => {
    if (cashAdvanceApproved.value.length > 0) {
        return Math.ceil(cashAdvanceApproved.value.length / itemsPerApproved.value)
    } else {
        return 0
    }
})

let totalPagesDeclined = computed(() => {
    if (cashAdvanceDeclined.value.length > 0) {
        return Math.ceil(cashAdvanceDeclined.value.length / itemsPerDeclined.value)
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
        <v-col cols="12" class="d-flex flex-column>">
            <v-card class="pa-5 flex-grow-1">
                <Advance :handleFormUpdate="handleFormUpdate" :paginatedDataPending="paginatedDataPending"
                    :paginatedDataApproved="paginatedDataApproved" :paginatedDataDeclined="paginatedDataDeclined"
                    :editrequest="editrequest" :viewRequestData="viewRequestData" :isEditDataVisible="isEditDataVisible"
                    :getCashAdvance="getCashAdvance" :getApprovedCashAdvance="getApprovedCashAdvance"
                    :getCancelledCashAdvance="getCancelledCashAdvance"
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
                    :selectedPerPageDeclined="selectedPerPageDeclined"
                    >
                </Advance>
            </v-card>
        </v-col>
        <RequestAdvance @form-submitted="getCashAdvance" :user_id="user_id" :employee_id="employee_id"/>

    </section>
</template>
