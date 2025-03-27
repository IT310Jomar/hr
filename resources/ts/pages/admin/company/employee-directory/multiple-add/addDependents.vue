<script lang="ts" setup>
import confirmDelete from '../ConfrimDeletionDialog/confirmDeleteDependents.vue';
import { emailValidator, requiredValidator } from '@validators'
import axios from 'axios';
interface Props {
  Data: any
}

const dependents_firstname = ref([])
const dependents_lastname = ref([])
const dependents_middlename = ref([])
const dependents_birthdate = ref([])
const dependents_relationship = ref([])
const dependents_gender = ref([])
const dependents_note = ref([])
const dependent_id = ref([])
const props = defineProps<Props>()

// 👉 Add item function
const dependents = () => {
  props.Data.dependents.push({
    dependents_firstname: dependents_firstname.value = [],
    dependents_lastname: dependents_lastname.value = [],
    dependents_middlename: dependents_middlename.value = [],
    dependents_birthdate: dependents_birthdate.value = [],
    dependents_relationship: dependents_relationship.value = [],
    dependent_id: dependent_id.value = [],
    dependents_gender: dependents_gender.value = [],
    dependents_note: dependents_note.value = [],
  })
}

onMounted(() => {
  for (var i = 0; i < props.Data.dependent_list.length; i++) {
    console.log(props.Data.dependent_list[i])
    props.Data.dependents.push({
      dependents_firstname: dependents_firstname.value = props.Data.dependent_list[i].first_name,
      dependents_lastname: dependents_lastname.value = props.Data.dependent_list[i].last_name,
      dependents_middlename: dependents_middlename.value = props.Data.dependent_list[i].middle_name,
      dependents_birthdate: dependents_birthdate.value = props.Data.dependent_list[i].birthdate,
      dependents_relationship: dependents_relationship.value = props.Data.dependent_list[i].relationship,
      dependent_id: dependent_id.value = props.Data.dependent_list[i].id,
      dependents_gender: dependents_gender.value = props.Data.dependent_list[i].gender,
      dependents_note: dependents_note.value = props.Data.dependent_list[i].notes,
    })
  }
})
// 👉 Remove edit section
const dataId = ref();
const dataIndex = ref();
const confirmDeletion = ref(false)

// 👉 Remove BANKS edit section
const removeDependents = (index: any, id: any) => {
  dataId.value = id
  dataIndex.value = index
  if(dataId.value != null && dataId.value == '') {
    const indexs = props.Data.dependents.findIndex((dependents: any) => dependents.dependent_id === dataId.value);
    props.Data.dependents.splice(indexs, 1);
  } else {
    axios.get('/api/user/employees/deleteItems/' + dataId.value)
    .then(response => {
    if (response.data.success) {
      if(response.data.deleteRow) {
        const indexs = props.Data.dependents.findIndex((dependents: any) => dependents.dependent_id === dataId.value);
        props.Data.dependents.splice(indexs, 1);
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
const gender = ref([{ item: '--Select Option--', value: null }, { item: 'Male', value: 'male' }, { item: 'Female', value: 'female' }])

</script>
<template style="width: 1000px">
  <VCard style="margin: 2vh;">
    <VToolbar color="primary" title="Dependents" />
      <VCard style="width: 100%; overflow-x: auto;" >
        <VTable class="px-2 py-2">
          <!-- 👉 table head -->
          <thead>
          <tr>
            <th scope="col" class="text-center">
              First Name
            </th>
            <th scope="col" class="text-center">
              Last Name
            </th>
            <th scope="col" class="text-center">
              Middle Name
            </th>
            <th scope="col" class="text-center">
              Relationship
            </th>

            <th scope="col" class="text-center">
              Date of Birth
            </th>
            <th scope="col" class="text-center">
              Gender
            </th>

            <th scope="col" class="text-center">
              Notes
            </th>
            <th scope="col" class="text-center">
              Actions
            </th>
          </tr>
        </thead>
          <!-- 👉 table body -->
          <tbody v-if="Data.dependents.length > 0">
            <tr v-for="(dependents, index) in props.Data.dependents" :key="dependents">
              <td scope="col" width="auto">

                <VCol hidden>
                  <VTextField v-model="dependents.dependent_id" type="number" />
                </VCol>
                <VCol sm="3.5" md="3.5">
                  <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="dependents.dependents_firstname" type="text" />
                </VCol>
              </td>
              <td scope="col" width="auto">
                <VCol sm="3.5" md="3.5">
                  <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="dependents.dependents_lastname" type="text" />
                </VCol>
              </td>
              <td scope="col" width="auto">
                <VCol sm="3.5" md="3.5">
                  <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="dependents.dependents_middlename" type="text" />
                </VCol>
              </td>
              <td scope="col" width="auto">
                <VCol sm="3.5" md="3.5">
                  <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="dependents.dependents_relationship" type="text" />
                </VCol>
              </td>
              <td scope="col" width="auto">
                <VCol sm="3.5" md="3.5">
                  <VTextField :rules="[requiredValidator]" style="min-width: 160px; width: auto;" v-model="dependents.dependents_birthdate" type="date" />
                </VCol>
              </td>
              <td scope="col" width="auto">
                <VCol sm="3.5" md="3.5">
                  <VSelect :rules="[requiredValidator]" style="min-width: 110px; width: auto;" v-model="dependents.dependents_gender" :items="gender" item-title="item" item-value="value"
                   type="text" />
                </VCol>
              </td>
              <td scope="col" width="auto">
                <VCol sm="3.5" md="3.5">
                  <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="dependents.dependents_note" type="text" />
                </VCol>
              </td>
              <td scope="col" class="text-center">
                <VBtn icon size="x-small" @click="openConfirmDialog(index,dependents.dependent_id)" color="error"
                  variant="text">
                  <VIcon size="22" icon="tabler-trash" />
                </VBtn>
              </td>
            </tr>
          </tbody>
        </VTable>
      </VCard>
    <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
      <VCol class="text-right clearfix">
        <VBtn @click.prevent="dependents" style="font-size: 10px; padding: 12px; float: right">
          <VIcon start icon="tabler-plus" />Add New Dependents
        </VBtn>
      </VCol>
    </VCardText>
  </VCard>

  <VDialog
  scrollable
  v-model="confirmDeletion"
  maxWidth="300"
  >
   <confirmDelete  :dataId="dataId" :dataIndex="dataIndex" :removeDependents="removeDependents" @close="confirmDeletion=false"/>
  </VDialog>

</template>
