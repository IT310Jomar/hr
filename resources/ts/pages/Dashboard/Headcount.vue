<script setup lang="ts">
import ChartJs from '@/pages/Dashboard/chartjs/chartjs.vue'
import headCountPrint from '@/pages/Dashboard/headCountDialog/headCountPrint.vue'


const printChartHeadCount = ref(false)
const userRole = JSON.parse(localStorage.getItem('userRole') || 'null')


//function for print
const print = () => {
  printChartHeadCount.value = true
  if (printChartHeadCount.value == true) {
    setTimeout(() => {
      window.print();
    },2500); // Add a delay of 100 milliseconds
  }
  window.addEventListener('beforeprint', () => {
    // The print dialog is about to be displayed
  });
  window.addEventListener('afterprint', () => {
    // The print dialog has been closed
    printChartHeadCount.value = false;
  });
}
</script>
<template>
  

   <VCol cols="12" sm="6" md="4" v-if="userRole == 'God Mode' || userRole == 'Administrator'">
    <VCard title="Headcount" class="d-flex flex-column mb-4" style="margin-bottom: 2.5%;height: 550px">
      <VDivider class="text-center" />
      <VCardText>
        <VRow>
          <VCol>
            <VBtn @click.prevent=" print" size="small" style="margin-right: 2%;" class="float-right">
              <VIcon size="18" icon="tabler-printer" />
              Print Chart
            </VBtn>
          </VCol>
        </VRow> 
      </VCardText>
      <VCardText class="d-flex align-center justify-center">
        <ChartJs />   
      </VCardText>
    </VCard>
</VCol> 
  <VDialog fullscreen v-model="printChartHeadCount" transition="dialog-bottom-transition"  :scrim="false">
     <headCountPrint/>
  </VDialog>

</template>
