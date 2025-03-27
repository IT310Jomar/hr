<script setup lang="ts">
import {
  ref,
  onMounted,
  watch
} from 'vue';

const basicInfo = ref(null)
const workInfo = ref(null)
const govInfo = ref(null)
const accessInfo = ref(null)
const uploadInfo = ref(null)



</script>

<template>
  <VTable class="px-10 mb-10" style="margin-top: 2%;">
    <!-- <thead>
      <tr>
        <th></th>
        <th></th>
      </tr>
    </thead> -->
    <tbody>
      <tr>
        <td>Calendar</td>
        <td>
          <v-checkbox label="For 90 Days Review" value="1"></v-checkbox>
          <v-checkbox label="For 180 Days Review" value="1"></v-checkbox>
          <v-checkbox label="For Annual Review" value="1"></v-checkbox>
          <v-checkbox label="Birthday" value="1"></v-checkbox>
          <v-checkbox label="Leave" value="1"></v-checkbox>
          <v-checkbox label="Official Business" value="1"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Attendance Management</td>
        <td>
          <v-checkbox label="Add biometric logs" value="1"></v-checkbox>
          <v-checkbox label="Edit biometric logs" value="1"></v-checkbox>
          <v-checkbox label="Delete biometric logs" value="1"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>My Team</td>
        <td>
          <v-checkbox label="Team Calendar" value="1"></v-checkbox>
          <v-checkbox label="Team Attendance" value="2"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Employee Profile</td>
        <td>
          <v-checkbox label="Enable" value="1"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Employee Search</td>
        <td>
          <v-checkbox label="Enable" value="1"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Leave Application</td>
        <td>
          <v-checkbox label="Enable" value="1"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Overtime Application</td>
        <td>
          <v-checkbox label="Enable" value="1"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Undertime Application</td>
        <td>
          <v-checkbox label="Enable" value="1"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Official Business Application</td>
        <td>
          <v-checkbox label="Enable" value="1"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Certificate of Attendance Application</td>
        <td>
          <v-checkbox label="Enable" value="1"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Schedule Adjustment Application</td>
        <td>
          <v-checkbox label="Enable" value="1"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Employee List Report</td>
        <td>
          <v-checkbox label="Enable" value="1"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Email Blast</td>
        <td>
          <v-checkbox label="Enable" value="1"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Overtime Search</td>
        <td>
          <v-checkbox label="Enable" value="1"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Memo Search</td>
        <td>
          <v-checkbox label="Enable" value="1"></v-checkbox>
        </td>
      </tr>
      <tr>
        <td>Attendance Report</td>
        <td>
          <v-checkbox label="Enable" value="1"></v-checkbox>
        </td>
      </tr>
    </tbody>
  </VTable>
</template>
