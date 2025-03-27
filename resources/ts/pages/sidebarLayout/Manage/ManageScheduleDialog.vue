<script setup lang="ts">
import { onMounted, ref, defineProps } from 'vue';
import moment from 'moment';
const props = defineProps(['userDatas']);
const scheduleData = ref()
onMounted(() => {
  // 
  if (props.userDatas[0] == undefined) {

  } else {
    scheduleData.value = props.userDatas[0].schedule
  }
})

</script>
<template>
  <section>
    <VCard style="margin:2vh;">
      <VToolbar color="primary" title="Work Schedule" />
      <VCardText>
        <VRow>
          <VCol v-if="props.userDatas[0] !== undefined">
            <span style="font-weight: bold ;">Schedule Type :</span>
            {{ props.userDatas[0].employments.schedule_types.name }}
          </VCol>

          <VCol v-if="props.userDatas[0] === undefined">
            <span style="font-weight: bold;">Schedule Type :</span> No schedule yet!!
          </VCol>

        </VRow>

        <VRow>
          <VCol sm="3.5" md="3.5" v-if="props.userDatas[0] !== undefined">
            <span style="font-weight: bold;">No of hours to work including break hours :</span> {{
              props.userDatas[0].employments.working_hours }}
          </VCol>

          <VCol sm="3.5" md="3.5" v-if="props.userDatas[0] === undefined">
            <span style="font-weight: bold;">No of hours to work including break hours :</span> None
          </VCol>
        </VRow>
        <VCard class="mt-4">
          <VTable>

            <thead>
              <tr>
                <th class="text-Left" scope="col" style="text-align: center;">
                  Day
                </th>
                <th class="text-Left" scope="col" style="text-align: center;">
                  Shift Start
                </th>
                <th class="text-Left" scope="col" style="text-align: center;">
                  Shift End
                </th>
                <th class="text-Left" scope="col" style="text-align: center;">
                  Break Start
                </th>
                <th class="text-Left" scope="col" style="text-align: center;">
                  Break End
                </th>
                <th class="text-Left" scope="col" style="text-align: center;">
                  Rest Day
                </th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="(data) in scheduleData" :key="data">
                <td class="text-center">
                  {{ data.day }}
                </td>
                <td class="text-center">
                  {{ moment(data.shift_start, 'hh:mm A').format('hh:mm A') }}
                </td>
                <td class="text-center">
                  {{ moment(data.shift_end, 'hh:mm A').format('hh:mm A') }}
                </td>
                <td class="text-center">
                  {{ moment(data.break_start, 'hh:mm A').format('hh:mm A') }}
                </td>
                <td class="text-center">
                  {{ moment(data.break_end, 'hh:mm A').format('hh:mm A') }}
                </td>
                <td class="text-center">
                  <div v-if="data.rest_day == 1">
                    <VIcon color="success">
                      tabler:circle-check
                    </VIcon>
                  </div>

                  <div v-if="data.rest_day == 0">
                    <VIcon color="error">
                      tabler:circle-x
                    </VIcon>
                  </div>
                </td>
              </tr>
            </tbody>
            <tr v-if="scheduleData?.length == undefined">
              <td class="text-center" colspan="6">
                <span>
                  No records found at the moment
                </span>
              </td>
            </tr>
          </VTable>
        </VCard>
      </VCardText>
    </VCard>
  </section>
</template>
