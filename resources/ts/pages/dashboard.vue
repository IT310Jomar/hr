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

        <Updates/>

        <!-- 👉 My Attendance -->

        <MyAttendance/>

        <!-- 👉 My Stuff -->

        <MyStuff/>
    </v-row>

    <VRow>
        <!-- 👉 Headcount -->

        <Headcount/>

        <!-- 👉 Movements This Month -->

        <MovementsMonth/>

        <!-- 👉 Attendance Today -->

        <AttendanceToday/>
    </VRow>

    <!-- 👉 Resolution Center -->

    <VRow>
      <ResolutionCenter/>
    </VRow>

    <VRow>
        <!-- 👉 Approval Center -->

        <ApprovalCenter/>

    </VRow>
  </section>

</template>

