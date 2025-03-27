<script setup lang="ts">
    const isDialogVisible = ref(false)
    const selectedItem = ref('Leave')
    const items = ['Leave', 'Official Business', 'Certificate of attendane']
</script>

<template>
    <VDialog v-model="isDialogVisible" max-width="800" class=" mb-16" >
        <!-- Dialog Activator -->
        <template #activator="{ props }">
            <VBtn @click="isDialogVisible = true" size="small">
                View Sick Leave
            </VBtn>
        </template>

        <!-- Dialog close btn -->
        <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />
        <!-- Dialog Content -->
        <VCard title="Missing Logs">
          <VCardText>
            <VCol cols="12" sm="12">
                <VForm ref="refEmployee">
                    <VCard>
                        <VTable>
                            <!-- 👉 table head -->
                            <thead>
                                <tr>
                                    <th class="text-Left" scope="col">
                                        First Name
                                    </th>
                                    <th class="text-center" scope="col">
                                        Middle Name
                                    </th>
                                    <th class="text-center" scope="col">
                                        Last Name
                                    </th>
                                    <th class="text-center" scope="col">
                                        Relationship
                                    </th>
                                    <th class="text-center" scope="col">
                                        Date of Birth
                                    </th>
                                    <th class="text-center" scope="col">
                                        Notes
                                    </th>
                                </tr>
                            </thead>
                            <!-- 👉 table body -->
                        </VTable>
                    </VCard>
                </VForm>
            </VCol>
            <v-container class="text-center">
                <v-row>
                    <v-col cols="12">
                        <p class="text-center">
                            <strong>
                                Current total leave credit:
                                <span class="ml-3">0</span>
                            </strong>
                        </p>
                    </v-col>
                </v-row>
            </v-container>
            <VDivider/>

            <VCardText class="d-flex justify-end flex-wrap gap-3">
                <VBtn variant="tonal" color="secondary" @click="isDialogVisible = false">
                    Close
                </VBtn>
                <VBtn @click="isDialogVisible = false">
                    Submit
                </VBtn>
            </VCardText>
          </VCardText>
        </VCard>
    </VDialog>
</template>
