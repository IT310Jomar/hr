<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import empMovementChartjs from './empMovementChartjs.vue';
import attendanceChartjs from './attendanceChartjs.vue'
import overallChartjs from './overallChartjs.vue'
</script>

<template>
  <v-container fluid>
    <v-card>
      <v-toolbar color="primary" title=" HR Analytics" class="card-header card-header-lg">
      </v-toolbar>
      <v-card-text>
        <div>
          <v-row>
            <v-col cols="12">
              <p class="font-weight-normal" style="font-size: larger;">Narrow your results</p>
            </v-col>
          </v-row>
        </div>
        <v-row>
          <v-col cols="6" class="mb-10">
            <v-label for="filter_department">Date Range</v-label>
            <AppDateTimePicker v-model="dateRange" :config="{ mode: 'range' }" />
          </v-col>
          <v-col cols="6">
            <v-label>Department</v-label>
            <VSelect v-model="department" :items="['HR & Admin', 'IT', 'Production']" />
          </v-col>
        </v-row>



        <!-- 👉 Employee Status Movements -->

        <VCard height="550" class="mb-5">

          <VCardItem title="Employee Status Movements">
            <div class="float-right mt-5">
              <v-btn size="small" class="mr-2" data-chart-name="movements_ctx">
                <VIcon size="18" icon="material-symbols:save-outline" /> Save
              </v-btn>
              <v-btn size="small" class="btn btn-primary btn-sm print-btn" data-chart-name="movements_ctx">
                <VIcon size="18" icon="tabler-printer" />Print
              </v-btn>
            </div>
          </VCardItem>
          <VCardText>
            <!-- CHART -->
            <empMovementChartjs />
          </VCardText>

        </VCard>


        <!-- 👉 Attendance -->

        <VCard height="550" class="mb-5">
          <VCardItem>
            <VCardTitle>Attendance</VCardTitle>

            <div class="float-right mt-5">
              <v-btn size="small" class="mr-2" data-chart-name="movements_ctx">
                <VIcon size="18" icon="material-symbols:save-outline" /> Save
              </v-btn>
              <v-btn size="small" class="btn btn-primary btn-sm print-btn" data-chart-name="movements_ctx">
                <VIcon size="18" icon="tabler-printer" />Print
              </v-btn>
            </div>

          </VCardItem>
            <VCardText>
              <!-- CHART -->
              <attendanceChartjs/>
            </VCardText>
        </VCard>


        <!-- 👉 Overall Requests -->

        <VCard height="550" class="mb-5">
          <VCardItem>
            <VCardTitle>Overall Requests</VCardTitle>

            <div class="float-right mt-10">
              <v-btn size="small" class="mr-2" data-chart-name="movements_ctx">
                <VIcon size="18" icon="material-symbols:save-outline" /> Save
              </v-btn>
              <v-btn size="small" class="btn btn-primary btn-sm print-btn" data-chart-name="movements_ctx">
                <VIcon size="18" icon="tabler-printer" />Print
              </v-btn>
            </div>

          </VCardItem>
            <VCardText>
              <!-- CHART -->
              <overallChartjs/>
            </VCardText>
        </VCard>

      </v-card-text>
    </v-card>
  </v-container>
</template>


<style scoped>
canvas {
  max-width: 100%;
  height: auto !important;
}
</style>
