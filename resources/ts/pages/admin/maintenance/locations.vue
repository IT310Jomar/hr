<script setup lang="ts">
import AddLocation from '@/pages/admin/maintenance/location-dialog/add-location.vue'
import UpdateLocation from '@/pages/admin/maintenance/location-dialog/update-location.vue'
import DeleteLocation from '@/pages/admin/maintenance/location-dialog/delete-location.vue'
import axios from 'axios'
import { onMounted, ref } from 'vue';
import { environment } from '@/environments/environment'

const locationsData = ref([])

const getData = () => {
  axios.get(environment.API_URL +'user/maintenance/get-location')
    .then(response => {
      if(response.data.success) {
        locationsData.value = response.data.assets
      }
    }).catch(error => {
      console.log(error);
    })
};

const handleSubmit = () => {
  getData();
};

const formatLocationDataID = (value: string): string => {
  if (locationsData.value.length >= value.length) {
    return value;
  } else {
    let IDLength = locationsData.value.length;
    let prefix = '';

    for (let x = IDLength; x < value.length; x++) {
      prefix += '0';
    }
    prefix += '00000'; // add five 0s to prefix

    return prefix + value;
  }
}

onMounted(() => {
  getData();
});
</script>

<template>
    <section>
        <v-row>
            <v-col cols="12" class="d-flex flex-column">
              <VCard title="Location">
                    <div class="d-flex justify-end mr-5 mb-5" style="margin-top: -5%;">
                            <!-- 👉 Add location button -->
                            <AddLocation @submitted="handleSubmit"/>
                        </div>
                    <VDivider class="mb-5"/>
                    <VTable class="px-5 mb-5">
                        <thead>
                        <tr>
                            <th>
                              Location ID
                            </th>
                            <th>
                              Location Name
                            </th>
                            <th>
                              Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(data, index) in locationsData" :key="data.id" style="height: 3.75rem;">

                        <!-- 👉 index -->
                        <td>{{ formatLocationDataID(data.id) }}</td>

                        <!-- 👉 name -->
                        <td>{{ data . name }}</td>

                        <!-- 👉 Actions -->
                        <td
                          style="width: 15rem;"
                        >
                        <div class="d-flex gap-2 text-center">
                        <!-- 👉 update location button -->
                          <UpdateLocation :data="data"  />
                        <!-- 👉 delete location button -->
                          <DeleteLocation @deleted="handleSubmit" :data="data"/>

                        </div>
                          
                        </td>
                      </tr>
                    </tbody>

                        <!-- 👉 table footer  -->
                        <tfoot v-show="!locationsData.length">
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
  