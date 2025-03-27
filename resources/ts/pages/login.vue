<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { useToastr } from '@/toastr';
import { useAppAbility } from '@/plugins/casl/useAppAbility';
import avatar1 from '@images/avatars/avatar-1.png';
// import AuthProvider from '@/views/pages/authentication/AuthProvider.vue'
import { useGenerateImageVariant } from '@core/composable/useGenerateImageVariant'
import { VNodeRenderer } from '@layouts/components/VNodeRenderer'
import { themeConfig } from '@themeConfig'
import { emailValidator, requiredValidator } from '@validators'
import { toast } from 'vue3-toastify';
import { VForm } from 'vuetify/components';
import { environment } from "@/environments/environment";

import authV2LoginIllustrationBorderedDark from '@images/pages/auth-v2-login-illustration-bordered-dark.png'
import authV2LoginIllustrationBorderedLight from '@images/pages/auth-v2-login-illustration-bordered-light.png'
import authV2LoginIllustrationDark from '@images/pages/auth-v2-login-illustration-dark.png'
import authV2LoginIllustrationLight from '@images/pages/auth-v2-login-illustration-light.png'
import authV2MaskDark from '@images/pages/misc-mask-dark.png'
import authV2MaskLight from '@images/pages/misc-mask-light.png'

// inside the component's setup function
// const ability = inject('ability')

const authThemeImg = useGenerateImageVariant(authV2LoginIllustrationLight, authV2LoginIllustrationDark, authV2LoginIllustrationBorderedLight, authV2LoginIllustrationBorderedDark, true)

const authThemeMask = useGenerateImageVariant(authV2MaskLight, authV2MaskDark)

const isPasswordVisible = ref(false)
const toastr = useToastr();

// const email = ref('admin@demo.com')
// const password = ref('admin')
// const rememberMe = ref(false)
const refVForm = ref<VForm>()

const email = ref('sirius@itechmedialogic.com');
const password = ref('');
const router = useRouter();
const ability = useAppAbility()
// console.log('ability', ability)

const isDialogVisible = ref(false)

watch(isDialogVisible, value => {
  if (!value)
    return

  setTimeout(() => {
    isDialogVisible.value = false
  }, 4000)
})


const invalidLogin = ref(false)


const loading = () => {
  isDialogVisible.value = true
}

const onSubmit = () => {
  refVForm.value?.validate()
    .then(({ valid: isValid }) => {
      loading()
      if (isValid) {

        login()

      } else {
        invalidLogin.value = true
        isDialogVisible.value = false
        toast("Error! Please check your fields!", {
        autoClose: 4000,
        type: 'error',
        theme: 'colored',
        style: {
          width: '350px' // Set the width to 400 pixels
        }
        })
      }
    })
}

const login = () => {
  axios.post(environment.API_URL + 'user/login', {
    email: email.value,
    password: password.value,
  })
    .then((response) => {
      if(response.data) {
        localStorage.setItem('userAbilities', JSON.stringify(response.data.user.ability))
        localStorage.setItem('userData', JSON.stringify(response.data.user))
        localStorage.setItem('accessToken', JSON.stringify(response.data.access_token))
        localStorage.setItem('userRole', JSON.stringify(response.data.user.level_id))

        ability.update(response.data.user.ability)
        // ability.update(response.data.level_id)
        console.log(response.data.user.level_id)

        // console.log(localStorage)
        // console.log('success')
        // Redirect to `to` query if exist or redirect to index route
        // router.replace(route.query.to ? String(route.query.to) : '/')
        router.push({ name: "index" });

        // if (userRole === 'SystemAdmin' || 'Employee' || 'HrAdmin' || 'ManagerSupervisor') {
        //   router.push({ name: 'index' }); // Replace 'dashboard-admin' with your actual route name for admin dashboard
        // }
      } else {
        invalidLogin.value = true
        isDialogVisible.value = false
      }

    })
    .catch((error) => {
      invalidLogin.value = true
      isDialogVisible.value = false
      // console.error(error);
    });
    
    //   const token = response.data.token;
    //   if (token) {
    //     console.log(`Login successful with token: ${token}`);
    //     // Save the token to sessionStorage
    //     sessionStorage.setItem('authToken', token);
    //     // console.log(sessionStorage.getItem('authToken'));
    //     router.push('/');
    //     toastr.success('Login Successfully!')
    //   } else {
    //     console.error('Error logging in: No token in response');
    //     toastr.warning('Invalid Response from Server')
    //   }
    // })
    // .catch((error) => {
    //   if (error.response && error.response.status === 401) {
    //     toastr.warning('Invalid Credentials!')
    //   } else {
    //     console.error('Error logging in:', error);
    //     toastr.error('Error logging in!')
    //   }
    // });
  };




</script>

<template>
  <v-container fluid class="d-flex align-center justify-center mb-3 float-center">
    <v-card width="330" class="text-center float-center" height="480" style="float: inherit; margin-top: 8%;">
      <VForm ref="refVForm" @submit.prevent="onSubmit">
        <v-row justify="center">
          <v-col sm="8" md="10" class="mt-5">
            <VAvatar class="cursor-pointer" color="primary" variant="tonal"
              style="width: 120px; height: 120px; margin-top: 10%; margin-bottom: 8%;">
              <VImg :src="avatar1" />
            </VAvatar>
            <h4 class="mb-8">Login to your account</h4>

            <VTextField v-model="email" label="Email" type="email" :rules="[requiredValidator, emailValidator]"
              class="mb-3" />

            <VTextField v-model="password" label="Password" :rules="[requiredValidator]"
              :type="isPasswordVisible ? 'text' : 'password'"
              :append-inner-icon="isPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
              @click:append-inner="isPasswordVisible = !isPasswordVisible" />


            <VBtn rounded color="primary" type="submit" class="justify-space-between mt-10 mb-4">
              Login
            </VBtn>
          </v-col>
        </v-row>
      </VForm>

      <v-row justify="center">
        <v-col sm="8" md="10" class="mb-10">
          <small>&copy; 2018 Sirius, All Rights Reserved.</small>
        </v-col>
      </v-row>
    </v-card>
  </v-container>

  <VDialog timeout=20 v-model="isDialogVisible" width="300">
    <VCard color="primary" width="300">
      <VCardText class="pt-3">
        Please stand by
        <VProgressLinear indeterminate color="white" class="mb-0" />
      </VCardText>
    </VCard>
  </VDialog>

  <VSnackbar v-model="invalidLogin">
    Oops! Invalid credentials
  </VSnackbar>
  
</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";
</style>

<route lang="yaml">
meta:
  layout: blank
  action: read
  subject: Auth
  redirectIfLoggedIn: true
</route>
