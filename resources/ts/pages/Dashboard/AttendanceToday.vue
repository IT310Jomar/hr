<script setup lang="ts">
import attendanceTodayChartjs from './attendanceTodayChartjs.vue';

const userRole = JSON.parse(localStorage.getItem('userRole') || 'null')

</script>


<template>
  <VCol cols="12" sm="6" md="4" v-if="userRole == 'God Mode' || userRole == 'Administrator'">
   <VCard title="Attendance Today" class="d-flex flex-column mb-4" style="margin-bottom: 2.5%;height: 550px">
     <VDivider class="text-center" />
     <VCardText>
       <VRow>
         <VCol>
           <VBtn @click.prevent="" size="small" style="margin-right: 2%;" class="float-right">
             <VIcon size="18" icon="tabler-printer" />
             Print Chart
           </VBtn>
         </VCol>
       </VRow> 
     </VCardText>
     <attendanceTodayChartjs/>
   </VCard>
</VCol> 
</template>

