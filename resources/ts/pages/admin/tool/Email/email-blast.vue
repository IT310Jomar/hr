<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import BlotFormatter from 'quill-blot-formatter';
import emailLoading from '../Email/emailLoading.vue'
import axios from 'axios';
import { emailValidator, requiredValidator } from '@validators'
import { VForm } from 'vuetify/components'
import { toast } from 'vue3-toastify';
import { environment } from '@/environments/environment';

const subject = ref();
const message = ref();
const selectedOptions = ref();
const options = ref(['']);
const opt = ref([{ title: '', value: '' }])
const valid = ref(false)
const email = ref()
const sendE = ref(false)
const refEmails = ref<VForm>()
const newMessage = ref()
const editor = ref()



const modules = {
  name: 'blotFormatter',
  module: BlotFormatter,
  options: {/* options */ }
}

onMounted(() => {
  initialized()
});

interface Option {
  id: number;
  text: string;
}



const getEmail = () => {
  axios.get(environment.API_URL + 'user/employees/email')
    .then((response) => {
      opt.value = []
      if (response.data.success) {
        if (response.data.email) {
          opt.value.push({ title: 'All', value: '0' })
          for (let i = 0; i < response.data.email.length; i++) {
            opt.value.push(
              {
                title: response.data.email[i].email,
                value: response.data.email[i].email
              }
            )
          }
        }
      }
    })
}
const initialized = () => {
  getEmail()

}


watch(selectedOptions, () => {

  //For selecting all items
  if (selectedOptions.value == opt.value[0].value) {
    selectedOptions.value = opt.value
    valid.value = true
  }
  //for checking if all items is selected 
  else if (selectedOptions.value.length == opt.value.length - 1 && valid.value == true) {
    //checking the items items if it has a 0 value 
    let hasZero = false
    for (let i = 0; i < selectedOptions.value.length; i++) {
      if (selectedOptions.value[i] === '0') {
        hasZero = true
        break
      }
    }
    //reseting the selectedOptions to empty array if the data has no 0 value
    if (!hasZero && valid.value == true) {
      selectedOptions.value = []
      valid.value = false
    }
    //checking if the selectedOption value is not equal to the all opt value
    let matchFound = true;
    for (let i = 0; i < selectedOptions.value.length; i++) {
      if (selectedOptions.value[i] !== opt.value[i].value) {
        matchFound = false;
        break;
      }
    }
    //Unchecking the all item if one of the email is unselected in the vselect
    if (!matchFound && selectedOptions.value.length > 1) {
      selectedOptions.value.splice(0, 1);
      valid.value = false;
    } else if (matchFound && selectedOptions.value.length === opt.value.length) {
      valid.value = true;
    } else {
      selectedOptions.value.splice(0, 1);
      valid.value = false;
    }
  }
  //for setting the selectedOption value to opt value if the user select all before all email was selected one by one
  for (let i = 0; i < selectedOptions.value.length; i++) {
    if (selectedOptions.value.length < opt.value.length) {
      if (selectedOptions.value[i] === '0') {
        selectedOptions.value = opt.value
        valid.value = true
      }
    }
  }
  //the all will also be selected if the all email was selected one by one
  if (selectedOptions.value.length > 0 && selectedOptions.value.length == opt.value.length - 1) {
    selectedOptions.value = opt.value
    valid.value = true
  }
})


watch(message, (newVal) => {
  newMessage.value = [];
  for (let i = 0; i < newVal.ops.length; i++) {
    const data = newVal.ops[i].insert;
    if (typeof data === 'string') {
      if (data !== '\n') {
        newMessage.value.push(data);
      }
    } else if (typeof data === 'object' && 'image' in data) {
      const imageData = data.image;
      if (imageData !== '\n') {
        newMessage.value.push(imageData);
      }
    }
  }


});
const sendingEmails = () => {
  refEmails.value?.validate()
    .then(({ valid: isValid }) => {
      if (newMessage.value == null) {
        toast("Please double check your fields", {
          autoClose: 4000,
          type: 'error',
          theme: 'colored'
        })
      } else {
        if (isValid) {
          sendEmail()

        } else {
          toast("Please double check your fields", {
            autoClose: 4000,
            type: 'error',
            theme: 'colored'
          })
        }
      }

    })
}


const sendEmail = () => {
  sendE.value = true
  if (selectedOptions.value[0].value == '0' && selectedOptions.value.length > 0) {
    const dataSelected = []
    for (let g = 1; g < selectedOptions.value.length; g++) {
      const data = selectedOptions.value[g].value
      dataSelected.push(data)
    }
    selectedOptions.value = dataSelected
  } if (newMessage.value == null) {
    toast("Please double check your fields", {
      autoClose: 4000,
      type: 'error',
      theme: 'colored'
    })
  }
  axios.post(environment.API_URL + 'user/admin/tools/email-blast/send-email', {
    selectedOptions: selectedOptions.value,
    subject: subject.value,
    message: newMessage.value,
  }).then((response) => {
    if (response.data.message) {
      email.value = response.data;
      sendE.value = false
      editor.value.setContents()
      refEmails.value?.reset()
      if (sendE.value == false) {
        toast("Success", {
          autoClose: 4000,
          type: 'success',
          theme: 'colored'
        })
      }
    }
  }).catch((err) => {

  });

}

// const userName = ref()
// const getUserData = () => {
//   const storedData = localStorage.getItem('userData');
//   const userData = storedData ? JSON.parse(storedData) : null;
//      userName.value = userData.username
//   return userData ? userData.username : null;
// };

onMounted(() => {
  initialized()

});

</script>

<template>
  <section fluid>
    <v-card>
      <VForm ref="refEmails">
        <v-toolbar color="primary" title="Email Blast" class="card-header card-header-lg">
        </v-toolbar>
        <v-card-text style="padding-left: 20%; padding-right: 20%;">
          <v-row>
            <v-col cols="12" class="mb-2">
              <v-label><strong>Subject</strong></v-label>
              <VTextField v-model="subject" :rules="[requiredValidator]">
              </VTextField>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" class="mb-2">

              <v-select v-model="selectedOptions" :rules="[requiredValidator]" :items="opt" item-title="title"
                item-value="value" label="Select options" multiple chips clearable></v-select>
              <!-- <VTextField v-model="selectedOptions"/> -->
            </v-col>
            <v-col cols="12" class="mb-2">
              <!-- <VTextField v-model="message"/> -->
              <QuillEditor v-model:content="message" ref="editor" theme="snow" :modules="modules" toolbar="full"
                style="height: 300px;" />
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="12" class="mb-2">
              <v-btn color="primary" @click.prevent="sendingEmails">Send</v-btn>
            </v-col>
          </v-row>
        </v-card-text>
      </VForm>
    </v-card>
    <VDialog v-model='sendE' max-width="300">
      <emailLoading />
    </VDialog>
  </section>
</template>
