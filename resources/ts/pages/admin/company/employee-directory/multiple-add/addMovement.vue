<script lang="ts" setup>
import { emailValidator, requiredValidator } from '@validators'
import confirmDelete from '../ConfrimDeletionDialog/confirmDeleteMovement.vue';
import axios from 'axios';
interface Props {
  Data: any
}

const id = ref([])
const date_from = ref([])
const date_to = ref([])
const from_position = ref([])
const from_department = ref([])
const from_employment_type_id = ref([])
const from_employment_status_id = ref([])

const to_position = ref([])
const to_department = ref([])
const to_employment_type_id = ref([])
const to_employment_status_id = ref([])
const action_for = ref([])
const notes = ref([])
const from_employmentTypes = ref([{ item: '--Select Option--', value: null }])
const from_employmentStatus = ref([{ item: '--Select Option--', value: null }])
const to_employmentTypes = ref([{ item: '--Select Option--', value: null }])
const to_employmentStatus = ref([{ item: '--Select Option--', value: null }])
const props = defineProps<Props>()
// 👉 Add item function
const addMovements = () => {
  props.Data.movements.push({
    id: id.value = [],
    date_from: date_from.value = [],
    date_to: date_to.value = [],
    from_position: from_position.value = [],
    from_department: from_department.value = [],
    from_employment_type_id: from_employment_type_id.value = [],
    from_employment_status_id: from_employment_status_id.value = [],
    to_position: to_position.value = [],
    to_department: to_department.value = [],
    to_employment_type_id: to_employment_type_id.value = [],
    to_employment_status_id: to_employment_status_id.value = [],
    action_for: action_for.value = [],
    notes: notes.value = [],
  })
}

