<script lang="ts" setup>
import confirmDelete from '../ConfrimDeletionDialog/confirmDelete.vue';
import confirmDeleteAlternate from '../ConfrimDeletionDialog/confirmDeleteAlternate.vue';
import confirmDeleteEmail from '../ConfrimDeletionDialog/confirmDeleteEmail.vue';

import { emailValidator, requiredValidator } from '@validators'
import axios from 'axios';


// 👉emergency contact v-model
const emergency_address = ref()
const emergency_contact_person = ref()
const emergency_phone_no = ref()
const emergency_relationship = ref()
const confirmDeletion = ref(false)
const confirmDeletionAlternate = ref(false)
const confirmDeletionEmail = ref(false) 
const id = ref()

// 👉 contacts  v-model
const skype_id = ref();
const pin = ref()
const local_trunk_line = ref()
const e_id = ref()

// 👉 alternate contacts v-model
const alternate_phone_title = ref();
const alternate_contact_person = ref()
const alternate_phone_number = ref()

//👉 alternate email v-model
const email = ref()
const primary = ref()
const user_id = ref()

const emit = defineEmits(['formDataChanged']);
const props = defineProps<Props>()

  interface Props {
  Data: any
}

// 👉 Add item function
const alternate_addItem = () => {
  props.Data.alternate_phone_no.push({
    id: id.value = [],
    alternate_phone_title: alternate_phone_title.value = [],
    alternate_contact_person: alternate_contact_person.value = [],
    alternate_phone_number: alternate_phone_number.value = []
  })
}

const addEmail = () => {
  props.Data.emails.push({
    id: id.value = '',
    user_id: user_id.value = '',
    email: email.value = '',
    primary: primary.value = ''
  })
}
const emergency_addItem = () => {
  props.Data.emergency_contacts.push({
    id: id.value = [],
    emergency_address: emergency_address.value = [],
    emergency_contact_person: emergency_contact_person.value = [],
    emergency_phone_no: emergency_phone_no.value = [],
    emergency_relationship: emergency_relationship.value = []
  })
}

onMounted(() => {
  emergencyContacts()
  //👉 DISPLAY THE DATA IN TEXT-FIELD IF DATA IS AVAILABLE IN DATABASE (contacts table)
  if (props.Data.contactData != null) {
    e_id: e_id.value = props.Data.contactData.id
    skype_id: skype_id.value = props.Data.contactData.skype_id
    local_trunk_line: local_trunk_line.value = props.Data.contactData.local_trunk_line
    pin: pin.value = props.Data.contactData.pin
  }

    //👉 DISPLAY THE DATA IN TEXT-FIELD IF DATA IS AVAILABLE IN DATABASE (employee_alternate_phone_numbers table)
    if (props.Data.alternateContacts != null) {
      for (var j = 0; j < props.Data.alternateContacts.length; j++) {
        props.Data.alternate_phone_no.push({
          id: id.value = props.Data.alternateContacts[j].id,
          alternate_phone_title: alternate_phone_title.value = props.Data.alternateContacts[j].title_id,
          alternate_contact_person: alternate_contact_person.value = props.Data.alternateContacts[j].contact_person,
          alternate_phone_number: alternate_phone_number.value = props.Data.alternateContacts[j].phone_number
        })
      }
    }
    //👉 DISPLAY THE DATA IN TEXT-FIELD IF DATA IS AVAILABLE IN DATABASE (emails table)
    if (props.Data.alternateEmail != null) {
      for (var u = 0; u < props.Data.alternateEmail.length; u++) {
        props.Data.emails.push({
          id: id.value = props.Data.alternateEmail[u].id,
          user_id: user_id.value = props.Data.alternateEmail[u].user_id,
          email: email.value = props.Data.alternateEmail[u].email,
          primary: primary.value = props.Data.alternateEmail[u].primary
        })
      }
    }

})
const emergencyContacts = () => {
 //👉 DISPLAY THE DATA IN TEXT-FIELD IF DATA IS AVAILABLE IN DATABASE (emergency_contacts table)
 if (props.Data.emergencyContacts != null) {
    for (var e = 0; e < props.Data.emergencyContacts.length; e++) {
      props.Data.emergency_contacts.push({
        id: id.value = props.Data.emergencyContacts[e].id,
        emergency_phone_no: emergency_phone_no.value = props.Data.emergencyContacts[e].phone,
        emergency_contact_person: emergency_contact_person.value = props.Data.emergencyContacts[e].name,
        emergency_relationship: emergency_relationship.value = props.Data.emergencyContacts[e].relationship,
        emergency_address: emergency_address.value = props.Data.emergencyContacts[e].address,
      })
    }
  }
}

