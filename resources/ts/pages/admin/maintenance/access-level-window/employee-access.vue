<script setup lang="ts">
import {
  ref,
  onMounted,
  watch
} from 'vue';

const condition = ['Yes','No']
const defualtcondition = ref('-- Select Option --')
const employeeAccess = ref(null)



</script>

<template>
  <v-row class="mb-10 mt-5 ml-5">
    <v-col cols="3">
      <v-label class="mb-2">Can Add Employee?</v-label>
      <v-select :items="condition" v-model="defualtcondition" density="compact"/>
    </v-col>
  </v-row>
</template>
