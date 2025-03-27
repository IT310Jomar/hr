<script lang="ts" setup>
import overtimeuser from '@/pages/sidebarLayout/Approval/approval/overtimeuser.vue';
import undertimeuser from '@/pages/sidebarLayout/Approval/approval/undertimeuser.vue';
import cashadvanceuser from '@/pages/sidebarLayout/Approval/approval/cashadvanceuser.vue';
import scheduleuser from '@/pages/sidebarLayout/Approval/approval/scheduleuser.vue';
import officialuser from '@/pages/sidebarLayout/Approval/approval/officialuser.vue';
import leaveuser from '@/pages/sidebarLayout/Approval/approval/leaveuser.vue';
import axios from 'axios';
import { ref, onMounted, watch } from 'vue';
import { environment } from '@/environments/environment';

// 👉 Tabs items
const navigationTab = ref<string | null>(null)
const tabItems = ['Overtime', 'Undertime', 'Cash Advance', 'Schedule Adjustment', 'Official Business', 'Leave',]

const cashAdvancePending = ref(['']);
const requestLeave = ref([''])
const requesOvertimePending = ref([''])
const requestUndertime = ref([''])
const requestScheduleAdjustmentPending = ref([''])
const requestOfficalBusinessPending = ref([''])
const perPages = [5, 10, 20, 50, 100, 500]
const itemsPerPage = ref(perPages[0])
const selectedPerPage = ref(itemsPerPage.value)
const rowPerPage = ref(10);
const currentPage = ref(1);
const loading = ref(false);

// 👉 Computing pagination data of overtime request
const paginatedDataOvertime = computed(() => {
      const startIndex = (currentPage.value - 1) * itemsPerPage.value
      const endIndex = startIndex + itemsPerPage.value
      return requesOvertimePending.value.slice(startIndex, endIndex)
  })

let totalPagesOvertime = computed(() => {
        if (requesOvertimePending.value.length > 0) {
            return Math.ceil(requesOvertimePending.value.length / itemsPerPage.value)
        } else {
            return 0
        }
    })

//overtime end

// 👉 Computing pagination data of undertime request
const paginatedDataUndertime = computed(() => {
      const startIndex = (currentPage.value - 1) * itemsPerPage.value
      const endIndex = startIndex + itemsPerPage.value
      return requestUndertime.value.slice(startIndex, endIndex)
  })  

let totalPagesUndertime = computed(() => {
        if (requestUndertime.value.length > 0) {
            return Math.ceil(requestUndertime.value.length / itemsPerPage.value)
        } else {
            return 0
        }
    })

//undertime end

// 👉 Computing pagination data of ScheduleAdjustment request
const paginatedDataScheduleAdjustment = computed(() => {
      const startIndex = (currentPage.value - 1) * itemsPerPage.value
      const endIndex = startIndex + itemsPerPage.value
      return requestScheduleAdjustmentPending.value.slice(startIndex, endIndex)
  })

let totalPagesScheduleAdjustment = computed(() => {
        if (requestScheduleAdjustmentPending.value.length > 0) {
            return Math.ceil(requestScheduleAdjustmentPending.value.length / itemsPerPage.value)
        } else {
            return 0
        }
    })

//ScheduleAdjustment end

// 👉 Computing pagination data of OfficalBusiness request
const paginatedDataOfficalBusiness = computed(() => {
      const startIndex = (currentPage.value - 1) * itemsPerPage.value
      const endIndex = startIndex + itemsPerPage.value
      return requestOfficalBusinessPending.value.slice(startIndex, endIndex)
  })

let totalPagesOfficalBusiness = computed(() => {
        if (requestOfficalBusinessPending.value.length > 0) {
            return Math.ceil(requestOfficalBusinessPending.value.length / itemsPerPage.value)
        } else {
            return 0
        }
    })

//OfficeBusiness end

// 👉 Computing pagination data of cash advance
const paginatedData = computed(() => {
      const startIndex = (currentPage.value - 1) * itemsPerPage.value
      const endIndex = startIndex + itemsPerPage.value
      return cashAdvancePending.value.slice(startIndex, endIndex)
  })

let totalPages = computed(() => {
        if (cashAdvancePending.value.length > 0) {
            return Math.ceil(cashAdvancePending.value.length / itemsPerPage.value)
        } else {
            return 0
        }
    })

//cash advance end

// 👉 Computing pagination data of Leave
const paginatedDataLeave = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage.value
  const endIndex = startIndex + itemsPerPage.value
  return requestLeave.value.slice(startIndex, endIndex)
})

