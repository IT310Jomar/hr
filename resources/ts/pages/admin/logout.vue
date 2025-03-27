<script setup lang="ts">
    import {PerfectScrollbar} from 'vue3-perfect-scrollbar'
    // eslint-disable-next-line @typescript-eslint/consistent-type-imports
    import type {VForm} from 'vuetify/components'
    // import type { UserProperties } from '@/@fake-db/types'
    import {emailValidator,requiredValidator} from '@validators'
    import axios from 'axios'
    import {useToastr} from '@/toastr';
    import { useRouter } from 'vue-router';
    import { initialAbility } from '@/plugins/casl/ability';
    import { useAppAbility } from '@/plugins/casl/useAppAbility';

    const ability = useAppAbility()
    const isDialogVisible2 = ref(false)

    const toastr = useToastr();

    const router = useRouter();
    
    // const authToken = sessionStorage.getItem('authToken');
    const userData = JSON.parse(localStorage.getItem('userData') || 'null')

    const isDialogVisible = ref(false)

    watch(isDialogVisible, value => {
      if (!value)
        return

      setTimeout(() => {
        isDialogVisible.value = false
      }, 4000)
    })
    
    const logout = () => {
      isDialogVisible.value = true
      localStorage.removeItem('userData')
      localStorage.removeItem('accessToken')
      localStorage.removeItem('userAbilities')
      localStorage.removeItem('userRole')
      
      ability.update(initialAbility)
    
      router.push('/login'); // Redirect the user to the login page
    }

    // const logout = (event: { preventDefault: () => void; }) => {
    //   event.preventDefault(); // Prevent default form submission behavior

    //   axios.post('/api/user/logout', {}, {
    //     headers: {
    //       'Authorization': `Bearer ${authToken}`
    //     }
    //   })
    //     .then(() => {
    //       // sessionStorage.getItem('authToken')
    //       localStorage.removeItem('userData')
    //       localStorage.removeItem('accessToken')
    //       localStorage.removeItem('userAbilities')
    //       router.push('/login'); // Redirect the user to the login page
    //       // Remove the token from localStorage

    //       toastr.success('Logout Successfully!')
    //     })
    //     .catch((error) => {
    //       console.error('Error logging out:', error);
    //       toastr.error('Error logging out!')
    //     });
    // };





</script>

<template>


    <VDialog v-model="isDialogVisible2" max-width="600" top="true">
        <!-- Dialog Activator -->
        <template #activator="{ props }">

          <VListItem                 
            icon
            size="small"
            color="default"
            variant="text"
            v-bind="props"
            v-model="isDialogVisible2" inset
            @click.prevent=""
           >
            <template #prepend>
                <VIcon
                  class="me-2"
                  icon="tabler-logout"
                  size="18"
                />
                <VListItemTitle style="font-size: 16px;">Logout</VListItemTitle>
            </template>
          </VListItem>

        </template>

        <!-- Dialog close btn -->
        <DialogCloseBtn @click="isDialogVisible2 = !isDialogVisible2" />

        <!-- Dialog Content -->
        <VCard>
            <VCardText>
                <VRow>
                    <VCol cols="12" sm="12">
                            <PerfectScrollbar :options="{ wheelPropagation: false }">
                                <VCard flat>
                                    <VCardText>
                                      <div>
                                          <h3>Are you sure you want to logout ?</h3>
                                      </div>
                                    </VCardText>
                                </VCard>
                            </PerfectScrollbar>
                    </VCol>
                </VRow>
            </VCardText>
            <!-- <VDivider class="mb-1 mt-1" /> -->
            <VCardText class="d-flex justify-end flex-wrap gap-3">
                <VBtn variant="tonal" color="on-secondary" @click="isDialogVisible2 = false">
                    No
                </VBtn>
                <VBtn @click="logout">
                    Yes, Logout
                </VBtn>
            </VCardText>
        </VCard>
    </VDialog>

    <VDialog
    timeout=20
    v-model="isDialogVisible"
    width="300"
  >
    <VCard
      color="primary"
      width="300"
    >
      <VCardText class="pt-3">
        Logging out...
        <VProgressLinear
          indeterminate
          color="white"
          class="mb-0"
        />
      </VCardText>
    </VCard>
  </VDialog>

</template>
