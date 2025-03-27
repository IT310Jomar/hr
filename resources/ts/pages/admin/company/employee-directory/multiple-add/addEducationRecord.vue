<script lang="ts" setup>
import confirmDelete from '../ConfrimDeletionDialog/confirmDeleteEmployeeRecord.vue';
import { emailValidator, requiredValidator } from '@validators'
import axios from 'axios';
interface Props {
  Data: any
}

const props = defineProps<Props>()
const id = ref([])
const position = ref([])
const company = ref([])
const industry = ref([])
const from = ref([])
const to = ref([])

// 👉 Add item function
const addEmploymentItem = () => {
  props.Data.employments_record.push({
    id: id.value = [],
    position: position.value = [],
    company: company.value = [],
    industry: industry.value = [],
    from: from.value = [],
    to: to.value = []
  })
}

onMounted(() => {
  for (var i = 0; i < props.Data.employment_rec_list.length; i++) {
    props.Data.employments_record.push({
      id: id.value = props.Data.employment_rec_list[i].id,
      position: position.value = props.Data.employment_rec_list[i].position,
      company: company.value = props.Data.employment_rec_list[i].company,
      industry: industry.value = props.Data.employment_rec_list[i].industry,
      from: from.value = props.Data.employment_rec_list[i].from,
      to: to.value = props.Data.employment_rec_list[i].to,
    })
  }
})

// 👉 Remove edit section
const dataId = ref();
const dataIndex = ref();
const confirmDeletion = ref(false)


// 👉 Remove employments_record edit section
const removeEmployeeRecord = (index: any, id: any) => {
  dataId.value = id
  dataIndex.value = index
  if(dataId.value != null && dataId.value == '') {
    const indexs = props.Data.employments_record.findIndex((employments_record: any) => employments_record.id === dataId.value);
    props.Data.employments_record.splice(indexs, 1);
  } else {
    axios.get('/api/user/employees/deleteItems/' + dataId.value)
    .then(response => {
    if (response.data.success) {
      if(response.data.deleteRow) {
        const indexs = props.Data.employments_record.findIndex((employments_record: any) => employments_record.id === dataId.value);
        props.Data.employments_record.splice(indexs, 1);
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
    <VToolbar color="primary" title="Employment Record" />
      <VCard style="margin: 2vh;" >
        <VTable class="py-2 px-2">
          <!-- 👉 table head -->
          <thead>
            <tr>
              <th class="text-center" scope="col">
                Position
              </th>
              <th class="text-center" scope="col">
                Company
              </th>
              <th class="text-center" scope="col">
                Industry
              </th>
              <th class="text-center" scope="col">
                From
              </th>
              <th class="text-center" scope="col">
                To
              </th>
              <th class="text-center" scope="col">
                Actions
              </th>
            </tr>
          </thead>
          <!-- 👉 table body -->
          <tbody v-if="Data.employments_record.length > 0" style="width:max-content">
            <tr v-for="(employments_record, index) in props.Data.employments_record" :key="employments_record">
              <td scope="col" width="auto">
                <VCol sm="3.5" md="3.5" hidden>
                  <VTextField v-model="employments_record.id" type="text" />
                </VCol>
                <VTextField :rules="[requiredValidator]" style="min-width: 160px; width: auto;" v-model="employments_record.position" type="text" />
              </td>
              <td scope="col" style="width:13vw">
                <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="employments_record.company" type="text" />
              </td>
              <td scope="col" style="width:13vw">
                <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="employments_record.industry" type="text" />
              </td>

              <td scope="col" style="width:13vw">

                <VTextField :rules="[requiredValidator]" style="min-width: 160px; width: auto;" v-model="employments_record.from" type="date" />

              </td>
              <td scope="col" style="width:13vw">

                <VTextField :rules="[requiredValidator]" style="min-width: 160px; width: auto;" v-model="employments_record.to" type="date" />

              </td>
              <td scope="col" class="text-center">
                <VBtn icon size="x-small" @click="openConfirmDialog(index,employments_record.id)" color="error" variant="text">
                  <VIcon size="22" icon="tabler-trash" />
                </VBtn>
              </td>
            </tr>
          </tbody>
        </VTable>
      </VCard>
    <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
      <VCol class="text-right clearfix">
        <VBtn @click.prevent="addEmploymentItem" style="font-size: 10px; padding: 12px; float: right">
          <VIcon start icon="tabler-plus" />Add Record
        </VBtn>
      </VCol>
    </VCardText>
  </VCard>

  <VDialog
  scrollable
  v-model="confirmDeletion"
  maxWidth="300"
  >
   <confirmDelete  :dataId="dataId" :dataIndex="dataIndex" :removeEmployeeRecord="removeEmployeeRecord" @close="confirmDeletion=false"/>
  </VDialog>

</template>
