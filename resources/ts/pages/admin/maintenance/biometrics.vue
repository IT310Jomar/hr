<script setup lang="ts">
import { ref } from "vue";

    const leave = ref('')
</script>

<template>
    <section>
        <v-row>
            <v-col cols="12" class="d-flex flex-column">
                <VCard title="Biometric Device Settings">
                    <VDivider />



                    <div class="d-flex justify-end mr-5 mb-8 mt-5">
                        <v-row class="ml-3">
                            <v-col cols="4" class="mb-2">
                                <VTextField v-model="incident" variant="underlined" label="Device Name">
                                </VTextField>
                            </v-col>
                            <v-col cols="4" class="mb-2">
                                <VTextField v-model="incident" variant="underlined" label="IP Address">
                                </VTextField>
                            </v-col>
                            <v-col cols="3" class="mb-2">
                                <VTextField v-model="incident" variant="underlined" label="Port Number">
                                </VTextField>
                            </v-col>
                        </v-row>

                        <!-- 👉 Add user button -->
                        <VBtn color="primary" size="large" prepend-icon="tabler-plus"
                            @click="isAddNewUserDrawerVisible = true">
                            <strong>Save Settings</strong>
                        </VBtn>
                    </div>
                    <VCardTitle>Device Registered Users</VCardTitle>
                    <VTable class="px-5 mb-5 mt-3">
                        <thead>
                            <tr>
                                <th>
                                    ID
                                </th>
                                <th>
                                    First Name
                                </th>
                                <th>
                                    Last Name
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Password
                                </th>
                                <th>
                                    User Level
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <!-- <tbody>
                      <tr>
                        <td></td>
                      </tr>
                    </tbody> -->

                        <!-- 👉 table footer  -->
                        <tfoot v-show="!leave.length">
                            <tr>
                                <td colspan="7" class="text-center py-10">
                                    <strong>
                                        Nothing to see here.
                                    </strong>
                                </td>
                            </tr>
                        </tfoot>
                    </VTable>
                </VCard>
            </v-col>

        </v-row>


    </section>
</template>
