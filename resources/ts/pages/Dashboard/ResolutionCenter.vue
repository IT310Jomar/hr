<script setup lang="ts">
import axios from 'axios';
import {
  ref,
  onMounted,
  reactive,
  watch
} from 'vue';

const users = ref([]);

const userRole = JSON.parse(localStorage.getItem('userRole') || 'null')

    // const getUsers = () => {
    //     axios.get('/api/user/users')
    //         .then((response) => {
    //             users.value = response.data;
    //         })
    // }

    // onMounted(() => {
    //     getUsers();
    // });
</script>

<template>
  <VCol v-if="userRole == 'God Mode' || userRole == 'Administrator' || userRole == 'Supervisor / Manager'">
  <VCard title="Resolution Center" max-width="400p" class="mb-4 mt-4" >
    <VDivider class="mb-5" />
    <div>
      <VTable class="px-5 mb-5">
        <!-- <thead>
                      <tr>
                          <th style="font-size: medium; text-align: center;" scope="col">
                            #
                          </th>
                          <th style="font-size: medium; text-align: center;" scope="col">
                            Name
                          </th>
                          <th style="font-size: medium; text-align: center;" scope="col">
                            Date Attendance
                          </th>
                        </tr>
                      </thead> -->
          <!-- <tbody>
                              <tr v-for="(user, index) in users" :key="user.id" style="height: 3.75rem;" class="text-center">
                                  <td>
                                      {{ index + 1 }}
                                  </td>
                                  <td>
                                      {{ user . name }}
                                  </td>
                                  <td>
                                      {{ user . email }}
                                  </td>
                              </tr>
                          </tbody> -->
          <!-- 👉 table footer  -->
          <tfoot v-show="!users.length">
            <tr>
              <td colspan="7" class="text-center" style="padding-top: 8%; padding-bottom: 8%; font-size: larger;">
                Yay, no attendance discrepancies this month!
              </td>
            </tr>
          </tfoot>
        </VTable>
      </div>
    </VCard>
  </VCol>
</template>
