<script setup lang="ts">
import AddMemo from '@/pages/admin/tool/Memo/memo-dialog/add-memo.vue'
import UpdateMemo from '@/pages/admin/tool/Memo/memo-dialog/update-memo.vue'
import DeleteMemo from '@/pages/admin/tool/Memo/memo-dialog/delete-memo.vue'
import AppDateTimePicker from '@core/components/AppDateTimePicker.vue'
import axios from 'axios'
import { onMounted, ref } from 'vue';
import { debounce } from 'lodash'
import { formatDate } from '@/helper';
import { environment } from '@/environments/environment'

const memoData = ref([''])
const loading = ref(false);
const searchQuery = ref(null);
const perPages = [5, 10, 20, 50, 100, 500, "All"];
const itemsPerPage = ref(perPages[0]);
const selectedPerPage = ref(itemsPerPage.value);
const rowPerPage = ref('5');
const currentPage = ref(1);
const startDate = ref();
const endDate = ref();
const dateRange = ref(null);

const getData = () => {
  axios.get(environment.API_URL +'user/memo/view')
    .then(response => {
      if (response.data.success) {
        memoData.value = response.data.memo_view
      }
    }).catch(error => {
      console.log(error);
    })
};
const handleSubmit = () => {
  getData();
};
//search memo
const searchmemo = () => {
      loading.value = true;
      axios.get(environment.API_URL +'user/memo/search', {
          params: {
            query: searchQuery.value
          }
      }).then(response => {
        memoData.value = response.data
      }).catch(error => {
          console.log('Error')
      }).finally(() => {
          loading.value = false; // Set loading to false when the request is complete
      });
  };
watch(searchQuery, debounce(() => {
      if (searchQuery.value === '') {
          // Reset the data to the original values
        getData();
      } else {
      searchmemo();
      }
},500));

// for pagination function
const paginatedData = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage.value
  const endIndex = startIndex + itemsPerPage.value
  return memoData.value.slice(startIndex, endIndex)
})

//function for changing the number of pages
function itemPerPage(selectedPerPageValue: number | string) {
    if (selectedPerPageValue === "All") {
        itemsPerPage.value = Number.MAX_SAFE_INTEGER; // set to a large number
        currentPage.value = 1;
    } else {
        const index = perPages.indexOf(selectedPerPageValue);

        if (index !== -1) {
            itemsPerPage.value = perPages[index];
            currentPage.value = 1;
        } else {
            console.log('Error: Invalid selectedPerPageValue');
        }
    }
}

function onChangeSelectedPerPage(selectedValue: number | string) {
  itemPerPage(selectedValue);
}

//Function for searching daterange
const searchRange = () => {
  if (dateRange.value != null) {
    const d: string[] = []
    d.push(dateRange.value)
    const range = d[0].split(' to ')
    axios.get('/api/user/memo/searchRange', {
      params: {
        startDate: startDate.value = range[0],
        endDate: endDate.value = range[1],
      }
    })
      .then((response) => {
        if (response.data.success) {
          dateRange.value = null
          memoData.value = response.data.memoData
        }
      })
  }
}


const printTable = () => {
  window.print();
}

onMounted(() => {
  getData();
});
</script>

<template>
  <VContainer>
    <VCard>
      <VCardTitle class="py-5">
        Memo Search
        <VRow>
          <VCol class="d-flex justify-end mr-6 mb-5 " style="margin-top: -2%;">
            <AddMemo @submitted="handleSubmit"/>
          </VCol>
        </VRow>
        <VDivider />
      </VCardTitle>
      <VCardText class="mb-3">
        <VRow>
          <VCol cols="6" offset="2">
            <div style="display:flex; align-items:center; float: inline-end;">
              <AppDateTimePicker label="Date Range" v-model="dateRange" :config="{ mode: 'range' }" />
              <VIcon icon="tabler-calendar" />
            </div>
          </VCol>
          <v-col cols="4">
            <v-btn color="primary" @click.prevent="searchRange">Search</v-btn>
          </v-col>
        </VRow>
        <hr class="mt-10" />
      </VCardText>
      <VDivider />

      <VCardText class="d-flex flex-wrap py-4 px-4 gap-2">
        <div class="me-3" style="width: 10.5rem; display:flex; align-items:center;">
          <v-label style="font-size: small;" class="mr-1"><strong>Show</strong></v-label>
          <v-select
            v-model="rowPerPage"
            :items="perPages" item-value="itemsPerPage" item-title="selectedPerPage" @update:modelValue="onChangeSelectedPerPage">
          </v-select>
          <v-label style="font-size: small;" class="ml-1"><strong>entries</strong></v-label>
        </div>
        <v-spacer />
        <!-- 👉 Excel -->
        <VBtn @click="">
          Excel
        </VBtn>

        <!-- 👉 PDF -->
        <VBtn @click="">
          PDF
        </VBtn>

        <!-- 👉 Print -->
        <VBtn @click="printTable" color="info">
          Print
        </VBtn>
         <v-spacer />
        <div class="app-user-search-filter d-flex align-center flex-wrap gap-4 justify-end">
          <!-- 👉 Search  -->
          <div style="width: 17rem; display:flex; align-items:center;">
            <VTextField v-model="searchQuery" placeholder="Search" density="compact" append-inner-icon="mdi-magnify"/>
          </div>
        </div>
      </VCardText>
      <VDivider class="mb-5" />
      <VTable class="px-5 mb-5">
        <thead>
          <tr>
            <th>
              From
            </th>
            <th>
              To
            </th>
            <th>
              Subject
            </th>
            <th>
              Memo Date
            </th>
            <th>
              Actions
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(data, index) in paginatedData" :key="data.id" style="height: 3.75rem;">
            <td>{{ data. to_address }}</td>
            <td>{{ data. from_address }}</td>
            <td>{{ data. memo_subject }}</td>
            <td>{{ formatDate (data. memo_date) }}</td>
            <!-- 👉 Actions -->
            <td style="width: 15rem;">
              <div class="d-flex gap-2 text-center">
                <!-- 👉 update assest button -->
                <UpdateMemo :data="data" @updated="handleSubmit"/>
                <!-- 👉 delete assest button -->
                <DeleteMemo @deleted="handleSubmit" :data="data" />
              </div>
            </td>
          </tr>
        </tbody>
        <!-- 👉 table footer  -->
        <tfoot v-show="!paginatedData.length">
          <tr>
            <td colspan="8" class="text-center py-10">
              Nothing to see here
            </td>
          </tr>
        </tfoot>

          
      </VTable>
    </VCard>
  </VContainer>
</template>
