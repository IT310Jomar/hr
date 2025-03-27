<script setup lang="ts">
import axios from 'axios';
import { onMounted, ref } from 'vue';
import UndertimeTable from '@/pages/request/Undertime/UndertimeTable.vue';
import UndertimeRequestForm from '@/pages/request/Undertime/UndertimeRequestForm.vue';
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
const loading = ref(false)
const requestUndertime = ref([''])
const requestUndertimeApproved = ref([''])
const requestUndertimeDeclined = ref([''])
const isEditDataVisible = ref(false)
const viewUndertimeRequestData = ref([])
const user_id = ref()
const employee_id = ref()

const token = JSON.parse(localStorage.getItem('accessToken') || 'null')

//Undertime  || Pending Data
const getUndertimeRequestPending = () => {
    axios.get(environment.API_URL + 'user/undertime/request')
        .then((response) => {
            requestUndertime.value = response.data.requestUndertime
        }).catch(error => {
            console.log('errror')
        })
}
//Undertime  || Approved Data
const getUndertimeRequestApproved = () => {
    axios.get(environment.API_URL + 'user/undertime/request/approved')
        .then((response) => {
            requestUndertimeApproved.value = response.data.requestUndertimeApproved
        }).catch(error => {
            console.log('errror')
        })
}
//Undertime  || Declined Data
const getUndertimeRequestDeclined = () => {
    axios.get(environment.API_URL + 'user/undertime/request/declined')
        .then((response) => {
            requestUndertimeDeclined.value = response.data.requestUndertimeDeclined
        }).catch(error => {
            console.log('errror')
        })
}
// Edit Undertime Request
const editUndertimerequest = (id: any) => {
    isEditDataVisible.value = true
    axios.get(environment.API_URL + `user/undertime/request/view/${id}`)
        .then((response) => {
            viewUndertimeRequestData.value = response.data;
            console.log(viewUndertimeRequestData.value)
        })
};
const handleFormUpdate = () => {
    getUndertimeRequestPending()
}

const getData = () =>{
    axios.get(environment.API_URL + 'user/undertime/request/getdata',{
        params:{
            token: token
        }
    }).then(response =>{
        for(let i = 0; i < response.data.undertimeRequest.length; i++){
            user_id.value = response.data.undertimeRequest[i].user_id
            employee_id.value = response.data.undertimeRequest[i].id
        }
    }).catch(error =>{
        console.log('error')
    })
}

onMounted(() => {
    getData()
    getUndertimeRequestPending()
    getUndertimeRequestApproved()
    getUndertimeRequestDeclined()
});
//Search for pending request
const searchrequestPending = (query: any) => {
    loading.value = true;
    axios.get(environment.API_URL + 'user/undertime/request/search', {
        params: {
            query: query
        }
    }).then(response => {
        if (response.data.success) {
            requestUndertime.value = response.data.requestUndertime;
        }
    }).catch(error => {
        console.log('Error')
    });
};

//Search for Approved request
const searchrequestApproved = (query: any) => {
    loading.value = true;
    axios.get(environment.API_URL + 'user/undertime/request/search/approved', {
        params: {
            query: query
        }
    }).then(response => {
        if (response.data.success) {
            requestUndertimeApproved.value = response.data.requestUndertimeApproved;
        }
    }).catch(error => {
        console.log('Error')
    });
};

//Search for Declined request
const searchrequestDeclined = (query: any) => {
    loading.value = true;
    axios.get(environment.API_URL + 'user/undertime/request/search/declined', {
        params: {
            query: query
        }
    }).then(response => {
        if (response.data.success) {
            requestUndertimeDeclined.value = response.data.requestUndertimeDeclined;
        }
    }).catch(error => {
        console.log('Error')
    });
};


//Pending Pagination
const paginatedDataPending = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage.value
    const endIndex = startIndex + itemsPerPage.value
    return requestUndertime.value.slice(startIndex, endIndex)
})

//Approved Pagination
const paginatedDataApproved = computed(() => {
    const startIndex = (currentPageApproved.value - 1) * itemsPerApproved.value
    const endIndex = startIndex + itemsPerApproved.value
    return requestUndertimeApproved.value.slice(startIndex, endIndex)
})

//Cancelled Pagination
const paginatedDataDeclined = computed(() => {
    const startIndex = (currentPageDeclined.value - 1) * itemsPerDeclined.value
    const endIndex = startIndex + itemsPerDeclined.value
    return requestUndertimeDeclined.value.slice(startIndex, endIndex)
})

let totalPages = computed(() => {
    if (requestUndertime.value.length > 0) {
        return Math.ceil(requestUndertime.value.length / itemsPerPage.value)
    } else {
        return 0
    }
})

let totalPagesApproved = computed(() => {
    if (requestUndertimeApproved.value.length > 0) {
        return Math.ceil(requestUndertimeApproved.value.length / itemsPerApproved.value)
    } else {
        return 0
    }
})

let totalPagesDeclined = computed(() => {
    if (requestUndertimeDeclined.value.length > 0) {
        return Math.ceil(requestUndertimeDeclined.value.length / itemsPerDeclined.value)
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
                    <UndertimeTable :paginated-data-approved="paginatedDataApproved"
                        :paginated-data-pending="paginatedDataPending" :paginated-data-declined="paginatedDataDeclined"
                        :getUndertimeRequestPending="getUndertimeRequestPending"
                        :getUndertimeRequestApproved="getUndertimeRequestApproved"
                        :getUndertimeRequestDeclined="getUndertimeRequestDeclined"
                        :viewUndertimeRequestData="viewUndertimeRequestData" :editUndertimerequest="editUndertimerequest"
                        :handleFormUpdate="handleFormUpdate" 
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
                        />
                </VCard>
            </VCol>

            <VSpacer />

            <VCol class="d-flex flex-column">
                <VCard class="pa-5 flex-grow-1">
                    <UndertimeRequestForm @form-submitted="handleFormUpdate" :user_id="user_id" :employee_id="employee_id"/>
                </VCard>
            </VCol>
        </VRow>
    </section>
</template>
