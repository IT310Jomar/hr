<script setup lang="ts">
    import Teamattendance from '@/pages/Manage/Teamattendance.vue';
    import { formatDate } from '@/helper';
    import axios from 'axios';
    import { ref, onMounted } from 'vue';
    import { debounce } from 'lodash'
    import ManageScheduleDialog from './ManageScheduleDialog.vue';
    import { useRouter } from 'vue-router'
    const token = JSON.parse(localStorage.getItem('accessToken') || 'null');
    const userDatas = ref()
    const employeeData = ref('')
    const isViewScheduleVisible = ref(false)
    const team = ref(['']);
    const searchQuery = ref('');
    const rowPerPage = ref(5);
    const currentPage = ref(1);
    const totalPage = ref(5);
    const loading = ref();
    const perPages = [5, 10, 20, 50, 100, 500]
    const itemsPerPage = ref(perPages[0])
    const selectedPerPage = ref(itemsPerPage.value)
    const selected = ref('5')


    const router = useRouter()

    const closedFormEditDialog = () => {
      isViewScheduleVisible.value = false
    }

    const ViewSchedule = () => {
      axios.get('/api/user/manage/manage-team/get-schedule', {params : {token:token} })
      .then(response => {
        if(response.data.success) {
          if(response.data.getSchedule && response.data.getSchedule.length > 0) {
            userDatas.value = response.data.getSchedule
            isViewScheduleVisible.value = true
          }
        } else {
            userDatas.value = response.data.getSchedule
            isViewScheduleVisible.value = true
          }
      })
    }


  const getAllEmployee = () => {
    axios.get('/api/user/manage/manage-team/get-all', {params : { token : token }})
    .then (response => {
      if(response.data.success) {
        if(response.data.getAll) {
          employeeData.value = response.data.getAll
        }
      }
    }) 
  }

  // 👉 Computing pagination data
  const paginationData = computed(() => {
    const firstIndex = employeeData.value.length ? ((currentPage.value - 1) * itemsPerPage.value) + 1 : 0
    const lastIndex = itemsPerPage.value + ((currentPage.value - 1) * itemsPerPage.value)

    return `Showing ${firstIndex} to ${lastIndex} of ${employeeData.value.length} entries`
  })

  const paginatedData = computed(() => {
    const startIndex = (currentPage.value - 1) * itemsPerPage.value
    const endIndex = startIndex + itemsPerPage.value
    return employeeData.value.slice(startIndex, endIndex)
  })

  let totalPages = computed(() => {
    if (employeeData.value.length > 0) {
      return Math.ceil(employeeData.value.length / itemsPerPage.value)
    } else {
      return 0
    }
  })

  const redirectToPage = () => {
    router.push('/Manage/TeamCalendar/teamCalendar')
  }
    
  //function for changing the number of pages
  function itemPerPage(selectedPerPageValue: number) {
      const index = perPages.indexOf(selectedPerPageValue);

      if (index !== -1) {
          itemsPerPage.value = perPages[index];
          currentPage.value = 1;
      } else {
          console.log('Error: Invalid selectedPerPageValue');
      }
  }//end of function

  // for changing the item per page
  function onChangeSelectedPerPage(selectedValue: number) {
    itemPerPage(selectedValue);
  }

    const search = () => {
        loading.value = true;
        axios.get('/api/user/manage/manage-team/get-search', {
                params: {
                    query: searchQuery.value,
                    token : token
                }
            })
            .then(response => {
              if(response.data.success) {
                if(response.data.manage_team) {
                  employeeData.value = response.data.manage_team;
                  console.log(employeeData.value, "Searched")
                }
              }
            })
            .catch(error => {
                console.log(error);
            }).finally(() => {
                loading.value = false;
            })
    };

    watch(searchQuery, debounce(() => {
        if (searchQuery.value === '') {
          getAllEmployee()
        } else {
          search()
        }
    }, 500));


    watchEffect(() => {
      if (currentPage.value > totalPage.value) {
         currentPage.value = totalPage.value
      }
    })
    // const paginationData = computed(() => {
    //     const firstIndex = team.value.length ? ((currentPage.value - 1) * rowPerPage.value) + 1 : 0
    //     const lastIndex = team.value.length + ((currentPage.value - 1) * rowPerPage.value)

    //     return `Showing ${firstIndex} to ${lastIndex} of ${totalUsers.value} entries`
    // })

    onMounted(() => {
      getAllEmployee()
    });

    const allEmployee = computed(() => {
        if (!employeeData.value || !Array.isArray(employeeData.value)) {
          return []
        }
        
        const startIndex = (currentPage.value - 1) * itemsPerPage.value
        const endIndex = startIndex + itemsPerPage.value

        if (endIndex > employeeData.value.length) {
          return employeeData.value.slice(startIndex)
        }
        
        return employeeData.value.slice(startIndex, endIndex)
    })

