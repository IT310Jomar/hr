<script lang="ts" setup>

    interface Props {
        Data: any
    }


    const props = defineProps < Props > ()

    // 👉 Add item function
    const addItem = () => {
        // eslint-disable-next-line vue/no-mutating-props
        props.Data.education.push({

        })
    }

    // 👉 Remove Product edit section
    const removeProduct = (id: number) => {
        // eslint-disable-next-line vue/no-mutating-props
        props.Data.education.splice(id, 1)
        
    }
</script>


<template>
        <VCard style="margin:2vh;">
            <VToolbar color="primary" title="Educational Background" />
            <VCardText>
                <VForm ref="refEmployee">
                    <VCard>
                        <VTable>
                            <!-- 👉 table head -->
                            <thead>
                                <tr>
                                    <th class="text-Left" scope="col">
                                        Education Type
                                    </th>
                                    <th class="text-left" scope="col">
                                        School
                                    </th>
                                    <th class="text-Left" scope="col">
                                        From
                                    </th>
                                    <th class="text-Left" scope="col">
                                        To
                                    </th>
                                    <th class="text-center" scope="col">
                                        Degree
                                    </th>
                                    <th class="text-Left" scope="col">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <!-- 👉 table body -->
                            <tbody class="clearfix" v-if="Data.education.length > 0">
                                <tr v-for="(education, index) in props.Data.education" :key="education.title">
                                    <td class="text-Left" scope="col" width="20%">
                                        <VSelect v-model="educational_type" :items="educationtype"
                                            :menu-props="{ transition: 'scroll-y-transition' }" type="text"
                                            width="auto" variant="underlined" />
                                    </td>
                                    <td class="text-Left" scope="col" width="20%">
                                        <VCol sm="3.5" md="3.5">
                                            <VTextField v-model="school" type="text" variant="underlined" />
                                        </VCol>
                                    </td>
                                    <td class="text-Left" scope="col">
                                        <VTextField v-model="datefrom" label="dd/mm/yyyy" type="date" />
                                    </td>
                                    <td class="text-Left" scope="col">
                                        <VTextField v-model="dateto" label="dd/mm/yyyy" type="date" />
                                    </td>
                                    <td class="text-Left" scope="col" width="15%">
                                        <VCol sm="3.5" md="3.5">
                                            <VTextField v-model="degree" type="text" variant="underlined" />
                                        </VCol>
                                    </td>
                                    <td class="text-Left" scope="col">
                                        <VBtn icon size="x-small" @click="removeProduct" color="error" variant="text">
                                            <VIcon size="22" icon="tabler-trash" />
                                        </VBtn>
                                    </td>
                                </tr>
                            </tbody>
                            <!-- <tfoot v-else>
                              <tr>
                                <td
                                  colspan="7"
                                  class="text-center"
                                >
                                  No data available
                                </td>
                              </tr>
                            </tfoot> -->
                        </VTable>
                    </VCard>
                </VForm>
            </VCardText>
            <VCardText class="d-flex justify-end flex-wrap gap-3 py-1">
                <VCol class="text-right clearfix">
                    <VBtn type="submit" @click="addItem" size="small">
                        Add Educational Background
                    </VBtn>
                </VCol>
            </VCardText>
        </VCard>
</template>
