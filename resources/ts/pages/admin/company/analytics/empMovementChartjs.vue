<script setup lang="ts">
import ChartJsBarChart from '@/pages/Dashboard/chartjs/ChartJsBarChart.vue'
import type { ChartJsCustomColors } from '@/pages/chart/chartjs/types'




const chartJsCustomColors: ChartJsCustomColors = {
  white: '#fff',
  yellow: '#ffe802',
  primary: '#836af9',
  areaChartBlue: '#2c9aff',
  barChartYellow: '#ffcf5c',
  polarChartGrey: '#4f5d70',
  polarChartInfo: '#299aff',
  lineChartYellow: '#d4e157',
  polarChartGreen: '#28dac6',
  lineChartPrimary: '#9e69fd',
  lineChartWarning: '#ff9800',
  horizontalBarInfo: '#26c6da',
  polarChartWarning: '#ff8131',
  scatterChartGreen: '#28c76f',
  warningShade: '#ffbd1f',
  areaChartBlueLight: '#84d0ff',
  areaChartGreyLight: '#edf1f4',
  scatterChartWarning: '#ff9f43',
}
</script>
<template>
   <ChartJsBarChart :colors="chartJsCustomColors" />
</template>
