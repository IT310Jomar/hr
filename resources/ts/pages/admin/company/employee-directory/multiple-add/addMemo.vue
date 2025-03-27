<script setup lang="ts">
import axios from 'axios';
import { emailValidator, requiredValidator } from '@validators'
import confirmDelete from '../ConfrimDeletionDialog/confirmDeleteMemo.vue';

const props = defineProps<Props>();

interface Props {
  Data: any
  allMemoData: any
}

// 👉 v-models (memo)
const offense_level = ref()
const da_type = ref()
const violation_category = ref()
const served_recieved_date = ref()
const slide_date = ref()
const notes = ref()
const id = ref()


const offense = ref([{ item: '--Select Offense Level--', value: null }])
const daTypes = ref([{ item: '--Select DaTypes--', value: null }])


//function for getting the data from database (offense_level table)
const getOffense = () => {
  axios.get('/api/user/employees/getEmploymentOptions')
    .then((response) => {
      if (response.data.success) {
        for (var x = 0; x < response.data.offense.length; x++) {
          offense.value.push(
            {
              item: response.data.offense[x].name,
              value: response.data.offense[x].id,
            }
          )
        }
      }
    }).catch((error) => {
      // console.log(error)
    })
}

//function for getting the data from database (da_types table)
const getDaTypes = () => {
  axios.get('/api/user/employees/getEmploymentOptions')
    .then((response) => {
      if (response.data.success) {
        for (var x = 0; x < response.data.daTypes.length; x++) {
          daTypes.value.push(
            {
              item: response.data.daTypes[x].name,
              value: response.data.daTypes[x].id,
            }
          )
        }
        //  console.log(daTypes.value)
      }
    }).catch((error) => {
      // console.log(error)
    })
}

const initializeData = () => {
  getOffense()
  getDaTypes()
}

// 👉 Remove edit section
const dataId = ref();
const dataIndex = ref();
const confirmDeletion = ref(false)


// 👉 Remove memo edit section
const removeMemo = (index: any, id: any) => {
  dataId.value = id
  dataIndex.value = index
  if (dataId.value != null && dataId.value == '') {
    const indexs = props.Data.memo.findIndex((memo: any) => memo.id === dataId.value);
    props.Data.memo.splice(indexs, 1);
  } else {
    axios.get('/api/user/employees/deleteItems/' + dataId.value)
      .then(response => {
        if (response.data.success) {
          if (response.data.deleteRow) {
            const indexs = props.Data.memo.findIndex((memo: any) => memo.id === dataId.value);
            props.Data.memo.splice(indexs, 1);
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


const addMemo = () => {
  props.Data.memo.push({
    id: id.value = [],
    offense_level: offense_level.value = [],
    da_type: da_type.value = [],
    violation_category: violation_category.value = [],
    served_recieved_date: served_recieved_date.value = [],
    slide_date: slide_date.value = [],
    notes: notes.value = []
  })
}
onMounted(() => {
  initializeData();
  if (props.Data.allMemoData != null) {
    for (var z = 0; z < props.Data.allMemoData.length; z++) {
      props.Data.memo.push({
        id: id.value = props.Data.allMemoData[z].id,
        offense_level: offense_level.value = props.Data.allMemoData[z].offense_level,
        da_type: da_type.value = props.Data.allMemoData[z].da_types,
        violation_category: violation_category.value = props.Data.allMemoData[z].memo_subject,
        served_recieved_date: served_recieved_date.value = props.Data.allMemoData[z].memo_date,
        slide_date: slide_date.value = props.Data.allMemoData[z].slide_date,
        notes: notes.value = props.Data.allMemoData[z].memo_note
      })
    }

  }
});

</script>

<template>
  <VCard style="margin:2vh;">
    <VToolbar color="primary" title="Memo" />
      <VCard style="margin: 2vh;">
        <VTable class="py-2 px-2">
          <!-- 👉 table head -->
          <thead>
            <tr>
              <th class="text-center" scope="col">
                Offensive Level
              </th>
              <th class="text-center" scope="col">
                DA Type
              </th>
              <th class="text-center" scope="col">
                Infraction / Violation Category
              </th>
              <th class="text-center" scope="col">
                Date Served & Received
              </th>
              <th class="text-center" scope="col">
                Slide Date
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
          <tbody v-if="props.Data.memo.length > 0">
            <tr v-for="(memo, index) in props.Data.memo" :key="memo.id">
              <td scope="col">
                <VCol hidden>
                  <VTextField v-model="memo.id" type="number"></VTextField>
                </VCol>
                <VCol>
                  <VRow>
                    <VSelect :rules="[requiredValidator]" style="min-width: 200px; width: auto;" :items="offense" item-title="item" item-value="value" v-model="memo.offense_level"
                      label="Offense Level" />
                  </VRow>
                </VCol>
              </td>
              <td scope="col" width="auto">
                <VCol>
                  <VSelect :rules="[requiredValidator]" style="min-width: 250px; width: auto;" :items="daTypes" item-title="item" item-value="value" v-model="memo.da_type" label="DA Type" />
                </VCol>
              </td>
              <td scope="col">
                <VCol>
                  <VTextField :rules="[requiredValidator]" style="min-width: 280px; width: auto;" v-model="memo.violation_category" label="Infraction / Violation Category"></VTextField>
                </VCol>
              </td>
              <td>
                <VCol>
                  <VTextField :rules="[requiredValidator]" style="min-width: 160px; width: auto;" v-model="memo.served_recieved_date" type="date"></VTextField>
                </VCol>
              </td>
              <td scope="col">
                <VCol>
                  <VTextField :rules="[requiredValidator]" style="min-width: 160px; width: auto;" v-model="memo.slide_date" type="date"></VTextField>
                </VCol>
              </td>
              <td scope="col">
                <VCol>
                  <VTextField style="min-width: 200px; width: auto;" v-model="memo.notes" label="Notes"></VTextField>
                </VCol>
              </td>
              <td scope="col" class="text-center">
                <VBtn @click="openConfirmDialog(index, memo.id)" color="error" variant="text">
                  <VIcon size="22" icon="tabler-trash" />
                </VBtn>
              </td>
            </tr>
          </tbody>
        </VTable>
      </VCard>
    <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
      <VCol class="text-right clearfix">
        <VBtn @click.prevent="addMemo" style="font-size: 10px; padding: 12px; float: right">
          <VIcon start icon="tabler-plus" />Add Memo
        </VBtn>
      </VCol>
    </VCardText>
  </VCard>

  <VDialog scrollable v-model="confirmDeletion" maxWidth="300">
    <confirmDelete :dataId="dataId" :dataIndex="dataIndex" :removeMemo="removeMemo" @close="confirmDeletion = false" />
  </VDialog>

</template>
