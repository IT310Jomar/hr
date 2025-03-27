<script setup lang="ts">
import AddLeave from '@/pages/admin/maintenance/leavesetting-dialog/add-leave.vue'
import EditLeave from '@/pages/admin/maintenance/leavesetting-dialog/edit-leave.vue'
import DeleteLeave from '@/pages/admin/maintenance/leavesetting-dialog/delete-leave.vue'
import axios from 'axios'
import { onMounted, ref } from 'vue';
import moment from 'moment';
import { useToastr } from '@/toastr';
import { environment } from '@/environments/environment'

const toastr = useToastr();
const leave = ref('')
const items = [1, 2, 3, 15, 50, 75, 100, 500];
const itemsPerPage = 10;
const currentPage = ref(1);
const openLogsDialog = ref(false)
const dataValues = ref();
const employeeuser = ref([{ item: '--Select User--', value: null }])
const editdialog = ref(false);
const deletedialog = ref(false);
const logId = ref();
const logsData = ref();

const getData = () => {
  axios.get(environment.API_URL +'user/maintenance/leavesettings')
    .then(response => {
      if (response.data.success) {
        leave.value = response.data.leavesettings
      }
    }).catch(error => {
      console.log(error);
    })
};

const handlesData = (values: any) => {
  dataValues.value = values;
}

const leaveDelete = (id: any) => {
  axios.delete(environment.API_URL +`user/leavesettings/deleteData/${id}`)
    .then(response => {
      if (response.data.success) {
        if (response.data.leave_delete) {
          logsData.value = response.data.leave_delete
          toastr.success('Deleted Successfully!');
          getData();
        }
      }
    }).catch(error => {
      console.log(error);
    })
};

const onSubmit = () => {
  axios.post(environment.API_URL +'user/leave/leavesettings', {
    dataValues: dataValues.value
  }).then((response) => {
    if (response.data.success) {
      initializeData()
    }
  }).catch((error) => {
    console.log('error')
  })
}

const openDialog = () => {
  openLogsDialog.value = true;
}

//function that handles refresh when editing logs is successful
const handleEdit = () => {
  initializeData()
}
const openEditdialog = (data: any, id: any) => {
  editdialog.value = true
  logsData.value = data
  logId.value = id
}

const openDeletedialog = (data: any) => {
  deletedialog.value = true
  logsData.value = data
  initializeData()
}

const paginatedleavesettingsData = computed(() => {
  if (leave.value != null) {
    const datalogs = []
    datalogs.push(leave.value)
    const startIndex = (currentPage.value - 1) * itemsPerPage
    const endIndex = startIndex + itemsPerPage
    return datalogs[0].slice(startIndex, endIndex)
  }
})

const initializeData = () => {
  getData();
  // getEStatus();
}

onMounted(() => {
  initializeData();
});
</script>

<template>
  <section>
    <VCard>
      <VCardTitle class="py-7">
        Leave Settings
          <VCol class="d-flex justify-end" style="margin-top: -3%;">
            <VBtn @click.prevent="openDialog">Add leave</VBtn>
          </VCol>
          <VDivider/>
      </VCardTitle>
      <VTable class="px-5 mb-5">  
        <thead>
          <tr>
            <th class="text-center">
              Leave ID
            </th>
            <th class="text-center">
              Leave Count
            </th>
            <th class="text-center">
              Description
            </th>
            <th class="text-center">
              Date Updated
            </th>
            <th class="text-center">
              Actions
            </th>
          </tr>
        </thead>
        <tbody v-if="paginatedleavesettingsData != ''">
          <tr v-for="(data, index) in paginatedleavesettingsData" :key="data">
            <td class="text-center">{{ data.id }}</td>
            <td class="text-center">{{ data.leave_count }}</td>
            <td class="text-left">
              <ul>
                <VChip color="info" label>
                  Role:
                </VChip>
                {{ data.user_level }}
              </ul>
              <ul>
                <VChip color="info" label>
                  Reason:
                </VChip>
                {{ data.description }}
              </ul>
            </td>
            <td class="text-center">{{ moment(data.updated_at).format('MM/DD/YYYY') }}</td>
            <td>
              <VMenu open-on-hover activator="parent">
                <template v-slot:activator="{ props }">
                  <div class="text-center">
                    <VBtn style="margin: 0.5vw;" size="x-small" color="warning" prepend-icon="tabler-edit" v-bind="props" 
                      @click.prevent="openEditdialog(data, data.id)">
                    </VBtn>
                  
                    <VBtn size="x-small" color="error" prepend-icon="tabler-trash" v-bind="props"
                      @click.prevent="openDeletedialog(data)">
                    </VBtn>
                  </div>
                </template>
              </VMenu>
            </td>
          </tr>
        </tbody>
        <!-- 👉 table footer  -->
        <tfoot v-else>
          <tr>
            <td colspan="7" class="text-center py-10">
              <strong>
                Nothing to see here.
              </strong>
            </td>
          </tr>
        </tfoot>
      </VTable>
    </VCard>
    <VDialog v-model="openLogsDialog" max-width="600" max-height="600">
      <AddLeave :employeeuser="employeeuser" :isDialogSubmit="onSubmit" @close="openLogsDialog = false"
        @dataValues="handlesData" />
    </VDialog>
    <VDialog scrollable v-model="editdialog" max-width="600">
      <EditLeave :id="logId" :employeeuser="employeeuser" @close="editdialog = false" @onSubmit="handleEdit"
        :data="logsData" />
    </VDialog>
    <VDialog scrollable v-model="deletedialog" max-width="600">
      <DeleteLeave :id="logId" @close="deletedialog = false" :leaveDelete="leaveDelete" :logsData="logsData" />
    </VDialog>
  </section>
</template>
