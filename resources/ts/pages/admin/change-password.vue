<script setup lang="ts">
import type { VForm } from 'vuetify/components'
import { emailValidator, requiredValidator } from '@validators'
import axios from 'axios'
import { defineProps } from 'vue'
import passwordMeter from "vue-simple-password-meter";
import { onMounted, ref } from 'vue';
import bcrypt from 'bcryptjs';
import { toast } from 'vue3-toastify';

const refForm = ref<VForm>()
const isFormValid = ref(false)
const password = ref();
const props = defineProps(['employee_id', 'token']);
const emit = defineEmits(['close']);
const currentpass = ref();
const newpass = ref('');
const confirmpass = ref('');
const token = JSON.parse(localStorage.getItem('accessToken') || 'null');
const isPasswordVisible = ref(false);
const passmeter = ref();

const errorEdit = ref(false)
  function errorPassword() {
    isFormValid.value = false
    Editpassword()
    errorEdit.value = true
  }

const UpdatePassword = () => {
  refForm.value?.validate()
  .then(({ valid: isValid }) => {
    if (isValid) {
      Editpassword()
    } else {
      toast("Please double check your Input Password", {
        autoClose: 4000,
        type: 'error',
        theme: 'colored'
      })
    }
  })
}

//submit forms
const Editpassword = () => {
  axios.put('/api/user/user-profile/changepass', { newpass: newpass.value }, {
    headers: { Authorization: `Bearer ${token}` }
  }).then((response) => {
    if (response.data.success) {
      toast("Success! Password Updated!", {
        autoClose: 4000,
        type: 'success',
        theme: 'colored',
        style: {
          width: '350px' // Set the width to 400 pixels
        }
      })
      closeDialog()
      refForm.value?.reset()
    } else {
      errorPassword()
      toast("Error! Please check your Current Password!", {
        autoClose: 4000,
        type: 'error',
        theme: 'colored',
        style: {
          width: '350px' // Set the width to 400 pixels
        }
      })
      closeDialog()
    }
  }).catch(error => {
    console.log(error)
  })
}
function closeDialog() {
  emit('close')
}

//get Hash password
const GetData = () => {
  axios.get('/api/user/password/user-password', {
    params: {
      token: token
    }
  })
    .then(response => {
      if (response.data.success) {
        // console.log(response.data.success)
        if (response.data.password) {
          password.value = response.data.password
        } else {
          console.log('error')
        }
      }
    }).catch(error => {
      console.log('error')
    })
}

onMounted(() => {
  GetData();
})

</script>

<template>
  <section>
    <DialogCloseBtn @click="closeDialog" />
    <!-- Dialog Content -->
    <VCard title="Change Password">
      <VForm ref="refForm" v-model="isFormValid" @submit.prevent="UpdatePassword">
      <VCardText>
        <VRow>
          <VCol cols="12" sm="12">
              <VCard flat>
                <VCardText>
                  <!-- 👉 Form -->
                    <VRow>
                      <!-- 👉 Current Password -->
                      <VCol cols="12">
                        <VTextField v-model="currentpass" :type="isPasswordVisible ? 'text' : 'password'"
                        :rules="[requiredValidator, () => (currentpass.length >= 8 && bcrypt.compareSync(currentpass, password)) || 'Invalid Current Password']"
                          :append-inner-icon="isPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
                          label="Current Password" @click:append-inner="isPasswordVisible = !isPasswordVisible" />
                      </VCol>

                      <!-- 👉 New Password -->
                      <VCol cols="12">
                        <VTextField v-model="newpass"
                          :rules="[requiredValidator, (v) => (v && v.length >= 8 && 'Password must be at least 8 characters long' &&  newpass !== currentpass) || 'Dont use your old Password']"
                          :type="isPasswordVisible ? 'text' : 'password'"
                          :append-inner-icon="isPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'" label="New Password"
                          @click:append-inner="isPasswordVisible = !isPasswordVisible" />
                          <password-meter v-model="passmeter" :password="newpass" />
                      </VCol>

                      <!-- 👉 Confirm Password -->
                      <VCol cols="12">
                        <VTextField v-model="confirmpass"
                          :rules="[requiredValidator, (confirmpass) => (confirmpass && confirmpass === newpass) || 'New Password Doesnt Match']"
                          :type="isPasswordVisible ? 'text' : 'password'"
                          :append-inner-icon="isPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
                          label="Confirm Password" @click:append-inner="isPasswordVisible = !isPasswordVisible" />
                      </VCol>

                    </VRow>
                  
                </VCardText>
              </VCard>
          </VCol>
        </VRow>
      </VCardText>
      <VDivider class="mb-1 mt-1" />
      <VCardText class="d-flex justify-end flex-wrap gap-3">
        <VBtn variant="tonal" color="on-secondary" @click.prevent="closeDialog">
          Cancel
        </VBtn>
        <VBtn type="submit">
          Update Password
        </VBtn>
      </VCardText>
    </VForm>
    </VCard>

    <VSnackbar
      v-model="errorEdit"
      :timeout="2000"
      variant="flat"
      color="error"
    >
      <VIcon>mdi-alert-circle-outline</VIcon>&nbsp; Oops! Please check your fields!
    </VSnackbar>

  </section>
</template>


<style>
.po-password-strength-bar {
  border-radius: 2px;
  transition: all 0.2s linear;
  height: 5px;
  margin-top: 8px;
}

.po-password-strength-bar.risky {
  background-color: #f95e68;
  width: 10%;
}

.po-password-strength-bar.guessable {
  background-color: #fb964d;
  width: 32.5%;
}

.po-password-strength-bar.weak {
  background-color: #fdd244;
  width: 55%;
}

.po-password-strength-bar.safe {
  background-color: #b0dc53;
  width: 77.5%;
}

.po-password-strength-bar.secure {
  background-color: #35cc62;
  width: 100%;
}</style>
