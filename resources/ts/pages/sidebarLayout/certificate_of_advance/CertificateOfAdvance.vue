<script lang="ts" setup>
import CeCertificateForm from '@/pages/request/Certificate/CertificateForm.vue';
import CertificateTable from '@/pages/request/Certificate/CertificateTable.vue';
import axios from 'axios';
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
const attendanceData = ref()
const empData = ref()
const requestAttendance = ref([''])
const requestAttendanceApproved = ref([''])
const requestAttendanceDeclined = ref([''])
const Certificate = ref({
  Attendance: [],
})

const token = JSON.parse(localStorage.getItem('accessToken') || 'null')

//Attendance || Pending Data
const getAttendancePending = () => {
  axios.get(environment.API_URL + 'user/attendance/request', {
    params: {
      token: token
    }
  }).then(response => {
    requestAttendance.value = response.data.requestAttendance
  }).catch(error => {
    console.log('error')
  })
}

//Atendance || Approved
const getAttendanceApproved = () => {
  axios.get(environment.API_URL + 'user/attendance/request/approved', {
    params: {
      token: token
    }
  }).then(response => {
    requestAttendanceApproved.value = response.data.requestAttendanceApproved
  }).catch(error => {
    console.log('error')
  })
}

//Atendance || Approved
const getAttendanceDeclined = () => {
  axios.get(environment.API_URL + 'user/attendance/request/declined', {
    params: {
      token: token
    }
  }).then(response => {
    requestAttendanceDeclined.value = response.data.requestAttendanceDeclined
  }).catch(error => {
    console.log('error')
  })
}

//Search for pending request
const searchrequestPending = (query: any) => {
  axios.get(environment.API_URL + 'user/attendance/request/search', {
    params: {
      token: token,
      query: query
    }
  }).then(response => {
    if (response.data.success) {
      requestAttendance.value = response.data.requestAttendance;
    }
  }).catch(error => {
    console.log('Error')
  });
};

//Search for Approved request
const searchrequestApproved = (query: any) => {
  axios.get(environment.API_URL + 'user/attendance/request/search/approved', {
    params: {
      token: token,
      query: query
    }
  }).then(response => {
    if (response.data.success) {
      requestAttendanceApproved.value = response.data.requestAttendanceApproved;
    }
  }).catch(error => {
    console.log('Error')
  });
};

//Search for Declined request
const searchrequestDeclined = (query: any) => {
  axios.get(environment.API_URL + 'user/attendance/request/search/declined', {
    params: {
      token: token,
      query: query
    }
  }).then(response => {
    if (response.data.success) {
      requestAttendanceDeclined.value = response.data.requestAttendanceDeclined;
    }
  }).catch(error => {
    console.log('Error')
  });
};

//Pending Pagination
const paginatedDataPending = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage.value
  const endIndex = startIndex + itemsPerPage.value
  return requestAttendance.value.slice(startIndex, endIndex)
})

//Approved Pagination
const paginatedDataApproved = computed(() => {
  const startIndex = (currentPageApproved.value - 1) * itemsPerApproved.value
  const endIndex = startIndex + itemsPerApproved.value
  return requestAttendanceApproved.value.slice(startIndex, endIndex)
})

//Cancelled Pagination
const paginatedDataDeclined = computed(() => {
  const startIndex = (currentPageDeclined.value - 1) * itemsPerDeclined.value
  const endIndex = startIndex + itemsPerDeclined.value
  return requestAttendanceDeclined.value.slice(startIndex, endIndex)
})

let totalPages = computed(() => {
  if (requestAttendance.value.length > 0) {
    return Math.ceil(requestAttendance.value.length / itemsPerPage.value)
  } else {
    return 0
  }
})

let totalPagesApproved = computed(() => {
  if (requestAttendanceApproved.value.length > 0) {
    return Math.ceil(requestAttendanceApproved.value.length / itemsPerApproved.value)
  } else {
    return 0
  }
})

let totalPagesDeclined = computed(() => {
  if (requestAttendanceDeclined.value.length > 0) {
    return Math.ceil(requestAttendanceDeclined.value.length / itemsPerDeclined.value)
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

const viewAttendanceRequestData = ref([])
//  View Data in Edit
const editAttendanceRequest = (id: any) => {
  axios.get(environment.API_URL + `user/attendance/request/view/${id}`, {
    params: {
      token: token
    }
  })
    .then((response) => {
      viewAttendanceRequestData.value = response.data;

    })
};

//get employee id
const getEmpData = () => {
  axios.get(environment.API_URL + 'user/employees/getEmployee', {
    params: {
      token: token
    }
  })
    .then(response => {
      empData.value = response.data
      // console.log(empData.value)
    })
}

const getData = () => {
  axios.get(environment.API_URL + 'user/attendance/getdata', {
    params: {
      token: token
    }
  })
    .then((response) => {
      attendanceData.value = response.data.attendanceData
    }).catch(error => {
      console.log(error);
    })
}

onMounted(() => {
  getData()
  getAttendancePending()
  getAttendanceApproved()
  getAttendanceDeclined()
})
</script>
<template>
  <section>
    <VRow>
      <VCol cols="12" class="d-flex flex-column">
        <VCard class="pa-5 flex-grow-1">
          <CertificateTable :getAttendancePending="getAttendancePending" :getAttendanceApproved="getAttendanceApproved"
            :getAttendanceDeclined="getAttendanceDeclined" :paginatedDataPending="paginatedDataPending"
            :paginatedDataApproved="paginatedDataApproved" :paginatedDataDeclined="paginatedDataDeclined"
            :viewAttendanceRequestData="viewAttendanceRequestData" 
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
            :itemsPerDeclined="itemsPerDeclined" :totalPages="totalPages"
            :totalPagesApproved="totalPagesApproved" 
            :totalPagesDeclined="totalPagesDeclined" 
            :perPages="perPages"
            :perPagesApproved="perPagesApproved" 
            :perPagesDeclined="perPagesDeclined" 
            :selectedPerPage="selectedPerPage"
            :selectedPerPageApproved="selectedPerPageApproved" :selectedPerPageDeclined="selectedPerPageDeclined"
             />
        </VCard>

      </VCol>
      <VCol>
        <VCard class="pa-5 flex-grow-1">
          <CeCertificateForm @form-Submitted="getAttendancePending" :attendanceData="attendanceData"
            :Certificate="Certificate" :empData="empData" />
        </VCard>
      </VCol>
    </VRow>
  </section>
</template>