let totalPagesLeave = computed(() => {
        if (requestLeave.value.length > 0) {
            return Math.ceil(requestLeave.value.length / itemsPerPage.value)
        } else {
            return 0
        }
    })

//Leave end

//function for changing the number of pages in pending in Overtime Request
function itemPerPagePendingOvertime(selectedPerPageValue: number) {
    itemsPerPage.value = selectedPerPageValue;

    if (itemsPerPage.value == 5) {
        const index = 0
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    } else if (itemsPerPage.value == 10) {
        const index = 1
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 20) {
        const index = 2
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 50) {
        const index = 3
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 100) {
        const index = 4
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 500) {
        const index = 5
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else {
        console.log('Error')
    }
};//end of function

//function for changing the number of pages in pending in Undertime Request
function itemPerPagePendingUndertime(selectedPerPageValue: number) {
    itemsPerPage.value = selectedPerPageValue;

    if (itemsPerPage.value == 5) {
        const index = 0
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    } else if (itemsPerPage.value == 10) {
        const index = 1
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 20) {
        const index = 2
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 50) {
        const index = 3
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 100) {
        const index = 4
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 500) {
        const index = 5
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else {
        console.log('Error')
    }
};//end of function

//function for changing the number of pages in pending in ScheduleAdjustment Request
function itemPerPagePendingScheduleAdjustment(selectedPerPageValue: number) {
    itemsPerPage.value = selectedPerPageValue;

    if (itemsPerPage.value == 5) {
        const index = 0
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    } else if (itemsPerPage.value == 10) {
        const index = 1
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 20) {
        const index = 2
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 50) {
        const index = 3
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 100) {
        const index = 4
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 500) {
        const index = 5
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else {
        console.log('Error')
    }
};//end of function

//function for changing the number of pages in pending in Offical Business Request
function itemPerPagePendingOfficalBusiness(selectedPerPageValue: number) {
    itemsPerPage.value = selectedPerPageValue;
    if (itemsPerPage.value == 5) {
        const index = 0
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    } else if (itemsPerPage.value == 10) {
        const index = 1
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 20) {
        const index = 2
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 50) {
        const index = 3
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 100) {
        const index = 4
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 500) {
        const index = 5
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else {
        console.log('Error')
    }
};//end of function
    
//function for changing the number of pages in pending in cash advance Request
function itemPerPagePending(selectedPerPageValue: number) {
    itemsPerPage.value = selectedPerPageValue;

    if (itemsPerPage.value == 5) {
        const index = 0
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    } else if (itemsPerPage.value == 10) {
        const index = 1
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 20) {
        const index = 2
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 50) {
        const index = 3
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 100) {
        const index = 4
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 500) {
        const index = 5
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else {
        console.log('Error')
    }
};//end of function

//function for changing the number of pages in pending in Leave Request
function itemPerPagePendingLeave(selectedPerPageValue: number) {
    itemsPerPage.value = selectedPerPageValue;

    if (itemsPerPage.value == 5) {
        const index = 0
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    } else if (itemsPerPage.value == 10) {
        const index = 1
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 20) {
        const index = 2
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 50) {
        const index = 3
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 100) {
        const index = 4
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else if (itemsPerPage.value == 500) {
        const index = 5
        itemsPerPage.value = perPages[index];
        currentPage.value = 1;
        // console.log(index)
    }
    else {
        console.log('Error')
    }
};//end of function


//Overtime  || Pending Data
const getOvertimeRequestPending = () => {
    axios.get(environment.API_URL +'user/overtime/request')
        .then((response) => {
            requesOvertimePending.value = response.data.requesOvertimePending
        }).catch(error => {
            console.log('errror')
        })
}

//Undertime  || Pending Data
const getUndertimeRequestPending = () => {
    axios.get(environment.API_URL +'user/undertime/request')
        .then((response) => {
            requestUndertime.value = response.data.requestUndertime
        }).catch(error => {
            console.log('errror')
        })
}

//ScheduleAdjustment  || Pending Data
const getScheduleAdjustmentRequestPending = () => {
    axios.get(environment.API_URL +'user/schedule/adjustment')
        .then((response) => {
          requestScheduleAdjustmentPending.value = response.data.requestSchedulePending
        }).catch(error => {
            console.log('errror')
        })
}

//OfficalBusiness  || Pending Data
const getOfficalBusinessRequestPending = () => {
    axios.get(environment.API_URL +'user/business/request')
        .then((response) => {
          requestOfficalBusinessPending.value = response.data.businessRequest
          console.log(requestOfficalBusinessPending.value)
        }).catch(error => {
            console.log('errror')
        })
}

//Cash Advance Data || Pending Data
const getCashAdvance = () => {
    axios.get(environment.API_URL +'user/cash/advance')
      .then((response) => {
        cashAdvancePending.value = response.data.cashAdvancePending
      }).catch(error => {
          console.log('errror')
      })
}

//Leave Data || Sick / Vacation Data
const getLeave = () => {
    axios.get(environment.API_URL +'user/leave/request')
      .then((response) => {
        requestLeave.value = response.data.requestLeave
      }).catch(error => {
          console.log('errror')
      })
}

//  function for getting all data search for request Overtime that are pending
const searchOvertime = (query: any) => {
    loading.value = true;
    axios.get(environment.API_URL +'user/overtime/request/search', {
        params: {
            query: query
        }

    }).then(response => {
      if (response.data.success) {
        requesOvertimePending.value = response.data.requesOvertimePending
      }
    }).catch(error => {
        console.log('Error')
    }).finally(() => {
        loading.value = false; // Set loading to false when the request is complete
    });

};

//  function for getting all data search for request Undertime that are pending
const searchUndertime = (query: any) => {
    loading.value = true;
    axios.get(environment.API_URL +'user/undertime/request/search', {
        params: {
            query: query
        }

    }).then(response => {
      if (response.data.success) {
        requestUndertime.value = response.data.requestUndertime
      }
    }).catch(error => {
        console.log('Error')
    }).finally(() => {
        loading.value = false; // Set loading to false when the request is complete
    });

};

//  function for getting all data search for request ScheduleAdjustment that are pending
const searchScheduleAdjustment = (query: any) => {
    loading.value = true;
    axios.get(environment.API_URL +'user/schedule/adjustment/search', {
        params: {
            query: query
        }

    }).then(response => {
      if (response.data.success) {
        requestScheduleAdjustmentPending.value = response.data.requestSchedulePending
      }
    }).catch(error => {
        console.log('Error')
    }).finally(() => {
        loading.value = false; // Set loading to false when the request is complete
    });

};

//  function for getting all data search for request OfficalBusiness that are pending
const searchOfficalBusiness = (query: any) => {
    loading.value = true;
    axios.get(environment.API_URL +'user/business/request/search', {
        params: {
            query: query
        }

    }).then(response => {
      if (response.data.success) {
        requestOfficalBusinessPending.value = response.data.businessRequest
      }
    }).catch(error => {
        console.log('Error')
    }).finally(() => {
        loading.value = false; // Set loading to false when the request is complete
    });

};

//  function for getting all data search for request cash advances that are pending
const searchCash = (query: any) => {
    loading.value = true;
    axios.get(environment.API_URL +'user/cash/advance/search', {
        params: {
            query: query
        }

    }).then(response => {
      if (response.data.success) {
        cashAdvancePending.value = response.data.cashAdvancePending
      }
    }).catch(error => {
        console.log('Error')
    }).finally(() => {
        loading.value = false; // Set loading to false when the request is complete
    });

};

//  function for getting all data search for request Leave that are pending
const searchLeave = (query: any) => {
    axios.get(environment.API_URL +'user/leave/request/search', {
        params: {
            query: query
        }
    }).then(response => {
        if (response.data.success) {
            requestLeave.value = response.data.requestLeave;
        }
    }).catch(error => {
        console.log('Error')
    });
};



onMounted(() => {
  getOvertimeRequestPending();
  getUndertimeRequestPending();
  getScheduleAdjustmentRequestPending();
  getOfficalBusinessRequestPending();
  getCashAdvance();
  getLeave();
});

</script>

<template>
  <section>
    <VCol>
      <VCard class="mb-4">
        <v-card-text size="large" class="font-weight-bold">
          Team Request Approval
        </v-card-text>
      </VCard>

      <VCard>
        <v-tabs v-model="navigationTab" class="mb-2" grow stacked>
          <v-tab v-for="item in tabItems" :key="item" :value="item">
            <v-responsive>
              <v-icon v-if="item === 'Overtime'">tabler:alarm</v-icon>
            </v-responsive>
            <v-responsive>
              <v-icon v-if="item === 'Undertime'">tabler-hourglass-low</v-icon>
            </v-responsive>
            <v-responsive>
              <v-icon v-if="item === 'Cash Advance'">tabler-cash</v-icon>
            </v-responsive>
            <v-responsive>
              <v-icon v-if="item === 'Schedule Adjustment'">tabler-calendar</v-icon>
            </v-responsive>
            <v-responsive>
              <v-icon v-if="item === 'Official Business'">tabler:briefcase</v-icon>
            </v-responsive>
            <v-responsive>
              <v-icon v-if="item === 'Leave'">tabler-edit</v-icon>
            </v-responsive>
            {{ item }}
          </v-tab>
        </v-tabs>
        <VDivider />
        <v-table>
          <v-window v-model="navigationTab">
            <v-window-item :value="'Overtime'" class="px-5">
              <overtimeuser 
              :getOvertimeRequestPending="getOvertimeRequestPending"
              :paginatedDataOvertime="paginatedDataOvertime"
              :totalPagesOvertime="totalPagesOvertime"
              :itemsPerPage="itemsPerPage"
              :perPages="perPages" 
              :selectedPerPage="selectedPerPage"
              @selected-per-page-change-overtime="itemPerPagePendingOvertime"
              @update-search-query="searchOvertime"
              v-bind="{ currentPage }"
              @updateCurrentPage="currentPage = $event" 
              :requesOvertimePending="requesOvertimePending"
              ></overtimeuser>
            </v-window-item>

            <v-window-item :value="'Undertime'" class="px-5">
              <undertimeuser
              :getUndertimeRequestPending="getUndertimeRequestPending"
              :paginatedDataUndertime="paginatedDataUndertime"
              :totalPagesUndertime="totalPagesUndertime"
              :itemsPerPage="itemsPerPage"
              :perPages="perPages" 
              :selectedPerPage="selectedPerPage"
              @selected-per-page-change-undertime="itemPerPagePendingUndertime"
              @update-search-query="searchUndertime"
              v-bind="{ currentPage }"
              @updateCurrentPage="currentPage = $event" 
              />
            </v-window-item>

            <v-window-item :value="'Cash Advance'" class="px-5">
              <cashadvanceuser
              :getCashAdvance="getCashAdvance"
              :totalPages="totalPages" 
              :paginatedData="paginatedData" v-bind="{ currentPage }"
              @updateCurrentPage="currentPage = $event" 
              @update-search-query="searchCash"
              @selected-per-page-change="itemPerPagePending"
              :itemsPerPage="itemsPerPage"
              :perPages="perPages" 
              :selectedPerPage="selectedPerPage"

              />
            </v-window-item>

            <v-window-item :value="'Schedule Adjustment'" class="px-5">
              <scheduleuser 
              :getScheduleAdjustmentRequestPending="getScheduleAdjustmentRequestPending"
              :paginatedDataScheduleAdjustment="paginatedDataScheduleAdjustment"
              :totalPagesScheduleAdjustment="totalPagesScheduleAdjustment"
              :itemsPerPage="itemsPerPage"
              :perPages="perPages" 
              :selectedPerPage="selectedPerPage"
              @selected-per-page-change-schedule-adjustment="itemPerPagePendingScheduleAdjustment"
              @update-search-query="searchScheduleAdjustment"
              v-bind="{ currentPage }"
              @updateCurrentPage="currentPage = $event" 
              />
            </v-window-item>

            <v-window-item :value="'Official Business'" class="px-5">
              <officialuser
              :getOfficalBusinessRequestPending="getOfficalBusinessRequestPending"
              :paginatedDataOfficalBusiness="paginatedDataOfficalBusiness"
              :totalPagesOfficalBusiness="totalPagesOfficalBusiness"
              :itemsPerPage="itemsPerPage"
              :perPages="perPages" 
              :selectedPerPage="selectedPerPage"
              @selected-per-page-change-offical-business="itemPerPagePendingOfficalBusiness"
              @update-search-query="searchOfficalBusiness"
              v-bind="{ currentPage }"
              @updateCurrentPage="currentPage = $event" 
              />
            </v-window-item>

            <v-window-item :value="'Leave'" class="px-5">
              
              <leaveuser @selected-per-page-change-leave="itemPerPagePendingLeave" 
              :paginatedDataLeave="paginatedDataLeave" :requestLeave="requestLeave" 
              :totalPagesLeave="totalPagesLeave" :getLeave="getLeave" v-bind="{ currentPage }"
              @updateCurrentPage="currentPage = $event" :selectedPerPage="selectedPerPage" 
              :perPages="perPages" :itemsPerPage="itemsPerPage"
              @update-search-query-leave="searchLeave"
              />
            </v-window-item>

          </v-window>
        </v-table>
      </VCard>
    </VCol>
  </section>
</template>
