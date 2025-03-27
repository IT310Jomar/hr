<script lang="ts" setup>
import ChartJs from '@/pages/Dashboard/chartjs/chartjs.vue'

</script>

<template>
  <VCard>
    <VRow>
      <VCol>
        <VCardTitle class="text-center"><strong>
            Sirius - HeadCount Chart
          </strong>
        </VCardTitle>
      </VCol>
    </VRow>
        <VCardText>
          <div style="display: flex; justify-content: center;">
        <ChartJs />
      </div>   
        </VCardText>
      
  </VCard>

</template>
<style lang="scss">
.dialog-bottom-transition-enter-active,
.dialog-bottom-transition-leave-active {
  transition: transform 0.2s ease-in-out;
}
</style>



