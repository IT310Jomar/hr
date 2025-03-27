<script lang="ts" setup>
import confirmDelete from '../ConfrimDeletionDialog/confirmDeleteAssets.vue';
import { emailValidator, requiredValidator } from '@validators'
import axios from 'axios';
interface Props {
  Data: any
}

const id = ref([])
const condition = ref([])
const category = ref([])
const item = ref([])
const purchase_price = ref([])
const serial_no = ref([])
const date_acquired = ref([])
const date_used = ref([])
const date_returned = ref([])
const notes = ref([])
const props = defineProps<Props>()
const category_options = ref([{ item: '--Select Option--', value: null }])
const condition_options = ref([{ item: '--Select Option--', value: null }])

// 👉 Add item function
const addAssetItem = () => {
  props.Data.assets.push({
    id: id.value = [],
    category: category.value = [],
    condition: condition.value = [],
    item: item.value = [],
    purchase_price: purchase_price.value = [],
    serial_no: serial_no.value = [],
    date_acquired: date_acquired.value = [],
    date_returned: date_returned.value = [],
    date_used: date_used.value = [],
    notes: notes.value = [],
  })
}

onMounted(() => {
  getBenefit_types()
  for (var i = 0; i < props.Data.assets_list.length; i++) {
    props.Data.assets.push({
      id: id.value = props.Data.assets_list[i].id,
      category: category.value = props.Data.assets_list[i].category_id,
      condition: condition.value = props.Data.assets_list[i].condition_id,
      item: item.value = props.Data.assets_list[i].item,
      purchase_price: purchase_price.value = props.Data.assets_list[i].price,
      serial_no: serial_no.value = props.Data.assets_list[i].serial_number,
      date_acquired: date_acquired.value = props.Data.assets_list[i].date_acquired,
      date_returned: date_returned.value = props.Data.assets_list[i].date_returned,
      date_used: date_used.value = props.Data.assets_list[i].date_issued,
      notes: notes.value = props.Data.assets_list[i].notes,
    })
  }
})


// 👉 Remove edit section
const dataId = ref();
const dataIndex = ref();
const confirmDeletion = ref(false)


// 👉 Remove assets edit section
const removeAssets = (index: any, id: any) => {
  dataId.value = id
  dataIndex.value = index
  if(dataId.value != null && dataId.value == '') {
    const indexs = props.Data.assets.findIndex((assets: any) => assets.id === dataId.value);
    props.Data.assets.splice(indexs, 1);
  } else {
    axios.get('/api/user/employees/deleteItems/' + dataId.value)
    .then(response => {
    if (response.data.success) {
      if(response.data.deleteRow) {
        const indexs = props.Data.assets.findIndex((assets: any) => assets.id === dataId.value);
        props.Data.assets.splice(indexs, 1);
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
// const remove_asset = (id: any) => {
//   axios.get('/api/user/employees/deleteItems/' + id)
//     .then(response => {
//       if (response.data.success) {
//         console.log(response.data.message)
//         props.Data.assets.splice(props.Data.assets.id, 1)
//       }
//     })
// }

const getBenefit_types = () => {
  axios.get('/api/user/employees/getEmploymentOptions')
    .then(response => {
      if (response.data.success) {
        if (response.data.category) {
          for (var x = 0; x < response.data.category.length; x++) {
            category_options.value.push(
              {
                item: response.data.category[x].name,
                value: response.data.category[x].id,
              }
            )
          }
        }
        if (response.data.condition) {
          for (var i = 0; i < response.data.condition.length; i++) {
            condition_options.value.push(
              {
                item: response.data.condition[i].name,
                value: response.data.condition[i].id,
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
  <VCard style="margin:2vh;">
    <VToolbar color="primary" title="Assets" />
      <VCard style="margin: 2vh;">
        <VTable class="py-2 px-2">
          <!-- 👉 table head -->
          <thead>
            <tr>
              <th class="text-center" scope="col">
                Item
              </th>
              <th class="text-center" scope="col">
                Category
              </th>
              <th class="text-center" scope="col">
                Condition
              </th>
              <th class="text-center" scope="col">
                Purchase Price
              </th>
              <th class="text-center" scope="col">
                Serial Number
              </th>
              <th class="text-center" scope="col">
                Acquired Date
              </th>
              <th class="text-center" scope="col">
                Date Issued
              </th>
              <th class="text-center" scope="col">
                Date Returned
              </th>
              <th class="text-center" scope="col">
                Notes
              </th>
              <th class="text-center" scope="col">
                Actions
              </th>
            </tr>
          </thead>
          <!-- 👉 table body -->
          <tbody v-if="Data.assets.length > 0">
            <tr v-for="(assets, index) in props.Data.assets" :key="assets">
              <td scope="col" style="width:13vw">
                <VCol sm="3.5" md="3.5" hidden>
                  <VTextField v-model="assets.id" type="text" />
                </VCol>
                <VTextField :rules="[requiredValidator]" style="min-width: 150px; width: auto;" v-model="assets.item" type="text" />
              </td>
              <td scope="col" style="width:13vw">

                <VSelect :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="assets.category" :items="category_options" item-title="item" item-value="value"
                  :menu-props="{ transition: 'scroll-y-transition' }" type="text" />

              </td>
              <td scope="col" style="width:13vw">

                <VSelect :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="assets.condition" :items="condition_options" item-title="item" item-value="value"
                  :menu-props="{ transition: 'scroll-y-transition' }" type="text" />

              </td>
              <td scope="col" style="width:13vw">

                <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="assets.purchase_price" type="text" />

              </td>
              <td scope="col" style="width:13vw">

                <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="assets.serial_no" type="text" />

              </td>
              <td scope="col" style="width:13vw">

                <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="assets.date_acquired" type="date" />

              </td>
              <td scope="col" style="width:13vw">

                <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="assets.date_used" type="date" />

              </td>
              <td scope="col" style="width:13vw">

                <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="assets.date_returned" type="date" />

              </td>
              <td scope="col" style="width:13vw">

                <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="assets.notes" type="text" />

              </td>
              <td scope="col">
                <VBtn icon size="x-small" @click="openConfirmDialog(index,assets.id)" color="error" variant="text">
                  <VIcon size="22" icon="tabler-trash" />
                </VBtn>
              </td>
            </tr>
          </tbody>
        </VTable>
      </VCard>
    <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
      <VCol class="text-right clearfix">
        <VBtn @click.prevent="addAssetItem" style="font-size: 10px; padding: 12px; float: right">
          <VIcon start icon="tabler-plus" />Add Assets
        </VBtn>
      </VCol>
    </VCardText>
  </VCard>

  <VDialog
  scrollable
  v-model="confirmDeletion"
  maxWidth="300"
  >
   <confirmDelete  :dataId="dataId" :dataIndex="dataIndex" :removeAssets="removeAssets" @close="confirmDeletion=false"/>
  </VDialog>

</template>
