<script lang="ts" setup>
import confirmDelete from '../ConfrimDeletionDialog/confirmDeleteBenefits.vue';
import { emailValidator, requiredValidator } from '@validators'

import axios from 'axios';
interface Props {
  Data: any
}

const benefit = ref([])
const active_status = ref([])
const effective_date = ref([])
const enrollment_date = ref([])
const plan = ref([])
const beneficiary = ref([])
const notes = ref([])
const payment_type = ref([])
const id = ref([])
const props = defineProps<Props>()
const benefit_types = ref([{ item: '--Select Option--', value: null }])
const payment_types = ref([
  { item: '--Select Option--', value: null },
  { item: 'N/A', value: 'na' },
  { item: 'Salary', value: 'salary' },
  { item: 'Shouldered', value: 'shouldered' },
])

// 👉 Add item function
const addBenefitItem = () => {
  props.Data.benefits.push({
    benefit: benefit.value = [],
    active_status: active_status.value = [],
    effective_date: effective_date.value = [],
    enrollment_date: enrollment_date.value = [],
    plan: plan.value = [],
    beneficiary: beneficiary.value = [],
    notes: notes.value = [],
    payment_type: payment_type.value = [],
    id: id.value = [],
  })
}

onMounted(() => {
  getBenefit_types()
  for (var i = 0; i < props.Data.benefit_list.length; i++) {
    // console.log(active_status.value = props.Data.benefit_list[i].active)
    props.Data.benefits.push({
      benefit: benefit.value = props.Data.benefit_list[i].benefit_type_id,
      active_status: active_status.value = props.Data.benefit_list[i].active,
      effective_date: effective_date.value = props.Data.benefit_list[i].effective_date,
      enrollment_date: enrollment_date.value = props.Data.benefit_list[i].enrollment_date,
      plan: plan.value = props.Data.benefit_list[i].plan,
      beneficiary: beneficiary.value = props.Data.benefit_list[i].beneficiary,
      notes: notes.value = props.Data.benefit_list[i].notes,
      payment_type: payment_type.value = props.Data.benefit_list[i].payment_type,
      id: id.value = props.Data.benefit_list[i].id,
    })
  }
})

// 👉 Remove edit section
const dataId = ref();
const dataIndex = ref();
const confirmDeletion = ref(false)

// 👉 Remove BANKS edit section
const removeBenefits = (index: any, id: any) => {
  dataId.value = id
  dataIndex.value = index
  if(dataId.value != null && dataId.value == '') {
    const indexs = props.Data.benefits.findIndex((benefits: any) => benefits.id === dataId.value);
    props.Data.benefits.splice(indexs, 1);
  } else {
    axios.get('/api/user/employees/deleteItems/' + dataId.value)
    .then(response => {
    if (response.data.success) {
      if(response.data.deleteRow) {
        const indexs = props.Data.benefits.findIndex((benefits: any) => benefits.id === dataId.value);
        props.Data.benefits.splice(indexs, 1);
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

const getBenefit_types = () => {
  axios.get('/api/user/employees/getEmploymentOptions')
    .then(response => {
      if (response.data.success) {
        if (response.data.benefit_types) {
          for (var x = 0; x < response.data.benefit_types.length; x++) {
            benefit_types.value.push(
              {
                item: response.data.benefit_types[x].name,
                value: response.data.benefit_types[x].id,
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
    <VToolbar color="primary" title="Benefits" />
      <VCard style="margin: 2vh;" >
        <VTable class="py-2 px-2">
          <!-- 👉 table head -->
          <thead>
            <tr>
              <th class="text-center" scope="col">
                Type
              </th>
              <th class="text-center" scope="col">
                Active
              </th>
              <th class="text-center" scope="col">
                Effective Date
              </th>
              <th class="text-center" scope="col">
                Enrollment Date
              </th>
              <th class="text-center" scope="col">
                Plan
              </th>
              <th class="text-center" scope="col">
                Beneficiary
              </th>
              <th class="text-center" scope="col">
                Notes
              </th>
              <th class="text-center" scope="col">
                Payment Type
              </th>
              <th class="text-center" scope="col">
                Actions
              </th>
            </tr>
          </thead>
          <!-- 👉 table body -->
          <tbody v-if="Data.benefits.length > 0">
            <tr v-for="(benefits, index) in props.Data.benefits" :key="benefits">
              <td scope="col" width="auto">
                <VSelect style="min-width: 200px; width: auto;" v-model="benefits.benefit" :items="benefit_types" item-title="item" item-value="value"
                 type="text" />
              </td>

              <td scope="col" style="width:13vw" hidden>
                <VTextField v-model="benefits.id" type="text" />
              </td>

              <td scope="col" class="text-center">
                <VCheckbox v-model="benefits.active_status" v-bind:true-value="1" />
              </td>

              <td scope="col" style="width:13vw">
                <VTextField :rules="[requiredValidator]" style="min-width: 160px; width: auto;" v-model="benefits.effective_date" type="date" />
              </td>

              <td scope="col" style="width:13vw">
                <VTextField :rules="[requiredValidator]" style="min-width: 160px; width: auto;" v-model="benefits.enrollment_date" type="date" />
              </td>

              <td scope="col" style="width:13vw">
                <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="benefits.plan" type="text" />
              </td>

              <td scope="col" style="width:13vw">
                <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="benefits.beneficiary" type="text" />
              </td>

              <td scope="col" style="width:13vw">
                <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="benefits.notes" type="text" />
              </td>

              <td scope="col" width="auto">
                <VSelect :rules="[requiredValidator]" style="min-width: 180px; width: auto;" v-model="benefits.payment_type" :items="payment_types" item-title="item" item-value="value"
                 type="text" />
              </td>
              <td scope="col" class="text-center">
                <VBtn icon size="x-small" @click="openConfirmDialog(index,benefits.id)" color="error" variant="text">
                  <VIcon size="22" icon="tabler-trash" />
                </VBtn>
              </td>
            </tr>
          </tbody>
        </VTable>
      </VCard>
    <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
      <VCol class="text-right clearfix">
        <VBtn @click.prevent="addBenefitItem" style="font-size: 10px; padding: 12px; float: right">
          <VIcon start icon="tabler-plus" />Add Benifits
        </VBtn>
      </VCol>
    </VCardText>
  </VCard>

  <VDialog
  scrollable
  v-model="confirmDeletion"
  maxWidth="300"
  >
   <confirmDelete  :dataId="dataId" :dataIndex="dataIndex" :removeBenefits="removeBenefits" @close="confirmDeletion=false"/>
  </VDialog>

</template>
