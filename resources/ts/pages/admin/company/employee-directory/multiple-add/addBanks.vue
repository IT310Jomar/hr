<script lang="ts" setup>
import confirmDelete from '../ConfrimDeletionDialog/confirmDeleteBank.vue';
import { emailValidator, requiredValidator } from '@validators'

import axios from 'axios';
interface Props {
  Data: any
}

const props = defineProps<Props>()
const bank_account_no = ref([])
const bank_name = ref([])
const id = ref([])

// 👉 Add item function
const addBankItem = () => {
  props.Data.banks.push({
    id: id.value = [],
    bank_account_no: bank_account_no.value = [],
    bank_name: bank_name.value = [],
  })
}

onMounted(() => {
  for (var i = 0; i < props.Data.bank_list.length; i++) {
    // console.log(active_status.value = props.Data.benefit_list[i].active)
    props.Data.banks.push({
      id: id.value = props.Data.bank_list[i].id,
      bank_account_no: bank_account_no.value = props.Data.bank_list[i].account_number,
      bank_name: bank_name.value = props.Data.bank_list[i].name,
    })
  }
})

// 👉 Remove edit section
const dataId = ref();
const dataIndex = ref();
const confirmDeletion = ref(false)


// 👉 Remove BANKS edit section
const removeBanks = (index: any, id: any) => {
  dataId.value = id
  dataIndex.value = index
  if (dataId.value != null && dataId.value == '') {
    const indexs = props.Data.banks.findIndex((banks: any) => banks.id === dataId.value);
    props.Data.banks.splice(indexs, 1);
  } else {
    axios.get('/api/user/employees/deleteItems/' + dataId.value)
      .then(response => {
        if (response.data.success) {
          if (response.data.deleteRow) {
            const indexs = props.Data.banks.findIndex((banks: any) => banks.id === dataId.value);
            props.Data.banks.splice(indexs, 1);
          }
        }
      })
  }
}

const openConfirmDialog = (index: any, id: any) => {
  confirmDeletion.value = true
  dataId.value = id
  dataIndex.value = index
}

</script>

<template>
  <VCard style="margin:2vh;">
    <VToolbar color="primary" title="Salary" />
    <VCardTitle class="py-5">
      Bank Details
      <VRow>
        <VCol class="d-flex justify-end mr-6 mb-5 " style="margin-top: -2%;">
          <VBtn @click.prevent="addBankItem" style="font-size: 10px; padding: 12px; float: right">
            <VIcon start icon="tabler-plus" />Add Bank Account
          </VBtn>
        </VCol>
      </VRow>
      <VDivider />
    </VCardTitle>
    <VCard style="margin: 2vh;">
      <VTable class="py-2 px-2">
        <thead>
          <tr>
            <th class="text-center" scope="col">
              Bank
            </th>
            <th class="text-center" scope="col">
              Bank Account No
            </th>
            <th class="text-center" scope="col">
              Actions
            </th>
          </tr>
        </thead>
        <!-- 👉 table body -->
        <tbody>
          <tr v-for="(banks, index) in props.Data.banks" :key="banks.title">
            <td scope="col" width="auto">
              <VCol sm="3.5" md="3.5" hidden>
                <VTextField v-model="banks.id" type="text" />
              </VCol>
              <VCol sm="3.5" md="3.5">
                <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="banks.bank_name" type="text" />
              </VCol>
            </td>
            <td scope="col" width="auto">
              <VCol sm="3.5" md="3.5">
                <VTextField :rules="[requiredValidator]" style="min-width: 280px; width: auto;" v-model="banks.bank_account_no" type="number" />
              </VCol>
            </td>
            <td scope="col" width="auto" class="text-center">
              <VBtn icon size="x-small" @click="openConfirmDialog(index, banks.id)" color="error" variant="text">
                <VIcon size="22" icon="tabler-trash" />
              </VBtn>
            </td>
          </tr>
        </tbody>
      </VTable>
    </VCard>
  </VCard>

  <VDialog scrollable v-model="confirmDeletion" maxWidth="300">
    <confirmDelete :dataId="dataId" :dataIndex="dataIndex" :removeBanks="removeBanks" @close="confirmDeletion = false" />
  </VDialog>
</template>
