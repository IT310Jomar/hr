<script setup lang="ts">
import avatar1 from '@images/avatars/avatar-1.png'
import ChangePassword from '@/pages/admin/change-password.vue'
import Logout from '@/pages/admin/logout.vue'
import axios from 'axios';
import { onMounted, ref } from 'vue';
const userData = ref();
const employee_id = ref();
const Changepassword = ref(false);
// const token = JSON.parse(localStorage.accessToken);

const openDialog = () => {
  Changepassword.value = true
}

const token = JSON.parse(localStorage.getItem('accessToken') || 'null');
const loginUser = () => {
  axios.get('/api/user/user-profile', {
    params: {
      token: token
    }
  })
    .then(response => {
      if (response.data.success) {
        if (response.data.dataUser)
          userData.value = response.data.dataUser
      }
    })
    .catch(error => {
      console.log(error);
    });
};


onMounted(() => {
  loginUser();
  Getpassword()
  // console.log(employee_id.value, "Employee ID")
})

//getemployeeData
const Getpassword = () => {
  axios.get('/api/user/user-id', {
    params: {
      token: token
    }
  })
    .then(response => {
      if (response.data.success) {
        if (response.data.user_id) {
          employee_id.value = response.data.user_id
        } else {
          console.log("False")
        }
      }
    }).catch(error => {
      console.log('error')
    })
}

</script>

<template>
  <VBadge dot location="bottom right" offset-x="3" offset-y="3" bordered color="success">
    <VAvatar class="cursor-pointer" color="primary" variant="tonal">
      <VImg :src="avatar1" />

      <!-- SECTION Menu -->
      <VMenu v-if="userData" activator="parent" width="250" location="bottom end" offset="16px">
        <VList>
          <!-- 👉 User Avatar & Name -->
          <VListItem>
            <template #prepend>
              <VListItemAction start>
                <VBadge dot location="bottom right" offset-x="3" offset-y="3" color="success">
                  <VAvatar color="primary" variant="tonal">
                    <VImg :src="avatar1" />
                  </VAvatar>
                </VBadge>
              </VListItemAction>
            </template>

            <VListItemTitle class="font-weight-semibold">
              {{ userData.username }}
            </VListItemTitle>
            <VListItemSubtitle>{{ userData.level_id }}</VListItemSubtitle>
          </VListItem>

          <!-- <VDivider class="my-2" /> -->

          <!-- 👉 Profile -->
          <VListItem link to="/admin/MyProfile/profile">

            <template #prepend>

              <VIcon class="me-2" icon="tabler-user" size="18" />

            </template>

            <VListItemTitle style="font-size: 16px;">My Profile</VListItemTitle>
          </VListItem>

          <!-- 👉 My Attendance -->
          <VListItem link to="/sidebarLayout/certificate_of_advance/CertificateOfAdvance">
            <template #prepend>
              <VIcon class="me-2" icon="tabler-clipboard-list" size="18" />
            </template>

            <VListItemTitle style="font-size: 16px;">My Attendance</VListItemTitle>
          </VListItem>

          <!-- 👉 My Biologs -->
          <VListItem link to="/admin/biologs">
            <template #prepend>
              <VIcon class="me-2" icon="tabler-clipboard-check" size="18" />
            </template>

            <VListItemTitle style="font-size: 16px;">My Biologs</VListItemTitle>
          </VListItem>

          <VDivider class="my-2" />

          <!-- 👉 Help -->
          <VListItem link>
            <template #prepend>
              <VIcon class="me-2" icon="tabler-help" size="18" />
            </template>

            <VListItemTitle style="font-size: 16px;">Help</VListItemTitle>
          </VListItem>
          <VDivider class="my-2" />


          <!-- 👉 Change Password -->
          <VListItem title="Change Password" @click.prevent="openDialog">
            <template #prepend>
              <VIcon class="me-2" icon="tabler-lock" size="18" />
            </template>
          </VListItem>

          <!-- Divider -->
          <VDivider class="my-2" />

          <!-- 👉 Help -->
          <VListItem link>
            <template #prepend>
              <VIcon class="me-2" icon="tabler-question-circle" size="18" />
            </template>

            <VListItemTitle style="font-size: 16px;">Privacy Policy</VListItemTitle>
          </VListItem>

          <!-- 👉 Help -->
          <VListItem link>
            <template #prepend>
              <VIcon class="me-2" icon="tabler-award" size="18" />
            </template>

            <VListItemTitle style="font-size: 16px;">Terms of Service</VListItemTitle>
          </VListItem>

          <!-- Divider -->
          <VDivider class="my-2" />

          <!-- 👉 Logout -->
          <!-- <VListItem to="/login"> -->

          <Logout />

          <!-- <VListItemTitle style="font-size: 16px;">Logout</VListItemTitle> -->
          <!-- </VListItem> -->
        </VList>
      </VMenu>
      <!-- !SECTION -->
    </VAvatar>
  </VBadge>
  <VDialog v-model="Changepassword" scrollable max-width="600">
    <ChangePassword :employee_id="employee_id" :token="token" @close="Changepassword = false" />

  </VDialog>
</template>
