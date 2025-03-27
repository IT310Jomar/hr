<script setup lang="ts">
    const isDialogVisible = ref(false)
    const Manager = ref()
</script>

<template>
    <VDialog v-model="isDialogVisible" max-width="600" top="true">
        <!-- Dialog Activator -->
        <template #activator="{ props }">
            <VSwitch v-bind="props" v-model="isDialogVisible" inset :label="'Fill In'" style="margin-top: -60%; margin-left: -20%; margin-right: 5%;" />
        </template>

        <!-- Dialog close btn -->
        <DialogCloseBtn @click="isDialogVisible = !isDialogVisible" />

        <!-- Dialog Content -->
        <VCard title="Approval Fill In">

            <VDivider class="mt-8" />

            <VCardText>
                <VRow>
                    <VCol cols="12" sm="12">
                        <VListItemTitle class="mb-3 mt-5">
                            Who do you want to pass approvals to?
                        </VListItemTitle>
                        <VSelect v-model="Manager"
                            :items="['Manager 1', 'Manager 2', 'Manager 3', 'Manager 4', 'Manager 5']"
                            label="-- Select Manager --" />
                    </VCol>
                </VRow>
            </VCardText>
            <VDivider class="mb-5 mt-5" />
            <VCardText class="d-flex justify-end flex-wrap gap-3">
                <VBtn variant="tonal" color="on-secondary" @click="isDialogVisible = false">
                    Cancel
                </VBtn>
                <VBtn @click="isDialogVisible = false">
                    Save
                </VBtn>
            </VCardText>
        </VCard>
    </VDialog>
</template>