// 👉 Remove edit section
const dataId = ref();
const dataIndex = ref();

// 👉 Remove EMERGENCY CONTACT edit section
const removeNumber = (index: any, id: any) => {
  dataId.value = id
  dataIndex.value = index
  if(dataId.value != null && dataId.value == '') {
    const indexs = props.Data.emergency_contacts.findIndex((emergency_contacts: any) => emergency_contacts.id === dataId.value);
    props.Data.emergency_contacts.splice(indexs, 1);
  } else {
    axios.get('/api/user/employees/deleteItems/' + dataId.value)
    .then(response => {
    if (response.data.success) {
      if(response.data.deleteRow) {
        const indexs = props.Data.emergency_contacts.findIndex((emergency_contacts: any) => emergency_contacts.id === dataId.value);
        props.Data.emergency_contacts.splice(indexs, 1);
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



//ALTERNATIVE PHONE NUMBER
const removePhoneNumber = (index: any, id: any) => {
  dataId.value = id
  dataIndex.value = index
  if(dataId.value != null && dataId.value == '') {
    const indexs = props.Data.alternate_phone_no.findIndex((alternate_phone_no: any) => alternate_phone_no.id === dataId.value);
    props.Data.alternate_phone_no.splice(indexs, 1);
  } else {
    axios.get('/api/user/employees/deleteItems/' + dataId.value)
    .then(response => {
    if (response.data.success) {
      if(response.data.deleteRow) {
        const indexs = props.Data.alternate_phone_no.findIndex((alternate_phone_no: any) => alternate_phone_no.id === dataId.value);
        props.Data.alternate_phone_no.splice(indexs, 1);
      }
    }
  })
  }
}

const openConfirmDialogPhoneNumber = (index: any, id: any) => {
  confirmDeletionAlternate.value = true
  dataId.value = id
  dataIndex.value = index
}


//EMPLOYEE EMAIL PRIMARY
const removeEmail = (index: any, id: any) => {
  dataId.value = id
  dataIndex.value = index
  if(dataId.value != null && dataId.value == '') {
    const indexs = props.Data.emails.findIndex((emails: any) => emails.id === dataId.value);
    props.Data.emails.splice(indexs, 1);
  } else {
    axios.get('/api/user/employees/deleteItems/' + dataId.value)
    .then(response => {
    if (response.data.success) {
      if(response.data.deleteRow) {
        const indexs = props.Data.emails.findIndex((emails: any) => emails.id === dataId.value);
        props.Data.emails.splice(indexs, 1);
      }
    }
  })
  }
}

const openConfirmDialogEmail = (index: any, id: any) => {
  confirmDeletionEmail.value = true
  dataId.value = id
  dataIndex.value = index
}

// 👉 WATCH THE INPUTTED VALUE OF USERS IN FORM AND SEND IT TO PARENT COMPONENT
watch([local_trunk_line, pin, skype_id, e_id], ([localTrunkLineValue, pinValue, skypeIdValue, idValue]) => {
  // Emit form data to parent component
  emit('formDataChanged', {
    local_trunk_line: localTrunkLineValue,
    pin: pinValue,
    skype_id: skypeIdValue,
    e_id: idValue,

  })
})
// 👉 FUNCTION FOR UNCHECKED THE CHECKED CHECKBOX IF OTHER CHECKBOX IS BEING CHECKED
const onChange = (data: any) => {
  props.Data.emails = []
  for (var u = 0; u < props.Data.alternateEmail.length; u++) {
    props.Data.emails.push({
      id: id.value = props.Data.alternateEmail[u].id,
      user_id: user_id.value = props.Data.alternateEmail[u].user_id,
      email: email.value = props.Data.alternateEmail[u].email,
      primary: data.id == props.Data.alternateEmail[u].id ? primary.value = 1 : 0
    })
  }

}

</script>

<template>
  <!-- Contact Information -->
  <VCard style="margin:2vh;">
    <VToolbar color="primary" title="Contact Information" />
    <VCardText>
      <VRow>
        <VCol>
          <VTextField :rules="[requiredValidator]" type="text" label="Local Trunk Line" v-model="local_trunk_line" />
        </VCol>
      </VRow>

      <VRow>
        <VCol>
          <VTextField :rules="[requiredValidator]" type="text" label="PIN" v-model="pin" />
        </VCol>
      </VRow>

      <VRow>
        <VCol>
          <VTextField :rules="[requiredValidator]" type="text" label="Skype ID" v-model="skype_id" />
        </VCol>
      </VRow>
    </VCardText>
    <!--- Emergency Contact Number ---->
    <VToolbar color="primary" title="Emergency Contact Number" />
    <VCardText class="d-flex justify-end flex-wrap gap-3 py-1 ">
      <VCol class="text-right clearfix">
        <VBtn @click.prevent="emergency_addItem" style="font-size: 10px; padding: 12px; float: right">
          <VIcon start icon="tabler-plus" />Add New Number
        </VBtn>
      </VCol>
    </VCardText>
      <VCard>
        <VTable class="px-2 py-2">
          <thead>
            <tr>
              <th class="text-center" scope="col">
                Phone No
              </th>
              <th class="text-center" scope="col">
                Contact Person
              </th>
              <th class="text-center" scope="col">
                Relationship
              </th>
              <th class="text-center" scope="col">
                Address
              </th>
              <th class="text-center" scope="col">
                Actions
              </th>
            </tr>
          </thead>
          <!-- 👉 table body -->
          <tbody v-if="Data.emergency_contacts.length > 0" >
          <tr v-for="(emergency_contacts, index) in props.Data.emergency_contacts" :key="emergency_contacts.index">
            <td scope="col" width="auto">
              <VCol hidden>
                <VTextField v-model="emergency_contacts.id" type="number" />
              </VCol>
              <VCol sm="3.5" md="3.5">
                <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="emergency_contacts.emergency_phone_no" type="number" />
              </VCol>
            </td>
            <td scope="col" width="auto">
              <VCol sm="3.5" md="3.5">
                <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="emergency_contacts.emergency_contact_person" type="text" />
              </VCol>
            </td>
            <td scope="col" width="auto">
              <VCol sm="3.5" md="3.5">
                <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="emergency_contacts.emergency_relationship" type="text" />
              </VCol>
            </td>
            <td scope="col" width="auto">
              <VCol sm="3.5" md="3.5">
                <VTextField :rules="[requiredValidator]" style="min-width: 280px; width: auto;" v-model="emergency_contacts.emergency_address" type="text" />
              </VCol>
            </td>
            <td scope="col" class="text-center">
              <VBtn icon size="x-small" @click="openConfirmDialog(index,emergency_contacts.id)" color="error" variant="text">
                <VIcon size="22" icon="tabler-trash" />
              </VBtn>
            </td>
          </tr>
        </tbody>
        </VTable>
      </VCard>
    <!--- Emergency Contact Number end ---->

    <!--- Alternative Phone Number ---->
    <VToolbar color="primary" title="Alternative Phone Number" />
    <VCardText class="d-flex justify-end flex-wrap gap-3 py-1 ">
      <VCol class="text-right clearfix">
        <VBtn @click.prevent="alternate_addItem" style="font-size: 10px; padding: 12px; float: right">
          <VIcon start icon="tabler-plus" />Add New Number
        </VBtn>
      </VCol>
    </VCardText>
      <VCard>
        <VTable class="px-2 py-2">
          <thead>
            <tr>
              <th class="text-center" scope="col">
                Title
              </th>
              <th class="text-center" scope="col">
                Phone No
              </th>
              <th class="text-center" scope="col">
                Contact Person
              </th>
              <th class="text-center" scope="col">
                Actions
              </th>
            </tr>
          </thead>
          <!-- 👉 table body -->
          <tbody v-if="Data.alternate_phone_no.length > 0">
          <tr v-for="(alternate_phone_no, index) in props.Data.alternate_phone_no" :key="alternate_phone_no.id">
            <td scope="col" width="auto">
              <VCol sm="3.5" md="3.5" hidden>
                <VTextField v-model="alternate_phone_no.id" type="number" />
              </VCol>
              <VCol sm="3.5" md="3.5">
                <VTextField :rules="[requiredValidator]" style="min-width: 110px; width: auto;" v-model="alternate_phone_no.alternate_phone_title" type="number" />
              </VCol>
            </td>
            <td scope="col" width="auto">
              <VCol sm="3.5" md="3.5">
                <VTextField :rules="[requiredValidator]" style="min-width: 200px; width: auto;" v-model="alternate_phone_no.alternate_phone_number" type="number" />
              </VCol>
            </td>
            <td scope="col" width="auto">
              <VCol sm="3.5" md="3.5">
                <VTextField :rules="[requiredValidator]" style="min-width: 250px; width: auto;" v-model="alternate_phone_no.alternate_contact_person" type="text" />
              </VCol>
            </td>
            <td scope="col" class="text-center">
              <VBtn icon size="x-small" @click="openConfirmDialogPhoneNumber(index,alternate_phone_no.id)" color="error" variant="text">
                <VIcon size="22" icon="tabler-trash" />
              </VBtn>
            </td>
          </tr>
        </tbody>
        </VTable>
      </VCard>
    <!--- Alternative Phone Number end ---->

    <!--- Emails ---->
    <VToolbar color="primary" title="Emails" />
    <VCardText class="d-flex justify-end flex-wrap gap-3 py-1 ">
      <VCol class="text-right clearfix">
        <VBtn @click.prevent="addEmail" style="font-size: 10px; padding: 12px; float: right">
          <VIcon start icon="tabler-plus" />Add New Email
        </VBtn>
      </VCol>
    </VCardText>
      <VCard>
        <VTable class="px-2 py-2">
          <thead>
            <tr>
              <th class="text-center" scope="col">
                Email Address
              </th>
              <th class="text-center" scope="col">
                Primary
              </th>
              <th class="text-center" scope="col">
                Actions
              </th>
            </tr>
          </thead>
          <!-- 👉 table body -->
          <tbody v-if="Data.emails.length > 0">
          <tr v-for="(emails, index) in props.Data.emails" :key="emails.id" :value="emails.id">
            <td scope="col" width="auto">
              <VCol hidden>
                <VTextField v-model="emails.id" type="number" />
              </VCol>
              <VCol sm="3.5" md="3.5">
                <VTextField style="min-width: 180px; width: auto;" v-model="emails.email" type="email" :rules="[emailValidator]"/>
              </VCol>
            </td>
            <td scope="col" width="auto">
              <VCol hidden>
                <VTextField v-model="emails.user_id" type="number" />
              </VCol>
              <VCol sm="3.5" md="3.5" class="text-center">
                <VCheckbox style="min-width: 10px" @update:modelValue="onChange(emails)" :disabled="emails.email == '' ? true : false"
                  v-model="emails.primary" :value="1" />
              </VCol>
            </td>

            <td scope="col" class="text-center">
              <VBtn :disabled="emails.primary == 1 ? true : false" icon size="x-small" @click="openConfirmDialogEmail(index,emails.id)"
                color="error" variant="text">
                <VIcon size="22" icon="tabler-trash" />
              </VBtn>
            </td>
          </tr>
        </tbody>
        </VTable>
      </VCard>
    <!--- Emails end ---->
  </VCard>
  <!-- Contact Information end -->
  
  <VDialog
  scrollable
  v-model="confirmDeletion"
  maxWidth="300"
  >
   <confirmDelete  :dataId="dataId" :dataIndex="dataIndex" :removeNumber="removeNumber" @close="confirmDeletion=false"/>
  </VDialog>

  <VDialog
  scrollable
  v-model="confirmDeletionAlternate"
  maxWidth="300"
  >
   <confirmDeleteAlternate  :dataId="dataId" :dataIndex="dataIndex" :removePhoneNumber="removePhoneNumber" @close="confirmDeletionAlternate=false"/>
  </VDialog>

  <VDialog
  scrollable
  v-model="confirmDeletionEmail"
  maxWidth="300"
  >
   <confirmDeleteEmail  :dataId="dataId" :dataIndex="dataIndex" @close="confirmDeletionEmail=false" :remove-email="removeEmail"/>
  </VDialog>

  </template>
