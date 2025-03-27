<script lang="ts" setup>
import confirmDelete from '../ConfrimDeletionDialog/confirmDeleteEducation.vue';
import { emailValidator, requiredValidator } from '@validators'

import axios from 'axios';
interface Props {
  Data: any
}

const educational_type = ref([])
const school = ref([])
const datefrom = ref([])
const dateto = ref([])
const degree = ref([])
const id = ref([])
const ed_id = ref([])
const idToDelete = ref()
const props = defineProps<Props>()
const educationtype = ref([{ item: '--Select Option--', value: null }])
// 👉 Add item function
const addItem = () => {
  props.Data.education.push({
    educational_type: educational_type.value = [],
    school: school.value = [],
    datefrom: datefrom.value = [],
    dateto: dateto.value = [],
    degree: degree.value = [],
    id: id.value = [],
    ed_id: ed_id.value = [],
  })
}

onMounted(() => {
  getEducationType()
  for (var i = 0; i < props.Data.edu_list.length; i++) {
    // console.log(educational_type.value = props.Data.edu_list[i].to)
    props.Data.education.push({
      educational_type: educational_type.value = props.Data.edu_list[i].education_type_id,
      school: school.value = props.Data.edu_list[i].school,
      datefrom: datefrom.value = props.Data.edu_list[i].from,
      degree: degree.value = props.Data.edu_list[i].degree,
      dateto: dateto.value = props.Data.edu_list[i].to,
      ed_id: ed_id.value = props.Data.edu_list[i].id,
    })
  }
})

// 👉 Remove edit section
const dataId = ref();
const dataIndex = ref();
const confirmDeletion = ref(false)


// 👉 Remove BANKS edit section
const removeEducation = (index: any, id: any) => {
  dataId.value = id
  dataIndex.value = index
  if(dataId.value != null && dataId.value == '') {
    const indexs = props.Data.education.findIndex((education: any) => education.ed_id === dataId.value);
    props.Data.education.splice(indexs, 1);
  } else {
    axios.get('/api/user/employees/deleteItems/' + dataId.value)
    .then(response => {
    if (response.data.success) {
      if(response.data.deleteRow) {
        const indexs = props.Data.education.findIndex((education: any) => education.ed_id === dataId.value);
        props.Data.education.splice(indexs, 1);
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

// 👉 Remove Education edit section
// const removeEducation = (id: any) => {
//   idToDelete.value = id;
//   if(idToDelete.value != null && idToDelete.value == '') {
//     const indexs = props.Data.education.findIndex((education: any) => education.ed_id === idToDelete.value);
//     props.Data.education.splice(indexs, 1);
//   } else {
//     confirmDelete()
//   }
// }


// const confirmDelete = () => {
//   axios.get('/api/user/employees/deleteItems/' + idToDelete.value)
//     .then(response => {
//     if (response.data.success) {
//       if(response.data.deleteRow) {
//         const indexs = props.Data.education.findIndex((education: any) => education.ed_id === idToDelete.value);
//         props.Data.education.splice(indexs, 1);
//       }
//     }
//   })
// }

const getEducationType = () => {
  axios.get('/api/user/employees/getEmploymentOptions')
    .then(response => {
      if (response.data.success) {
        if (response.data.edu_type) {
          for (var x = 0; x < response.data.edu_type.length; x++) {
            educationtype.value.push(
              {
                item: response.data.edu_type[x].name,
                value: response.data.edu_type[x].id,
              }

            )
          }
        }
      }
    })
    .catch(error => {
      console.error(error)
    })
}  
</script>

<template>
  <VCard style="margin:2vh;" >
    <VToolbar color="primary" title="Educational Background" />
      <VCard style="width: 100%; overflow-x: auto;">
        <VTable class="px-2 py-2" style="width: auto !important;">
          <!-- 👉 table head -->
          <thead>
            <tr>
              <th class="text-center" scope="col">
                Education Type
              </th>
              <th class="text-center" scope="col">
                School
              </th>
              <th class="text-center" scope="col">
                From
              </th>
              <th class="text-center" scope="col">
                To
              </th>
              <th class="text-center" scope="col">
                Degree
              </th>
              <th class="text-center" scope="col">
                Actions
              </th>
            </tr>
          </thead>
          <!-- 👉 table body -->
          <tbody class="clearfix" v-if="Data.education.length > 0">
            <tr v-for="(education, index) in props.Data.education" :key="education">
              <td scope="col" width="auto">
                <VSelect :rules="[requiredValidator]" style="min-width: 210px; width: auto;" v-model="education.educational_type" :items="educationtype" item-title="item" item-value="value"
                 type="text" />
              </td>
              <td scope="col" width="auto">
                <VCol sm="3.5" md="3.5" hidden>
                  <VTextField v-model="education.id" type="text" />
                  <VTextField v-model="education.ed_id" type="number" />
                </VCol>
                <VCol sm="3.5" md="3.5" >
                  <VTextField :rules="[requiredValidator]" style="min-width: 250px; width: auto;" v-model="education.school" type="text" />
                </VCol>
              </td>
              <td scope="col" width="auto">
                <VTextField :rules="[requiredValidator]" style="min-width: 180px; width: auto;" v-model="education.datefrom" type="date" />
              </td>
              <td scope="col" width="auto">
                <VTextField :rules="[requiredValidator]" style="min-width: 180px; width: auto;" v-model="education.dateto" type="date" />
              </td>
              <td scope="col" width="auto">
                <VCol sm="3.5" md="3.5">
                  <VTextField :rules="[requiredValidator]" style="min-width: 180px; width: auto;" v-model="education.degree" type="text" />
                </VCol>
              </td>
              <td scope="col" class="text-center">
                <VBtn icon size="x-small" @click="openConfirmDialog(index, education.ed_id)" color="error" variant="text">
                  <VIcon size="22" icon="tabler-trash" />
                </VBtn>
              </td>
            </tr>
          </tbody>
          <tfoot style="display: none;">
            <tr>
              <td colspan="7" class="text-center">
                No data available
              </td>
            </tr>
          </tfoot>
        </VTable>
      </VCard>
    <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
      <VCol class="text-right clearfix">
        <VBtn @click="addItem" style="font-size: 10px; padding: 12px; float: right">
          <VIcon start icon="tabler-plus" />Add Educational Background
        </VBtn>
      </VCol>
    </VCardText>
  </VCard>
  
  <VDialog
  scrollable
  v-model="confirmDeletion"
  maxWidth="300"
  >
   <confirmDelete  :dataId="dataId" :dataIndex="dataIndex" :removeEducation="removeEducation" @close="confirmDeletion=false"/>
  </VDialog>

</template>

<style>
.table-container {
  width: 100%;
  overflow-x: auto;
}

.table {
  width: auto !important;
}
</style>
