<script setup lang="ts">
import {ref, onMounted, watch } from 'vue';
import { VForm } from 'vuetify/components'
import { toast } from 'vue3-toastify';
import axios from 'axios';
import { environment } from '@/environments/environment';
import { inject } from 'vue'

const childFunction = inject('childFunction') 

interface Props {
  privilageData: any
  onUpdateData: Function
  dataBasicInfo: any
  level_id: any
}
const props = defineProps<Props>()

const basicInfo = ref()
const workInfo = ref()
const govInfo = ref()
const accessInfo = ref()
const uploadInfo = ref()
const educ = ref([])
const pm = ref([])
const contact =ref([])
const dependent = ref([])
const benefit = ref([])
const leave = ref([])
const salary = ref([])
const advance = ref([])
const asset = ref([])
const memo = ref([])

const seminar = ref([])
const empRec = ref([])
const movement = ref([])
const medRec = ref([])
const requirements = ref([])
const scheduleInfo = ref([])
const docs = ref([])

const selectedEduc = ref([{title: 'View', value: 'view'}, { title: 'Edit', value: 'edit'},{ title: 'Add', value: 'add'},{ title: 'Delete', value: 'delete'}])
const selectedPM = ref([{title: 'View', value: 'view'}, { title: 'Edit', value: 'edit'},{ title: 'Add', value: 'add'},{ title: 'Delete', value: 'delete'}])
const selectedContact = ref([{title: 'View', value: 'view'}, { title: 'Edit', value: 'edit'},{ title: 'Add', value: 'add'},{ title: 'Delete', value: 'delete'}])
const selectedDependent = ref([{title: 'View', value: 'view'}, { title: 'Edit', value: 'edit'},{ title: 'Add', value: 'add'},{ title: 'Delete', value: 'delete'}])
const selectedBenefit = ref([{title: 'View', value: 'view'}, { title: 'Edit', value: 'edit'},{ title: 'Add', value: 'add'},{ title: 'Delete', value: 'delete'}])
const selectedLeave = ref([{title: 'View', value: 'view'}, { title: 'Edit', value: 'edit'},{ title: 'Add', value: 'add'},{ title: 'Delete', value: 'delete'}])
const selectedSalary = ref([{title: 'View', value: 'view'}, { title: 'Edit', value: 'edit'},{ title: 'Add', value: 'add'},{ title: 'Delete', value: 'delete'}])
const selectedAdvance = ref([{title: 'View', value: 'view'}, { title: 'Edit', value: 'edit'},{ title: 'Add', value: 'add'},{ title: 'Delete', value: 'delete'}])
const selectedAsset = ref([{title: 'View', value: 'view'}, { title: 'Edit', value: 'edit'},{ title: 'Add', value: 'add'},{ title: 'Delete', value: 'delete'}])
const selectedMemo = ref([{title: 'View', value: 'view'}, { title: 'Edit', value: 'edit'},{ title: 'Add', value: 'add'},{ title: 'Delete', value: 'delete'}])
const selectedSeminar = ref([{title: 'View', value: 'view'}, { title: 'Edit', value: 'edit'},{ title: 'Add', value: 'add'},{ title: 'Delete', value: 'delete'}])
const selectedempRec = ref([{title: 'View', value: 'view'}, { title: 'Edit', value: 'edit'},{ title: 'Add', value: 'add'},{ title: 'Delete', value: 'delete'}])
const selectedMovement = ref([{title: 'View', value: 'view'}, { title: 'Edit', value: 'edit'},{ title: 'Add', value: 'add'},{ title: 'Delete', value: 'delete'}])
const selectedmedRec = ref([{title: 'View', value: 'view'}, { title: 'Edit', value: 'edit'},{ title: 'Add', value: 'add'},{ title: 'Delete', value: 'delete'}])
const selectedRequirements = ref([{title: 'View', value: 'view'}, { title: 'Edit', value: 'edit'},{ title: 'Add', value: 'add'},{ title: 'Delete', value: 'delete'}])
const selectedscheduleInfo = ref([{title: 'View', value: 'view'}, { title: 'Edit', value: 'edit'},{ title: 'Add', value: 'add'},{ title: 'Delete', value: 'delete'}])
const selectedDocs = ref([{title: 'View', value: 'view'}, { title: 'Edit', value: 'edit'},{ title: 'Add', value: 'add'},{ title: 'Delete', value: 'delete'}])

const refAccess = ref<VForm>();
const emit = defineEmits(['AccessLevel'])
const levelId = ref(props.level_id);
const isSelected = computed(() => levelId.value);

watch([basicInfo,workInfo,govInfo,accessInfo,uploadInfo,educ,pm,contact,dependent,benefit,leave,salary,advance,asset,memo,seminar,empRec,movement,medRec,requirements,scheduleInfo,docs],([uploadInfovalue, basicInfovalue, workInfovalue, govInfovalue, accessInfovalue, educvalue,pmvalue,contactvalue,dependentvalue,benefitvalue,leavevalue,salaryvalue,advancevalue,assetvalue,memovalue,seminarvalue,empRecvalue,movementvalue,medRecvalue,requirementsvalue,scheduleInfovalue,docsvalue]) => {  
  emit('AccessLevel', basicInfovalue, workInfovalue, govInfovalue, accessInfovalue, uploadInfovalue, educvalue,pmvalue,contactvalue,dependentvalue,benefitvalue,leavevalue,salaryvalue,advancevalue,assetvalue,memovalue,seminarvalue,empRecvalue,movementvalue,medRecvalue,requirementsvalue,scheduleInfovalue,docsvalue)
})

// const onUpdate = () => {
//   console.log(props.privilageData)
//   basicInfo.value = props.privilageData[0]
// }

