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
    import { success } from 'toastr';


    type FormSubmittedEvent = (value: boolean) => void;
    interface Emit {
        (e: 'update:isDrawerOpen', value: boolean): void
            (e: 'form-deleted', callback: FormSubmittedEvent): void;
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


    const userDelete = (id:any) => {
      axios.delete(`/api/user/users/delete/${id}`)
      .then(response => {
        console.log(success)
        emit('form-deleted', response.data);
        toastr.success('Updated Successfully!');

        
      }).catch(error => {
        console.log(error);
      })

    };

    const getid = (id:any) => {
      axios.get(`/api/user/users/view/${id}`)
      .then(response => {
        
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
                    @click.prevent="getid(user.id)"
                  >
                    <VIcon
                      size="22"
                      icon="tabler-trash"
                    />
                  </VBtn>

        </template>

        <!-- Dialog close btn -->
        <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />

        <!-- Dialog Content -->
        <VCard title="Delete User">

            <VDivider class="mt-5" />

            <VCardText>
                <VRow>
                    <VCol cols="12" sm="12">
                            <PerfectScrollbar :options="{ wheelPropagation: false }">
                                <VCard flat>
                                    <VCardText>
                                      <div>
                                          <h5>Are you sure you want to delete this user ?</h5>
                                      </div>
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
                <VBtn @click="userDelete(user.id), isDialogVisible = false">
                    Delete
                </VBtn>
            </VCardText>
        </VCard>
    </VDialog>



</template>
