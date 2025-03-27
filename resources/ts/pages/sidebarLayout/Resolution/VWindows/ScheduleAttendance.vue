<script setup lang="ts">
import Unresolveview from '@/pages/resolution/Unresolveview.vue';
import Unresolveedit from '@/pages/resolution/Unresolveedit.vue';
import VDialogDelete from '../DeleteDialog/VDialogDelete.vue';
import axios from 'axios';
import { ref } from 'vue';
import { isEmpty } from '@/@core/utils';
import { environment } from '@/environments/environment';
const selectedItem = ref()
const selectedItem1 = ref()

const unresolves = ref()
const resolves = ref()
const dfrom = ref('')
const dto = ref('')
const token = JSON.parse(localStorage.getItem('accessToken') || 'null');
const test = ref()
const editRes = ref()
const isDialogVisible = ref(false)
const isDialogVisible2 = ref(false)
const props = defineProps(['inputs'])
const dialogVisible = ref(false);

const unresolveSchedAjustment = () => {
  axios.get(environment.API_URL + 'user/resolution/resolution-center/getPending', {
    params: {
      token: token, dfrom: dfrom.value,
      dto: dto.value,
      employeeID: selectedItem1.value,
      department: selectedItem.value,
    }
  })
    .then(response => {
      if (response.data.success) {
        if (response.data.allData) {
          unresolves.value = response.data.allData[0].certificate_Att
        }
      }
    })
}

const resolve = () => {
  axios.get(environment.API_URL + 'user/resolution/resolution-center/getApprove', { params: { token: token } })
    .then(response => {
      if (response.data.success) {
        if (response.data.cashAdvanceApproved) {
          resolves.value = response.data.cashAdvanceApproved
        }
      }
    })
}

const deleteRequest = (requests : any)  => {
  axios.get(environment.API_URL + 'user/resolution/resolution-center/delete-request-attendance/' + requests, { params : {token : token} })
  .then(response => {
    if (response.data.success) {
      if (response.data.deleteAttendance) {
          const indexs = unresolves.value.findIndex((schedAd: any) => schedAd.id === requests);
          unresolves.value.splice(indexs, 1);
      }
    }
  })
}

const allData = ref()
const openDialog = (toDelete : any) => {
  allData.value = unresolves.value
  dialogVisible.value = true
} 

const closeDialog = () => {
  dialogVisible.value = false;
}

const sendEmail = (tests: any) => {
  test.value = tests;
  isDialogVisible.value = true
}

const editResolve = (edit: any) => {
  editRes.value = edit;
  isDialogVisible2.value = true
}

const closedViewDialog = () => {
  isDialogVisible.value = false
  initializeData()
}

const closedViewDialog2 = () => {
  isDialogVisible2.value = false
  initializeData()
}

const initializeData = () => {
  unresolveSchedAjustment()
  resolve()
}

onMounted(() => {
  initializeData()
})


watch(props, () => {
  if (!isEmpty(props)) {
    dto.value = props.inputs[0].dateTo
    dfrom.value = props.inputs[0].dateFrom
    selectedItem1.value = props.inputs[0].empID
    selectedItem.value = props.inputs[0].dept
    unresolveSchedAjustment()
  } 
});

</script>

<template>
  <div class="unresolve">
    <div class="badge">
      <VBadge :content="unresolves?.length" color="error" class="my-badge"  >
        <VToolbar
          title="Unresolve"
          style="width: 7.5vw; background: none;"
        />
      </VBadge>
    </div>
    <VTable class="px-5 mb-5">
      <thead>
        <tr>
          <th scope="col">
            Dates
          </th>
          <th scope="col">
            Employees
          </th>
          <th scope="col">
            Type
          </th>
          <th scope="col">
            Action
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(user) in unresolves" :key="user" style="height: 3.75rem;">
          <!-- 👉 User -->
          <td>{{ user.login }}</td>
          <td>{{ user.employee.first_name }} {{ user.employee.middle_name }} {{ user.employee.last_name }}</td>
          <td>{{ user.status_id }}</td>
          <td class="text-center">

            <VIcon @click.prevent="editResolve(user)" color="primary" icon="tabler-edit" class="mr-5" />

            <VIcon @click.prevent="sendEmail(user)" color="primary" icon="tabler:mail" class="mr-5" />

            <VIcon @click.prevent="openDialog(user)" color="primary" icon="tabler:circle-minus" class="mr-5" />
          </td>
        </tr>
      </tbody>
      <tr v-if="unresolves?.length == 0">
        <td colspan="12" style="text-align: center;">
          No Unresolves Data Found!
        </td>
      </tr>
    </VTable>
  </div>

  <div class="resolve">
    <div class="badge">
      <VBadge :content="resolves?.length" color="error" class="my-badge"  >
        <VToolbar
          title="Resolve"
          style="width: 7.5vw; background: none;"
        />
      </VBadge>
    </div>
      <VTable class="px-5 mb-5">
        <!-- 👉 table head -->
        <thead>
          <tr>
            <th scope="col">
              Dates
            </th>
            <th scope="col">
              Employees
            </th>
            <th scope="col">
              Type
            </th>
          </tr>
        </thead>
        <!-- 👉 table body -->
        <tbody>
          <tr v-for="(user) in resolves" :key="user" style="height: 3.75rem;">
            <!-- 👉 User -->
            <td>{{ user.date_from }} to {{ user.date_to }}</td>
            <td>{{ user.employee.first_name }} {{ user.employee.middle_name }} {{ user.employee.last_name }}
            </td>
            <td>{{ user.status_id }}</td>
          </tr>
        </tbody>
        <tr v-if="resolves?.length == 0">
          <td colspan="12" style="text-align: center;">
            No Resolve Data Found!
          </td>
        </tr>
      </VTable>
  </div>
    
  <VDialog v-model="isDialogVisible" max-width="500">
    <!-- Dialog Activator -->
    <Unresolveedit :test="test" @closeDialog="closedViewDialog" />
    <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />
  </VDialog>

  <VDialog v-model="isDialogVisible2" max-width="500">
    <!-- Dialog Activator -->
    <Unresolveview :editRes="editRes" @closeDialog="closedViewDialog2" />
    <DialogCloseBtn @click="isDialogVisible2 = !isDialogVisible2" />
  </VDialog>

  <VDialog v-model="dialogVisible" max-width="500">
    <VDialogDelete @toDeleteData="closeDialog" />
    <DialogCloseBtn @click="dialogVisible = !dialogVisible" />
  </VDialog>
</template>