// watch(props.dataBasicInfo, () => {
//   basicInfo.value = props.dataBasicInfo[0]
//   console.log(basicInfo.value)
//   // console.log('dsadsa')
// })

// const masterDeo = () => {
//   console.log('hi')
 
// }


// const level_id = 'viewonly';

// const isLevelIdMatch = computed(() => basicInfo.value === level_id);

onMounted( () => { 
  // console.log(props.level_id)
})


// watch(props.privilageData,(nval) => {
//   if(nval) {
//     basicInfo.value = props.privilageData[0]
//   }
// })

// const isSelected = computed(() => {
//   return basicInfo.value === levelId.value;
// });

</script>

<template>
  <VTable class="px-10 mb-10" style="margin-top: 2%;">
    <!-- <thead>
      <tr>
        <th></th>
        <th></th>
      </tr>
    </thead> -->
    <tbody>
      <tr>
        <td>Basic Information</td>
        <td>
          <v-radio-group v-model="basicInfo" v-for="data in level_id">
            <v-radio label="View Only" value="viewonly"></v-radio>
            <v-radio class="pb-3" label="Editor" value="editor"></v-radio>
          </v-radio-group>
        </td>
      </tr>
      <tr>
        <td>Work Information</td>
        <td>
          <v-radio-group v-model="workInfo">
            <v-radio label="No Access" value="noaccess"></v-radio>
            <v-radio label="View Only" value="viewonly"></v-radio>
            <v-radio class="pb-3" label="Editor" value="editor"></v-radio>
          </v-radio-group>
        </td>
      </tr>
      <tr>
        <td>Government Information</td>
        <td>
          <v-radio-group v-model="govInfo">
            <v-radio label="No Access" value="noaccess"></v-radio>
            <v-radio label="View Only" value="viewonly"></v-radio>
            <v-radio class="pb-3" label="Editor" value="editor"></v-radio>
          </v-radio-group>
        </td>
      </tr>
      <tr>
        <td>Access Level</td>
        <td>
          <v-radio-group v-model="accessInfo">
            <v-radio label="View Only" value="viewonly"></v-radio>
            <v-radio class="pb-3" label="Editor" value="editor"></v-radio>
          </v-radio-group>
        </td>
      </tr>
      <tr>
        <td>Upload Pictures</td>
        <td>
          <v-radio-group v-model="uploadInfo">
            <v-radio label="View Only" value="viewonly"></v-radio>
            <v-radio class="pb-3" label="Allowed to Upload" value="allowedtoupload"></v-radio>
          </v-radio-group>
        </td>
      </tr>
      <tr>
        <td>Educational Information</td>
        <td>
            <v-checkbox v-model="educ" v-for="data in selectedEduc" :key="data.value" :value="data.value" :label="data.title" ></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Performance Management</td>
        <td>
          <v-checkbox v-model="pm" v-for="data in selectedPM" :key="data.value" :value="data.value" :label="data.title"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Contact Information</td>
        <td>
          <v-checkbox v-model="contact" v-for="data in selectedContact" :key="data.value" :value="data.value" :label="data.title"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Dependent</td>
        <td>
          <v-checkbox v-model="dependent" v-for="data in selectedDependent" :key="data.value" :value="data.value" :label="data.title"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Benefits</td>
        <td>
          <v-checkbox v-model="benefit" v-for="data in selectedBenefit" :key="data.value" :value="data.value" :label="data.title"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Leave</td>
        <td>
          <v-checkbox v-model="leave" v-for="data in selectedLeave" :key="data.value" :value="data.value" :label="data.title"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Salary</td>
        <td>
          <v-checkbox v-model="salary" v-for="data in selectedSalary" :key="data.value" :value="data.value" :label="data.title"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Advances</td>
        <td>
          <v-checkbox v-model="advance" v-for="data in selectedAdvance" :key="data.value" :value="data.value" :label="data.title"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Assets</td>
        <td>
          <v-checkbox v-model="asset" v-for="data in selectedAsset" :key="data.value" :value="data.value" :label="data.title"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Memo</td>
        <td>
          <v-checkbox v-model="memo" v-for="data in selectedMemo" :key="data.value" :value="data.value" :label="data.title"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Seminars</td>
        <td>
          <v-checkbox v-model="seminar" v-for="data in selectedSeminar" :key="data.value" :value="data.value" :label="data.title"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Employment Record</td>
        <td>
          <v-checkbox v-model="empRec" v-for="data in selectedempRec" :key="data.value" :value="data.value" :label="data.title"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Movement</td>
        <td>
          <v-checkbox v-model="movement" v-for="data in selectedMovement" :key="data.value" :value="data.value" :label="data.title"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Medical Records</td>
        <td>
          <v-checkbox v-model="medRec" v-for="data in selectedmedRec" :key="data.value" :value="data.value" :label="data.title"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Requirements</td>
        <td>
          <v-checkbox v-model="requirements" v-for="data in selectedRequirements" :key="data.value" :value="data.value" :label="data.title"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Work Schedule Information</td>
        <td>
          <v-checkbox v-model="scheduleInfo" v-for="data in selectedscheduleInfo" :key="data.value" :value="data.value" :label="data.title"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Documents</td>
        <td>
          <v-checkbox v-model="docs" v-for="data in selectedDocs" :key="data.value" :value="data.value" :label="data.title"></v-checkbox>
        </td>
      </tr>

    </tbody>
  </VTable>
</template>

<style>
  table {
    border-collapse: collapse;
    border: 1px solid #dee2e6;
  }
  th, td {
    border: 1px solid #dee2e6;
    padding: 8px;
    text-align: left;
  }
</style>
