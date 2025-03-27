<script setup lang="ts">
    import {
        PerfectScrollbar
    } from 'vue3-perfect-scrollbar'
    // eslint-disable-next-line @typescript-eslint/consistent-type-imports
    import type {
        VForm
    } from 'vuetify/components'

    // import type { UserProperties } from '@/@fake-db/types'
    import {
        emailValidator,
        requiredValidator
    } from '@validators'
    import axios from 'axios'
    import {
        useToastr
    } from '@/toastr';


    type FormSubmittedEvent = (value: boolean) => void;
    interface Emit {
        (e: 'update:isDrawerOpen', value: boolean): void
            (e: 'updated', callback: FormSubmittedEvent): void;
    }

    interface Props {
        isDrawerOpen: boolean
        user: any
    }

    const isViewUserVisible = ref(false)
    const isDialogVisible = ref(false)

    const toastr = useToastr();
    const props = defineProps < Props > ()
    const emit = defineEmits < Emit > ()
    const name = ref('')
    const email = ref('')
    const password = ref('')
    const isFormValid = ref(false)
    const refForm = ref < VForm > ()
    const formValues = ref();
    const users = ref([])
    const userData = ref('')


    // 👉 drawer close
    const closeNavigationDrawer = () => {
        emit('update:isDrawerOpen', false)

        nextTick(() => {
            refForm.value?.reset()
            refForm.value?.resetValidation()
        })
    }

    const handleDrawerModelValueUpdate = (val: boolean) => {
        emit('update:isDrawerOpen', val)
    }

    const isViewUserDrawerVisible = ref(false)

    const userDetail = ref([])
    
    const viewUser = (id:any) => {
      axios.get(`/api/user/users/view/${id}`)
      .then(response => {
        userDetail.value =  response.data
        console.log(userDetail.value)
        
      }).catch(error => {
        console.log(error);
      })

    };

</script>

<template>


    <VDialog v-model="isDialogVisible" max-width="600" top="true">
        <!-- Dialog Activator -->
        <template #activator="{ props }">

          <VBtn
                    icon
                    size="x-small"
                    color="default"
                    variant="text"
                    v-bind="props"
                    v-model="isDialogVisible" inset
                    @click.prevent="viewUser(user.id)"
                  >
                    <VIcon
                      size="22"
                      icon="tabler-eye"
                    />


                  </VBtn>
        </template>

        <!-- Dialog close btn -->
        <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />

        <!-- Dialog Content -->
        <VCard title="View User">

            <VDivider class="mt-5" />

            <VCardText>
                <VRow>
                    <VCol cols="12" sm="12">
                            <PerfectScrollbar :options="{ wheelPropagation: false }">
                                <VCard flat>
                                    <VCardText>
                                        <!-- 👉 Form -->
                                        <VForm ref="refForm" v-model="isFormValid" :initial-values="user" >
                                            <VRow>
                                                <!-- 👉 Full name -->
                                                <VCol cols="12">
                                                    <VTextField readonly v-model="userDetail.name"
                                                        :rules="[requiredValidator]" label="Full Name" />
                                                </VCol>

                                                <!-- 👉 Email -->
                                                <VCol cols="12">
                                                    <VTextField readonly v-model="userDetail.email"
                                                        :rules="[requiredValidator, emailValidator]" label="Email" />
                                                </VCol>

                                                <!-- 👉 Password -->
                                                <!-- <VCol cols="12">
                                                    <VTextField readonly v-model="userDetail.password" type="password"
                                                        :rules="[requiredValidator]" label="Password" />
                                                </VCol> -->

                                            </VRow>
                                        </VForm>
                                    </VCardText>
                                </VCard>
                            </PerfectScrollbar>
                    </VCol>
                </VRow>
            </VCardText>
            <VDivider class="mb-1 mt-1" />
            <VCardText class="d-flex justify-end flex-wrap gap-3">
                <VBtn variant="tonal" color="on-secondary" @click="isDialogVisible = false">
                    Cancel
                </VBtn>
                <!-- <VBtn @click="isDialogVisible = false">
                    Ok
                </VBtn> -->
            </VCardText>
        </VCard>
    </VDialog>



</template>
