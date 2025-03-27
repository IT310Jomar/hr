<script setup lang="ts">
    import Updates from '@/pages/Dashboard/Updates.vue'
    import MyAttendance from '@/pages/Dashboard/MyAttendance.vue'
    import MyStuff from '@/pages/Dashboard/MyStuff.vue'
    import Headcount from '@/pages/Dashboard/Headcount.vue'
    import MovementsMonth from '@/pages/Dashboard/MovementsMonth.vue'
    import AttendanceToday from '@/pages/Dashboard/AttendanceToday.vue'
    import ResolutionCenter from '@/pages/Dashboard/ResolutionCenter.vue'
    import ApprovalCenter from '@/pages/Dashboard/ApprovalCenter.vue'


</script>


<template>
  
  <section>
    <v-row>

        <Updates />

        <!-- 👉 My Attendance -->

        <MyAttendance/>

        <!-- 👉 My Stuff -->

        <MyStuff/>
    </v-row>

    <VRow>
        <!-- 👉 Headcount -->

        <Headcount />

        <!-- 👉 Movements This Month -->

        <MovementsMonth />

        <!-- 👉 Attendance Today -->

        <AttendanceToday/>
    </VRow>

    <!-- 👉 Resolution Center -->

    <VRow>
      <ResolutionCenter />
    </VRow>

    <VRow>
      <!-- 👉 Approval Center -->

      <ApprovalCenter />

    </VRow>
  </section>

</template>

<style lang="scss">
#loader {
  position: fixed;
  z-index: 11;
  margin: auto;
  color: white;
  inset: 0;
}

#container {
  display: flex;
  align-items: center;
  justify-content: center;
  block-size: 100%;
}

table {
    border-collapse: collapse;
    border: 1px solid #dee2e6;
  }
  th, td {
    border: 1px solid #dee2e6;
    padding: 8px;
    text-align: left;
  }
</style>
