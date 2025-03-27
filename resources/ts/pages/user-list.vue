<script setup lang="ts">
import { formatDate } from '@/helper';
import { debounce } from 'lodash';
import axios from 'axios';
import { onMounted, ref } from 'vue';
// import type { UserProperties } from '@/@fake-db/types'
import AddNewUserDrawer from '@/pages/apps/views/list/users/AddNewUserDrawer.vue';
import UpdateUserDrawer from '@/pages/apps/views/list/users/UpdateUserDrawer.vue';
import ViewUserDrawer from '@/pages/apps/views/list/users/ViewUserDrawer.vue';
import DeleteUser from '@/pages/apps/views/list/users/DeleteUser.vue';
// import { useUserListStore } from '@/views/apps/user/useUserListStore'

// 👉 Store
// const userListStore = useUserListStore()
const users = ref(['']);
const rowPerPage = ref(10);
const currentPage = ref(1);
const searchQuery = ref(null);
const userData = ref('')
const itemsPerPage = 5;
const loading = ref(false);


// 👉 Computing pagination data
const paginationData = computed(() => {
  const firstIndex = users.value.length ? ((currentPage.value - 1) * itemsPerPage) + 1 : 0
  const lastIndex = itemsPerPage + ((currentPage.value - 1) * itemsPerPage)

  return `Showing ${firstIndex} to ${lastIndex} of ${users.value.length} entries`
})

  const paginatedData = computed(() => {
        const startIndex = (currentPage.value - 1) * itemsPerPage
        const endIndex = startIndex + itemsPerPage
        return users.value.slice(startIndex, endIndex)
    })

let totalPages = computed(() => {
        if (users.value.length > 0) {
            return Math.ceil(users.value.length / itemsPerPage)
        } else {
            return 0
        }
    })

const getUsers = () => {
  axios.get('/api/user/users')
    .then((response) => {
      users.value = response.data;
  })
}

const handleSubmit = () => {
  getUsers();
};


const updateUser = (id:any) => {
  isUpdateUserDrawerVisible.value = true;
  axios.get(`/api/user/users/view/${id}`)
  .then(response => {
    userData.value =  response.data
    
  }).catch(error => {
    console.log(error);
  })
};

  //  function for getting all data search for request cash advances that are pending
  const searchUser = () => {
      loading.value = true;
      axios.get('/api/user/users/search', {
          params: {
              query: searchQuery.value
          }

      }).then(response => {
          users.value = response.data

      }).catch(error => {
          console.log('Error')
      }).finally(() => {
          loading.value = false; // Set loading to false when the request is complete
      });
  };


  watch(searchQuery, debounce(() => {
        if (searchQuery.value === '') {
            // Reset the data to the original values
          getUsers();
        } else {
            searchUser();
        }
    },500));

// const viewUser = (id:any) => {
//   isViewUserDrawerVisible.value = true;
//   axios.get(`/api/user/users/view/${id}`)
//   .then(response => {
//     userData.value =  response.data
    
//   }).catch(error => {
//     console.log(error);
//   })

// };

const handleUpdate = () => {
  getUsers();
};

const handleDelete = () => {
  getUsers();
};


const isAddNewUserDrawerVisible = ref(false)

const isUpdateUserDrawerVisible = ref(false)

const isViewUserDrawerVisible = ref(false)

// 👉 Fetching users
onMounted(() => {
  getUsers();
});

</script>

<template>
  <section>
    <VRow>
      <VCol cols="12">
        <VCard title="Search Filter">

          <VDivider />

          <VCardText class="d-flex flex-wrap py-4 gap-4">
            <div
              class="me-3"
              style="width: 80px;"
            >
              <VSelect
                v-model="rowPerPage"
                density="compact"
                variant="outlined"
                :items="[10, 20, 30, 50]"
              />
            </div>

            <VSpacer />

            <div class="app-user-search-filter d-flex align-center flex-wrap gap-4 justify-end">

              <!-- 👉 Search  -->
              <div style="width: 15rem;">
                <VTextField
                  v-model="searchQuery"
                  placeholder="Search"
                  density="compact"
                />
              </div> 

              <!-- 👉 Add user button -->
              <VBtn
                prepend-icon="tabler-plus"
                @click="isAddNewUserDrawerVisible = true"
              >
                Add New User
              </VBtn>
            </div>
          </VCardText>

          <VDivider />

          <VTable class="text-no-wrap">
            <!-- 👉 table head -->
            <thead>
              <tr>
                <th scope="col">
                  #
                </th>
                <th scope="col">
                  NAME
                </th>
                <th scope="col">
                  EMAIL ADDRESS
                </th>
                <th scope="col">
                  REGISTERED DATE
                </th>
                <th scope="col">
                  STATUS
                </th>
                <th scope="col">
                  ACTIONS
                </th>
              </tr>
            </thead>
            <!-- 👉 table body -->
            <tbody>
              <tr
                v-for="(user, index) in paginatedData"
                :key="user.id" style="height: 3.75rem;"
              >
                <!-- 👉 id -->
                <td>
                  {{ index + 1 }}
                </td>

                <!-- 👉 name -->
                <td>
                  {{ user . name }}
                </td>

                <!-- 👉 email -->
                <td>
                  {{ user . email }}
                </td>

                <!-- 👉 date -->
                <td>
                  {{ formatDate(user . created_at) }}
                </td>

                <!-- 👉 Status -->
                <td>

                </td>

                <!-- 👉 Actions -->
                <td
                  class="text-center"
                  style="width: 5rem;"
                >
                  <VBtn
                    icon
                    size="x-small"
                    color="default"
                    variant="text"
                    @click.prevent="updateUser(user.id)"
                  >
                    <VIcon
                      size="22"
                      icon="tabler-edit"
                    />
                  </VBtn>

                  <DeleteUser @form-deleted="handleDelete" :user="user"/>

                  <ViewUserDrawer :user="user"/>
                  
                </td>
              </tr>
            </tbody>

            <!-- 👉 table footer  -->
            <tfoot v-show="!users.length">
              <tr>
                <td
                  colspan="7"
                  class="text-center"
                >
                  No data available
                </td>
              </tr>
            </tfoot>
          </VTable>

          <VDivider />

          <VCardText class="d-flex align-center flex-wrap justify-space-between gap-4 py-3 px-5">
            <span class="text-sm text-disabled">
              {{ paginationData }}
            </span>

            <VPagination
              v-model="currentPage"
              size="small"
              :total-visible="5"
              :length="totalPages"
            />
          </VCardText>
        </VCard>
      </VCol>
    </VRow>

    <!-- 👉 Add New User -->
    <AddNewUserDrawer
      v-model:isDrawerOpen="isAddNewUserDrawerVisible"
      @submitted="handleSubmit"
    />

    <UpdateUserDrawer
      v-model:isDrawerOpen="isUpdateUserDrawerVisible"
      @updated="handleUpdate" :user-data="userData"
    />

  </section>

</template>

<style lang="scss">
.app-user-search-filter {
  inline-size: 31.6rem;
}

.text-capitalize {
  text-transform: capitalize;
}

.user-list-name:not(:hover) {
  color: rgba(var(--v-theme-on-background), var(--v-high-emphasis-opacity));
}
</style>