</script>
<template>
    <section>
        <VRow>
            <VCol cols="12">
                <VCard>
                    <v-col>
                        <VCard title="Manage Team" size="small">
                            <div class="d-flex justify-end mr-4 mb-6 gap-3" style="margin-top: -5%;">
                                <VBtn size="small" prepend-icon='tabler-calendar' link to="/sidebarLayout/Manage/TeamCalendar/teamCalendar">
                                    Team Calendar
                                </VBtn>
                                <VBtn size="small" prepend-icon='tabler-folder' link to="/Manage/Teamattendance">
                                    Team Attendance
                                </VBtn>
                                <VBtn size="small" prepend-icon="fa-edit"
                                  @click.prevent="ViewSchedule()"
                                >
                                    Manage Schedule
                                    
                                </VBtn>
                            </div>
                        </VCard>
                    </v-col>

                        <VCardText class="d-flex flex-wrap py-4 gap-4">
                            <div class="me-3" style="width: 80px;">
                              <v-select
                                v-model="selected"
                                :items="perPages" item-value="itemsPerPage" item-title="selectedPerPage" @update:modelValue="onChangeSelectedPerPage">
                              </v-select>
                            </div>
                            <div style="width: 15rem; margin-left: auto;">
                                <VTextField v-model="searchQuery" placeholder="Search" class="form-control"
                                  density="compact" />
                            </div>

                        </VCardText>

                    <VDivider class="mb-5"/>

                    <VTable class="px-5 mb-5">
                        <!-- 👉 table head -->
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">
                                    Employee ID No
                                </th>
                                <th class="text-center" scope="col">
                                    Full Name
                                </th>
                                <th class="text-center" scope="col">
                                    Position
                                </th>
                                <th class="text-center" scope="col">
                                    Default Schedule
                                </th>
                            </tr>
                        </thead>
                        <!-- 👉 table body -->
                        <tbody>
                            <tr v-for="(manage_team) in paginatedData" :key="manage_team" style="height: 3.75rem;"
                                class="text-center">
                                <!-- 👉 User -->
                                <td>{{ manage_team.id }}</td>
                                <td>{{ manage_team.last_name }} {{ manage_team.first_name }} {{ manage_team.middle_name }}</td>
                                <td class="text-center" >{{ manage_team.user.user_levels.name }}</td>
                                <td v-if="manage_team.employments?.schedule_types ?? false">{{ manage_team.employments.schedule_types.name }}</td>
                            </tr>
                        </tbody>
                        <tr v-if="allEmployee?.length == 0">
                          <td class="text-center" colspan="6">
                            <span>
                              No records found at the moment
                            </span>
                          </td>
                        </tr>
                    </VTable>

                    <VCardText class="d-flex align-center flex-wrap justify-space-between gap-4 py-3 px-5">
                      <strong class="text-sm text-disabled">
                        {{ paginationData }}
                      </strong>

                      <VPagination v-model="currentPage" size="small" :total-visible="5" :length="totalPages" />
                    </VCardText>

                </VCard>
            </VCol>
        </VRow>

        <VDialog
          v-model="isViewScheduleVisible"
          max-width="1080"
          scrollable
        >
          <ManageScheduleDialog :userDatas="userDatas" @closeDialog="closedFormEditDialog" />
          <DialogCloseBtn @click="isViewScheduleVisible = !isViewScheduleVisible" />
        </VDialog>   
    </section>
</template>
