<script setup lang="ts">
import AddAssest from '@/pages/admin/maintenance/assets-dialog/add-assets.vue'
import UpdateAsset from '@/pages/admin/maintenance/assets-dialog/update-assets.vue'
import DeleteAsset from '@/pages/admin/maintenance/assets-dialog/delete-assets.vue'
import axios from 'axios'
import { onMounted, ref } from 'vue';
import { environment } from '@/environments/environment'

const assetsData = ref([])
const AssetData = ref('')
const isDialogVisible = ref(false)

const getData = () => {
  axios.get(environment.API_URL +'user/maintenance/get-asset-categories')
    .then(response => {
      if(response.data.success) {
        assetsData.value = response.data.assets
      }

    }).catch(error => {
      console.log(error);
    })
};

const handleSubmit = () => {
  getData();
};


const formatAssetID = (value: string): string => {
  if (assetsData.value.length >= value.length) {
    return value;
  } else {
    let IDLength = assetsData.value.length;
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
              <VCard title="Assets">
                    <div class="d-flex justify-end mr-5 mb-5" style="margin-top: -5%;">
                            <!-- 👉 Add assest button -->
                            <AddAssest @submitted="handleSubmit"/>
                        </div>
                    <VDivider class="mb-5"/>
                    <VTable class="px-5 mb-5">
                        <thead>
                        <tr>
                            <th>
                              Asset Category ID
                            </th>
                            <th>
                              Category
                            </th>
                            <th>
                              Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(data, index) in assetsData" :key="data.id" style="height: 3.75rem;">

                        <!-- 👉 index -->
                        <td>{{ formatAssetID(data.id) }}</td>

                        <!-- 👉 name -->
                        <td>{{ data . name }}</td>

                        <!-- 👉 Actions -->
                        <td
                          style="width: 15rem;"
                        >
                        <div class="d-flex gap-2 text-center">
                        <!-- 👉 update assest button -->
                          <UpdateAsset :data="data"  />
                        <!-- 👉 delete assest button -->
                          <DeleteAsset @deleted="handleSubmit" :data="data"/>

                        </div>
                          
                        </td>
                      </tr>
                    </tbody>

                        <!-- 👉 table footer  -->
                        <tfoot v-show="!assetsData.length">
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
