<script lang="ts" setup>
import confirmDelete from '../ConfrimDeletionDialog/confirmDeleteDocuments.vue';
import { emailValidator, requiredValidator } from '@validators'
import axios from 'axios';
interface Props {
  Data: any
}
const idToDelete = ref(null);
const props = defineProps<Props>()
const file_name = ref([])
const creation_time = ref([])
const id = ref([])

// 👉 Add item function
const addDocuments = () => {
  props.Data.documents.push({
    id: id.value = [],
    file_name: file_name.value = [],
    creation_time: creation_time.value = [],
  })
}

onMounted(() => {
  for (var i = 0; i < props.Data.document_records.length; i++) {
    props.Data.documents.push({
      id: id.value = props.Data.document_records[i].id,
      file_name: file_name.value = props.Data.document_records[i].file_name,
      creation_time: creation_time.value = props.Data.document_records[i].creation_time,
    })
  }
})

// 👉 Remove edit section
const dataId = ref();
const dataIndex = ref();
const confirmDeletion = ref(false)

// 👉 Remove Documents edit section
const removeDocuments = (index: any, id: any) => {
  dataId.value = id
  dataIndex.value = index
  if (dataId.value != null && dataId.value == '') {
    const indexs = props.Data.documents.findIndex((documents: any) => documents.id === dataId.value);
    props.Data.documents.splice(indexs, 1);
  } else {
    axios.get('/api/user/employees/deleteItems/' + dataId.value)
      .then(response => {
        if (response.data.success) {
          if (response.data.deleteRow) {
            const indexs = props.Data.documents.findIndex((documents: any) => documents.id === dataId.value);
            props.Data.documents.splice(indexs, 1);
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
    <VToolbar color="primary" title="Documents" />
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
              Actions
            </th>
          </tr>
        </thead>
        <tbody v-if="props.Data.documents.length > 0">
          <tr v-for="(documents, index) in props.Data.documents" :key="documents">
            <td scope="col" style="width:36vw">
              <VCol sm="3.5" md="3.5" hidden>
                <VTextField v-model="documents.id" type="text" />
              </VCol>
              <VTextField :rules="[requiredValidator]" style="min-width: 150px; width: auto;" v-model="documents.file_name" type="text" />
            </td>
            <td scope="col">
                <VTextField :rules="[requiredValidator]" style="min-width: 160px; width: auto;" v-model="documents.creation_time" type="date" />
            </td>
            <td scope="col" class="text-center">
              <VBtn icon size="x-small" @click="openConfirmDialog(index, documents.id)" color="error" variant="text">
                <VIcon size="22" icon="tabler-trash" />
              </VBtn>
            </td>
          </tr>
        </tbody>
      </VTable>
    </VCard>
    <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
      <VCol class="text-right clearfix">
        <VBtn @click.prevent="addDocuments" style="font-size: 10px; padding: 12px; float: right">
          <VIcon start icon="tabler-plus" />Add Document
        </VBtn>
      </VCol>
    </VCardText>
  </VCard>

  <VDialog scrollable v-model="confirmDeletion" maxWidth="300">
    <confirmDelete :dataId="dataId" :dataIndex="dataIndex" :removeDocuments="removeDocuments" @close="confirmDeletion = false" />
  </VDialog>
</template>
