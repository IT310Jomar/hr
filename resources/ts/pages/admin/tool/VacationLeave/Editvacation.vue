<script setup lang="ts">
    const isDialogVisible = ref(false)
    const selectedItem = ref('Leave')
    const items = ['Leave', 'Official Business', 'Certificate of attendane']
</script>

<template>
    <VDialog v-model="isDialogVisible" max-width="500">
        <!-- Dialog Activator -->
        <template #activator="{ props }">
            <VBtn @click="isDialogVisible = true" size="small">
                Edit Sick Leave
            </VBtn>
        </template>

        <!-- Dialog close btn -->
        <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />

        <!-- Dialog Content -->
        <VCard title="Adjust Vacation Leave Credits">
            <VDivider class="mt-5" />
            <VCardText>
                <VRow>
                    <VCol cols="12" sm="12">
                        <div>
                            <VListItemTitle class="mb-3 " style=" font-size: 15px;">
                                Adjust Credits
                            </VListItemTitle>
                            <div class="form-group">
                                <label for="activity" class="form-label">Message</label>
                                <VTextField label="+4 or -4" style="height: fit-content;" />
                                <div class="form-group">
                                    <label for="activity" class="form-label">Reason for Overriding</label>
                                    <VTextarea />
                                </div>
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
                            </div>
                        </div>
                    </VCol>
                </VRow>
            </VCardText>
            <VDivider class="mb-1 mt-1" />
            <VCardText class="d-flex justify-end flex-wrap gap-3">
                <VBtn variant="tonal" color="secondary" @click="isDialogVisible = false">
                    Close
                </VBtn>
                <VBtn @click="isDialogVisible = false">
                    Submit
                </VBtn>
            </VCardText>
        </VCard>
    </VDialog>
</template>
