<script setup lang="ts">
    import axios from 'axios';
    import {
        ref,
        onMounted
    } from 'vue';

    const team = ref(['']);


    const getUsers = () => {
        axios.get('/api/user/manage_team/view')
            .then((response) => {
                team.value = response.data;
                console.log(team.value);
            })
    }

    onMounted(() => {
        getUsers();
    });
</script>

<template>
  <section>
    <v-container>
        <v-card title="My Biometric Logs">
            <!-- <v-card-title class="text-h5">My Biometric Logs</v-card-title> -->
            <VDivider />
            <v-card-text>
                <v-form id="biologs-form">
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-text-field label="From" type="date"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field label="To" type="date"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" class="text-right">
                            <div class="d-flex justify-end mb-10 mt-1 gap-2">
                                <VBtn color="primary">Search</VBtn>
                                <VBtn color="primary">Export to Excel</VBtn>
                            </div>
                        </v-col>
                    </v-row>
                </v-form>
                <VDivider class="mt-3"/>
                <VTable class="dataTables_wrapper no-footer">
                    <!-- 👉 table head -->
                    <thead>
                        <tr>
                            <th scope="col">
                                Biometric ID
                            </th>
                            <th scope="col">
                                Log Time
                            </th>
                            <th scope="col">
                                In Out Mode
                            </th>
                        </tr>
                    </thead>
                    <!-- 👉 table body -->
                    <tbody>
                        <tr v-for="(manage_team, index) in team" :key="manage_team.id" style="height: 3.75rem;"
                            class="text-center">
                            <!-- 👉 User -->
                            <td>{{ index + 1 }}</td>
                            <td>{{ manage_team . fullname }}</td>
                            <td>{{ manage_team . position }}</td>

                        </tr>
                    </tbody>
                    <tfoot v-show="!team.length">
                        <tr>
                            <td colspan="7" class="text-center">
                                No result found!
                            </td>
                        </tr>
                    </tfoot>
                </VTable>
            </v-card-text>
        </v-card>
    </v-container>
  </section>
</template>