const getEmploymentTypes = () => {
  axios.get('/api/user/employees/getEmploymentOptions')
    .then(response => {
      if (response.data.success) {
        if (response.data.employment_types) {
          for (var x = 0; x < response.data.employment_types.length; x++) {
            from_employmentTypes.value.push(
              {
                item: response.data.employment_types[x].name,
                value: response.data.employment_types[x].id,
              }
            )
          }

          for (var i = 0; i < response.data.employment_types.length; i++) {
            to_employmentTypes.value.push(
              {
                item: response.data.employment_types[i].name,
                value: response.data.employment_types[i].id,
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

const getEmploymentStatus = () => {
  axios.get('/api/user/employees/getEmploymentOptions')
    .then(response => {
      if (response.data.success) {
        if (response.data.employment_statuses) {
          for (var x = 0; x < response.data.employment_statuses.length; x++) {
            from_employmentStatus.value.push(
              {
                item: response.data.employment_statuses[x].name,
                value: response.data.employment_statuses[x].id,
              }
            )
          }

          for (var i = 0; i < response.data.employment_statuses.length; i++) {
            to_employmentStatus.value.push(
              {
                item: response.data.employment_statuses[i].name,
                value: response.data.employment_statuses[i].id,
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


onMounted(() => {
  getEmploymentTypes()
  getEmploymentStatus()
  for (var i = 0; i < props.Data.movements_list.length; i++) {
    console.log(props.Data.movements_list[i])
    props.Data.movements.push({
      date_from: date_from.value = props.Data.movements_list[i].date_from,
      date_to: date_to.value = props.Data.movements_list[i].date_to,
      from_position: from_position.value = props.Data.movements_list[i].from_position,
      from_department: from_department.value = props.Data.movements_list[i].from_department,
      from_employment_type_id: from_employment_type_id.value = props.Data.movements_list[i].from_employment_type_id,
      from_employment_status_id: from_employment_status_id.value = props.Data.movements_list[i].from_employment_status_id,
      to_position: to_position.value = props.Data.movements_list[i].to_position,
      to_department: to_department.value = props.Data.movements_list[i].to_department,

      to_employment_type_id: to_employment_type_id.value = props.Data.movements_list[i].to_employment_type_id,
      to_employment_status_id: to_employment_status_id.value = props.Data.movements_list[i].to_employment_status_id,
      action_for: action_for.value = props.Data.movements_list[i].action_for,
      notes: notes.value = props.Data.movements_list[i].notes,
      id: id.value = props.Data.movements_list[i].id,
    })
  }
})

// 👉 Remove edit section
const dataId = ref();
const dataIndex = ref();
const confirmDeletion = ref(false)


// 👉 Remove movements edit section
const removeMovement = (index: any, id: any) => {
  dataId.value = id
  dataIndex.value = index
  if(dataId.value != null && dataId.value == '') {
    const indexs = props.Data.movements.findIndex((movements: any) => movements.id === dataId.value);
    props.Data.movements.splice(indexs, 1);
  } else {
    axios.get('/api/user/employees/deleteItems/' + dataId.value)
    .then(response => {
    if (response.data.success) {
      if(response.data.deleteRow) {
        const indexs = props.Data.movements.findIndex((movements: any) => movements.id === dataId.value);
        props.Data.movements.splice(indexs, 1);
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

// // 👉 Remove Product edit section
// const remove_movements = (id: any) => {
//   axios.get('/api/user/employees/deleteItems/' + id)
//     .then(response => {
//       if (response.data.success) {
//         console.log(response.data.message)
//         props.Data.movements.splice(props.Data.movements.id, 1)
//       }
//     })
// }
const gender = ref([{ item: '--Select Option--', value: null }, { item: 'Male', value: 'male' }, { item: 'Female', value: 'female' }])

</script>
<template>
  <VCard style="margin:2vh;">
    <VToolbar color="primary" title="Movement" />
      <VCard style="margin: 2vh;" >
        <VTable class="py-2 px-2">
          <!-- 👉 table head -->
          <thead>
            <tr>
              <th scope="col" class="text-center">
                From
              </th>
              <th scope="col" class="text-center">
                To
              </th>
              <th scope="col" class="text-center">
                Position
              </th>
              <th scope="col" class="text-center">
                Department / Account
              </th>

              <th scope="col" class="text-center">
                Employment Type
              </th>
              <th scope="col" class="text-center">
                Employment Status
              </th>
              <th scope="col" class="text-center">
                Position
              </th>
              <th scope="col" class="text-center">
                Department / Account
              </th>
              <th scope="col" class="text-center">
                Employment Type
              </th>

              <th scope="col" class="text-center">
                Employment Status
              </th>

              <th scope="col" class="text-center">
                Action For
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
          <tbody v-if="Data.movements.length > 0" >
            <tr v-for="(movements, index) in props.Data.movements" :key="movements">
              <td scope="col">
                <VTextField style="min-width: 160px;" v-model="movements.date_from" type="date" />
              </td>
              <VCol hidden>
                <VTextField v-model="movements.id" type="text" />
              </VCol>
              <td scope="col">
                <VTextField style="min-width: 160px;" v-model="movements.date_to" type="date" />
              </td>
              <td scope="col" width="5%">
                <VTextField style="min-width: 160px;" v-model="movements.from_position" type="text" />
              </td>
              <td scope="col">
                <VTextField style="min-width: 160px;" v-model="movements.from_department" type="text" />
              </td>

              <td scope="col">
                <VCol sm="3.5" md="3.5">
                  <VSelect style="min-width: 160px; width: auto;" v-model="movements.from_employment_type_id" :items="from_employmentTypes" item-title="item"
                    item-value="value" :menu-props="{ transition: 'scroll-y-transition' }" type="text" />
                </VCol>
              </td>
              <td scope="col">
                <VCol sm="3.5" md="3.5">
                  <VSelect style="min-width: 275px; width: auto;" v-model="movements.from_employment_status_id" :items="from_employmentStatus" item-title="item"
                    item-value="value" :menu-props="{ transition: 'scroll-y-transition' }" type="text" />
                </VCol>
              </td>

              <td scope="col" width="5%">
                <VTextField style="min-width: 160px; width: auto;" v-model="movements.to_position" type="text" />
              </td>
              <td scope="col">
                <VTextField style="min-width: 160px; width: auto;" v-model="movements.to_department" type="text" />
              </td>
              <td scope="col">
                <VCol sm="3.5" md="3.5">
                  <VSelect style="min-width: 160px; width: auto;" v-model="movements.to_employment_type_id" :items="to_employmentTypes" item-title="item"
                    item-value="value" :menu-props="{ transition: 'scroll-y-transition' }" type="text" />
                </VCol>
              </td>
              <td scope="col">
                <VCol sm="3.5" md="3.5">
                  <VSelect style="min-width: 275px; width: auto;" v-model="movements.to_employment_status_id" :items="to_employmentStatus" item-title="item"
                    item-value="value" :menu-props="{ transition: 'scroll-y-transition' }" type="text" />
                </VCol>
              </td>

              <td scope="col">
                <VTextField style="min-width: 160px; width: auto;" v-model="movements.action_for" type="text" />
              </td>
              <td scope="col">
                <VTextField style="min-width: 160px; width: auto;" v-model="movements.notes" type="text" />
              </td>

              <td scope="col" style="text-align: center;">
                <VBtn icon size="x-small" @click="openConfirmDialog(index,movements.id)" color="error" variant="text">
                  <VIcon size="22" icon="tabler-trash" />
                </VBtn>
              </td>
            </tr>
          </tbody>
        </VTable>
      </VCard>
    <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
      <VCol class="text-right clearfix">
        <VBtn @click.prevent="addMovements" style="font-size: 10px; padding: 12px; float: right">
          <VIcon start icon="tabler-plus" />Add Label
        </VBtn>
      </VCol>
    </VCardText>
  </VCard>

  <VDialog
  scrollable
  v-model="confirmDeletion"
  maxWidth="300"
  >
   <confirmDelete  :dataId="dataId" :dataIndex="dataIndex" :removeMovement="removeMovement" @close="confirmDeletion=false"/>
  </VDialog>
  
</template>
