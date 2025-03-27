<script lang="ts" setup>
import confirmDelete from '../ConfrimDeletionDialog/confirmDeleteMedicalRecord.vue';
import { emailValidator, requiredValidator } from '@validators'
import axios from 'axios';
interface Props {
  Data: any
}
const idToDelete = ref(null);
const props = defineProps<Props>()
const file_name = ref([])
const creation_time = ref([])
const classification = ref([])
const notes = ref([])

const id = ref([])

// 👉 Add item function
const addMedical = () => {
  props.Data.medical_record.push({
    id: id.value = [],
    file_name: file_name.value = [],
    creation_time: creation_time.value = [],
    classification: classification.value = [],
    notes: notes.value = [],
  })
}

onMounted(() => {
  for (var i = 0; i < props.Data.medical_records.length; i++) {
    props.Data.medical_record.push({
      id: id.value = props.Data.medical_records[i].id,
      file_name: file_name.value = props.Data.medical_records[i].file_name,
      creation_time: creation_time.value = props.Data.medical_records[i].creation_time,
      classification: classification.value = props.Data.medical_records[i].classification,
      notes: notes.value = props.Data.medical_records[i].notes,

    })
  }
})

// 👉 Remove edit section
const dataId = ref();
const dataIndex = ref();
const confirmDeletion = ref(false)

// 👉 Remove Medical edit section
const removeMedical = (index: any, id: any) => {
  dataId.value = id
  dataIndex.value = index
  if (dataId.value != null && dataId.value == '') {
    const indexs = props.Data.medical_record.findIndex((medical_record: any) => medical_record.id === dataId.value);
    props.Data.medical_record.splice(indexs, 1);
  } else {
    axios.get('/api/user/employees/deleteItems/' + dataId.value)
      .then(response => {
        if (response.data.success) {
          if (response.data.deleteRow) {
            const indexs = props.Data.medical_record.findIndex((medical_record: any) => medical_record.id === dataId.value);
            props.Data.medical_record.splice(indexs, 1);
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
    <VToolbar color="primary" title="Medical Records" />
      <VCard style="margin: 2vh;" >
      <VTable class="py-2 px-2">
        <thead>
          <tr>
            <th scope="col">
              File Name
            </th>
            <th scope="col">
              Creation Time
            </th>
            <th scope="col">
              Classification
            </th>
            <th scope="col">
              Notes
            </th>
            <th scope="col">
              Actions
            </th>
          </tr>
        </thead>
        <tbody v-if="props.Data.medical_record.length > 0">
          <tr v-for="(medical_record, index) in props.Data.medical_record" :key="medical_record">
            <td scope="col" style="width:36vw">
              <VCol sm="3.5" md="3.5" hidden>
                <VTextField v-model="medical_record.id" type="text" />
              </VCol>
              <VTextField :rules="[requiredValidator]" style="min-width: 150px; width: auto;" v-model="medical_record.file_name" type="text" />
            </td>
            <td scope="col">
                <VTextField :rules="[requiredValidator]" style="min-width: 160px; width: auto;" v-model="medical_record.creation_time" type="date" />
            </td>
            <td scope="col">
                <VTextField :rules="[requiredValidator]" style="min-width: 160px; width: auto;" v-model="medical_record.classification" type="text" />
            </td>
            <td scope="col">
                <VTextField :rules="[requiredValidator]" style="min-width: 160px; width: auto;" v-model="medical_record.notes" type="text" />
            </td>
            <td scope="col" class="text-center">
              <VBtn icon size="x-small" @click="openConfirmDialog(index, medical_record.id)" color="error" variant="text">
                <VIcon size="22" icon="tabler-trash" />
              </VBtn>
            </td>
          </tr>
        </tbody>
      </VTable>
    </VCard>
    <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
      <VCol class="text-right clearfix">
        <VBtn @click.prevent="addMedical" style="font-size: 10px; padding: 12px; float: right">
          <VIcon start icon="tabler-plus" />Add Medical
        </VBtn>
      </VCol>
    </VCardText>
  </VCard>

  <VDialog scrollable v-model="confirmDeletion" maxWidth="300">
    <confirmDelete :dataId="dataId" :dataIndex="dataIndex" :removeMedical="removeMedical" @close="confirmDeletion = false" />
  </VDialog>
</template>
