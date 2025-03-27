<script setup lang="ts">
// import MyProfileViewing from '@/pages/admin/maintenance/access-level-window/my-profile.vue'
// import EmployeePageAccess from '@/pages/admin/maintenance/access-level-window/employee-access.vue'
// import NavigationAccess from '@/pages/admin/maintenance/access-level-window/navigation-access.vue'
import { emailValidator, requiredValidator } from '@validators'
import { ref } from "vue";
import axios from 'axios';
import { environment } from '@/environments/environment';
import { toast } from 'vue3-toastify';
import { VForm, VTable } from 'vuetify/components';

const accessFormRef = ref<VForm>();
const basicInfo = ref()
const workInfo = ref()
const govInfo = ref()
const accessInfo = ref()
const uploadInfo = ref()
const defualtcondition = ref()

const educ = ref([])
const pm = ref([])
const contact = ref([])
const dependent = ref([])
const benefit = ref([])
const leave = ref([])
const salary = ref([])
const advance = ref([])
const asset = ref([])
const memo = ref([])
const seminar = ref([])
const empRec = ref([])
const movement = ref([])
const medRec = ref([])
const requirements = ref([])
const scheduleInfo = ref([])
const docs = ref([])

const calendar = ref([])
const attendance = ref([])
const myteam = ref([])

const empprofile = ref(false)
const empsearch = ref()
const leaveApp = ref()
const overtime = ref()
const undertime = ref()
const offbusApp = ref()
const coapp = ref()
const saapp = ref()
const emplistrep = ref()
const emailblast = ref()
const overtimeSearch = ref()
const memoSearch = ref()
const attendanceRep = ref()


const selectedEduc = ref([{ title: 'View', value: 'view' }, { title: 'Edit', value: 'edit' }, { title: 'Add', value: 'add' }, { title: 'Delete', value: 'delete' }])
const selectedPM = ref([{ title: 'View', value: 'view' }, { title: 'Edit', value: 'edit' }, { title: 'Add', value: 'add' }, { title: 'Delete', value: 'delete' }])
const selectedContact = ref([{ title: 'View', value: 'view' }, { title: 'Edit', value: 'edit' }, { title: 'Add', value: 'add' }, { title: 'Delete', value: 'delete' }])
const selectedDependent = ref([{ title: 'View', value: 'view' }, { title: 'Edit', value: 'edit' }, { title: 'Add', value: 'add' }, { title: 'Delete', value: 'delete' }])
const selectedBenefit = ref([{ title: 'View', value: 'view' }, { title: 'Edit', value: 'edit' }, { title: 'Add', value: 'add' }, { title: 'Delete', value: 'delete' }])
const selectedLeave = ref([{ title: 'View', value: 'view' }, { title: 'Edit', value: 'edit' }, { title: 'Add', value: 'add' }, { title: 'Delete', value: 'delete' }])
const selectedSalary = ref([{ title: 'View', value: 'view' }, { title: 'Edit', value: 'edit' }, { title: 'Add', value: 'add' }, { title: 'Delete', value: 'delete' }])
const selectedAdvance = ref([{ title: 'View', value: 'view' }, { title: 'Edit', value: 'edit' }, { title: 'Add', value: 'add' }, { title: 'Delete', value: 'delete' }])
const selectedAsset = ref([{ title: 'View', value: 'view' }, { title: 'Edit', value: 'edit' }, { title: 'Add', value: 'add' }, { title: 'Delete', value: 'delete' }])
const selectedMemo = ref([{ title: 'View', value: 'view' }, { title: 'Edit', value: 'edit' }, { title: 'Add', value: 'add' }, { title: 'Delete', value: 'delete' }])
const selectedSeminar = ref([{ title: 'View', value: 'view' }, { title: 'Edit', value: 'edit' }, { title: 'Add', value: 'add' }, { title: 'Delete', value: 'delete' }])
const selectedempRec = ref([{ title: 'View', value: 'view' }, { title: 'Edit', value: 'edit' }, { title: 'Add', value: 'add' }, { title: 'Delete', value: 'delete' }])
const selectedMovement = ref([{ title: 'View', value: 'view' }, { title: 'Edit', value: 'edit' }, { title: 'Add', value: 'add' }, { title: 'Delete', value: 'delete' }])
const selectedmedRec = ref([{ title: 'View', value: 'view' }, { title: 'Edit', value: 'edit' }, { title: 'Add', value: 'add' }, { title: 'Delete', value: 'delete' }])
const selectedRequirements = ref([{ title: 'View', value: 'view' }, { title: 'Edit', value: 'edit' }, { title: 'Add', value: 'add' }, { title: 'Delete', value: 'delete' }])
const selectedscheduleInfo = ref([{ title: 'View', value: 'view' }, { title: 'Edit', value: 'edit' }, { title: 'Add', value: 'add' }, { title: 'Delete', value: 'delete' }])
const selectedDocs = ref([{ title: 'View', value: 'view' }, { title: 'Edit', value: 'edit' }, { title: 'Add', value: 'add' }, { title: 'Delete', value: 'delete' }])

const selectedCalendar = ref([{ title: 'For 90 Days Review', value: 'For 90 Days Review' }, { title: 'For 180 Days Review', value: 'For 180 Days Review' }, { title: 'For Annual Review', value: 'For Annual Review' }, { title: 'Birthday', value: 'Birthday' }, { title: 'Leave', value: 'Leave' }, { title: 'Official Business', value: 'Official Business' }])
const selectedAttendance = ref([{ title: 'Add biometric logs', value: 'Add biometric logs' }, { title: 'Edit biometric logs', value: 'Edit biometric logs' }, { title: 'Delete biometric logs', value: 'Delete biometric logs' }])
const selectedMyteam = ref([{ title: 'Team Calendar', value: 'Team Calendar' }, { title: 'Team Attendance', value: 'Team Attendance' }])

const condition = ['Yes', 'No']

const access_name = ref('')
const levelData = ref()
const dash_typeData = ref()
const levels = ['New Access Level', 'God Mode', 'Employee', 'Administrator', 'Supervisor / Manager']
const dash_type = ['Employee', 'Admin']
const privilageData = ref()
const data = ref()
const navigationTab = ref<string | null>(null)
const tabItems = ['My Profile Viewing', 'Employee Page Access', 'Navigation Access']

const user_level = ref([{ item: '--Select User Role--', value: null }])

const childFunctionRef = ref(null)

const getUserLevel = () => {
  axios.get('/api/user/employees/getEmploymentOptions')
    .then((response) => {
      // User levels
      if (response.data.success) {
        if (response.data.levels) {
          user_level.value = response.data.levels.slice(1).map((level: { name: any; id: any; }) => ({
            item: level.name,
            value: level.id
          }));
        }
      }
    });
};

const submitAccess = () => {
  if (!levelData.value || !basicInfo.value || !workInfo.value || !govInfo.value || !accessInfo.value || !uploadInfo.value || !educ.value || !pm.value || !contact.value || !dependent.value || !benefit.value || !leave.value || !salary.value || !advance.value || !asset.value || !memo.value || !seminar.value || !empRec.value || !movement.value || !medRec.value || !requirements.value || !scheduleInfo.value || !docs.value || !defualtcondition.value || !calendar.value || !attendance.value || !myteam.value) {
    toast("Error! Please check your fields!", {
      autoClose: 4000,
      type: 'error',
      theme: 'colored',
      style: {
        width: '350px' // Set the width to 400 pixels
      }
    })
  } else {
    axios.put(environment.API_URL + 'user/maintenance/privilege', {
      basicInfo: basicInfo.value,
      workInfo: workInfo.value,
      govInfo: govInfo.value,
      accessInfo: accessInfo.value,
      uploadInfo: uploadInfo.value,
      user_level: levelData.value,
      selectedEduc: educ.value,
      PM: pm.value,
      contact: contact.value,
      dependent: dependent.value,
      benefit: benefit.value,
      leave: leave.value,
      salary: salary.value,
      advance: advance.value,
      asset: asset.value,
      memo: memo.value,
      seminar: seminar.value,
      empRec: empRec.value,
      movement: movement.value,
      medRec: medRec.value,
      requirements: requirements.value,
      scheduleInfo: scheduleInfo.value,
      docs: docs.value,
      addEmployee: defualtcondition.value,
      calendar: calendar.value,
      attendance: attendance.value,
      myteam: myteam.value,
      empprofile: empprofile.value,
      empsearch: empsearch.value,
      leaveApp: leaveApp.value,
      overtime: overtime.value,
      undertime: undertime.value,
      offbusApp: offbusApp.value,
      coapp: coapp.value,
      saapp: saapp.value,
      emplistrep: emplistrep.value,
      emailblast: emailblast.value,
      overtimeSearch: overtimeSearch.value,
      memoSearch: memoSearch.value,
      attendanceRep: attendanceRep.value
    }).then((response) => {
      if (response.data.success) {
        toast("Success! Access Level record!", {
          autoClose: 4000,
          type: 'success',
          theme: 'colored',
          style: {
            width: '350px' // Set the width to 400 pixels
          }
        })
      } else {
        toast("Error! Please check your fields!", {
          autoClose: 4000,
          type: 'error',
          theme: 'colored',
          style: {
            width: '350px' // Set the width to 400 pixels
          }
        })
      }
    })
  }

}

const getPrivilege = () => {
  axios.get(environment.API_URL + 'user/maintenance/get-privilege')
    .then((response) => {
      if (response.data.success) {
        data.value = response.data.privilege;
        // console.log(data.value);
      }
    });
}

const deletePrivilege = () => {
  axios.delete(environment.API_URL + 'user/maintenance/delete-privilege/', {
    params: {
      user_level: levelData.value
    }
  })
    .then((response) => {
      if (response.data.success) {

        accessFormRef.value?.reset();

        toast('Deleted Successfully!', {
          autoClose: 4000,
          type: 'success',
          theme: 'colored',
          style: {
            width: '350px', // Set the width to 350 pixels
          },
        });
      } else {
        toast('User privilege not found', {
          autoClose: 4000,
          type: 'error',
          theme: 'colored',
          style: {
            width: '350px', // Set the width to 350 pixels
          },
        });
      }
    });
};

const test = () => {
  basicInfo.value = privilageData.value[0];
  workInfo.value = privilageData.value[1];
  govInfo.value = privilageData.value[2];
  accessInfo.value = privilageData.value[3];
  uploadInfo.value = privilageData.value[4];
  defualtcondition.value = privilageData.value[5];
  educ.value = Array.isArray(privilageData.value[6]) ? privilageData.value[6] : [];
  pm.value = Array.isArray(privilageData.value[7]) ? privilageData.value[7] : [];
  contact.value = Array.isArray(privilageData.value[8]) ? privilageData.value[8] : [];
  dependent.value = Array.isArray(privilageData.value[9]) ? privilageData.value[9] : [];
  benefit.value = Array.isArray(privilageData.value[10]) ? privilageData.value[10] : [];
  leave.value = Array.isArray(privilageData.value[11]) ? privilageData.value[11] : [];
  salary.value = Array.isArray(privilageData.value[12]) ? privilageData.value[12] : [];
  advance.value = Array.isArray(privilageData.value[13]) ? privilageData.value[13] : [];
  asset.value = Array.isArray(privilageData.value[14]) ? privilageData.value[14] : [];
  memo.value = Array.isArray(privilageData.value[15]) ? privilageData.value[15] : [];
  seminar.value = Array.isArray(privilageData.value[16]) ? privilageData.value[16] : [];
  empRec.value = Array.isArray(privilageData.value[17]) ? privilageData.value[17] : [];
  movement.value = Array.isArray(privilageData.value[18]) ? privilageData.value[18] : [];
  medRec.value = Array.isArray(privilageData.value[19]) ? privilageData.value[19] : [];
  requirements.value = Array.isArray(privilageData.value[20]) ? privilageData.value[20] : [];
  scheduleInfo.value = Array.isArray(privilageData.value[21]) ? privilageData.value[21] : [];
  docs.value = Array.isArray(privilageData.value[22]) ? privilageData.value[22] : [];
  calendar.value = Array.isArray(privilageData.value[23]) ? privilageData.value[23] : [];
  attendance.value = Array.isArray(privilageData.value[24]) ? privilageData.value[24] : [];
  myteam.value = Array.isArray(privilageData.value[25]) ? privilageData.value[25] : [];
  empprofile.value = privilageData.value[26];
  empsearch.value = privilageData.value[27];
  leaveApp.value = privilageData.value[28];
  overtime.value = privilageData.value[29];
  undertime.value = privilageData.value[30];
  offbusApp.value = privilageData.value[31];
  coapp.value = privilageData.value[32];
  saapp.value = privilageData.value[33];
  emplistrep.value = privilageData.value[34];
  emailblast.value = privilageData.value[35];
  overtimeSearch.value = privilageData.value[36];
  memoSearch.value = privilageData.value[37];
  attendanceRep.value = privilageData.value[38];
};


const onUpdateData = () => {
  if (data.value[levelData.value] != null) {
    privilageData.value = data.value[levelData.value];
    test();
  } else {
    getPrivilege();

    // Reset checked state of v-radio
    basicInfo.value = null;
    workInfo.value = null;
    govInfo.value = null;
    accessInfo.value = null;
    uploadInfo.value = null;
    defualtcondition.value = null;
    empprofile.value = false;
    empsearch.value = false;
    leaveApp.value = false;
    overtime.value = false;
    undertime.value = false;
    offbusApp.value = false;
    coapp.value = false;
    saapp.value = false;
    emplistrep.value = false;
    emailblast.value = false;
    overtimeSearch.value = false;
    memoSearch.value = false;
    attendanceRep.value = false;


    // Reset checked state of v-checkbox

    educ.value = [];
    pm.value = [];
    contact.value = [];
    dependent.value = [];
    benefit.value = [];
    leave.value = [];
    salary.value = [];
    advance.value = [];
    asset.value = [];
    memo.value = [];
    seminar.value = [];
    empRec.value = [];
    movement.value = [];
    medRec.value = [];
    requirements.value = [];
    scheduleInfo.value = [];
    docs.value = [];
    calendar.value = [];
    attendance.value = [];
    myteam.value = [];

  }
}

onMounted(() => {
  getUserLevel();
  getPrivilege();
})

</script>

<template>
  <section>
    <v-row>
      <v-col cols="12" class="d-flex flex-column">
        <VCard title="Access Levels">
          <VDivider />
          <div class="d-flex justify-end mr-5 mb-8 mt-5">
            <v-row class="ml-3">
              <v-col class="mb-2">
                <VSelect :items="user_level" item-title="item" item-value="value" :rules="[requiredValidator]"
                  v-model="levelData" @update:model-value="onUpdateData" label="--Select User Role--" />
              </v-col>
              <!-- <v-col cols="4" class="mb-2">
                <VTextField v-model="access_name" label="Access Name">
                </VTextField>
              </v-col> -->
              <v-col class="mb-2">
                          <!-- 👉 Add Save and Delete button -->
          <div class="d-flex justify-end mr-5 mb-8 mt-5 gap-1">
            <VBtn color="primary" size="small" prepend-icon="material-symbols:save-outline" @click="submitAccess">
              <strong>Save</strong>
            </VBtn>
            <VBtn color="error" size="small" prepend-icon="tabler-trash" @click="deletePrivilege">
              <strong>Delete</strong>
            </VBtn>
          </div>
                <!-- <VSelect :items="dash_type" v-model="dash_typeData" density="compact" label="Dashboard Type" /> -->
              </v-col>
            </v-row>
          </div>

          <!-- 👉 Add Save and Delete button -->
          <!-- <div class="d-flex justify-end mr-5 mb-8 mt-5 gap-1">
            <VBtn color="primary" size="small" prepend-icon="material-symbols:save-outline" @click="submitAccess">
              <strong>Save</strong>
            </VBtn>
            <VBtn color="error" size="small" prepend-icon="tabler-trash" @click="">
              <strong>Delete</strong>
            </VBtn>
          </div> -->

          <VCard>
            <VForm ref="accessFormRef">
            <v-tabs v-model="navigationTab" class="mt-5 mb-2">
              <v-tab v-for="item in tabItems" :key="item" :value="item">
                {{ item }}
              </v-tab>
            </v-tabs>
            <VDivider />
            <v-table>
              <v-window v-model="navigationTab">
                <v-window-item :value="'My Profile Viewing'">
                  <!-- <MyProfileViewing :level_id="computedLevelId" :dataBasicInfo="dataBasicInfo" @AccessLevel="handleData" :privilageData="privilageData" :onUpdateData="test"/> -->
                  <VTable ref="myprofileAccess" class="px-10 mb-10" style="margin-top: 2%;">
                    <tbody>
                      <tr>
                        <td>Basic Information</td>
                        <td>
                          <v-radio-group v-model="basicInfo">
                            <v-radio label="View Only" value="viewonly"></v-radio>
                            <v-radio class="pb-3" label="Editor" value="editor"></v-radio>
                          </v-radio-group>
                        </td>
                      </tr>
                      <tr>
                        <td>Work Information</td>
                        <td>
                          <v-radio-group v-model="workInfo">
                            <v-radio label="No Access" value="noaccess"></v-radio>
                            <v-radio label="View Only" value="viewonly"></v-radio>
                            <v-radio class="pb-3" label="Editor" value="editor"></v-radio>
                          </v-radio-group>
                        </td>
                      </tr>
                      <tr>
                        <td>Government Information</td>
                        <td>
                          <v-radio-group v-model="govInfo">
                            <v-radio label="No Access" value="noaccess"></v-radio>
                            <v-radio label="View Only" value="viewonly"></v-radio>
                            <v-radio class="pb-3" label="Editor" value="editor"></v-radio>
                          </v-radio-group>
                        </td>
                      </tr>
                      <tr>
                        <td>Access Level</td>
                        <td>
                          <v-radio-group v-model="accessInfo">
                            <v-radio label="View Only" value="viewonly"></v-radio>
                            <v-radio class="pb-3" label="Editor" value="editor"></v-radio>
                          </v-radio-group>
                        </td>
                      </tr>
                      <tr>
                        <td>Upload Pictures</td>
                        <td>
                          <v-radio-group v-model="uploadInfo">
                            <v-radio label="View Only" value="viewonly"></v-radio>
                            <v-radio class="pb-3" label="Allowed to Upload" value="allowedtoupload"></v-radio>
                          </v-radio-group>
                        </td>
                      </tr>
                      <tr>
                        <td>Educational Information</td>
                        <td>
                          <v-checkbox v-model="educ" v-for="data in selectedEduc" :key="data.value" :value="data.value"
                            :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Performance Management</td>
                        <td>
                          <v-checkbox v-model="pm" v-for="data in selectedPM" :key="data.value" :value="data.value"
                            :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Contact Information</td>
                        <td>
                          <v-checkbox v-model="contact" v-for="data in selectedContact" :key="data.value"
                            :value="data.value" :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Dependent</td>
                        <td>
                          <v-checkbox v-model="dependent" v-for="data in selectedDependent" :key="data.value"
                            :value="data.value" :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Benefits</td>
                        <td>
                          <v-checkbox v-model="benefit" v-for="data in selectedBenefit" :key="data.value"
                            :value="data.value" :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Leave</td>
                        <td>
                          <v-checkbox v-model="leave" v-for="data in selectedLeave" :key="data.value" :value="data.value"
                            :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Salary</td>
                        <td>
                          <v-checkbox v-model="salary" v-for="data in selectedSalary" :key="data.value"
                            :value="data.value" :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Advances</td>
                        <td>
                          <v-checkbox v-model="advance" v-for="data in selectedAdvance" :key="data.value"
                            :value="data.value" :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Assets</td>
                        <td>
                          <v-checkbox v-model="asset" v-for="data in selectedAsset" :key="data.value" :value="data.value"
                            :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Memo</td>
                        <td>
                          <v-checkbox v-model="memo" v-for="data in selectedMemo" :key="data.value" :value="data.value"
                            :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Seminars</td>
                        <td>
                          <v-checkbox v-model="seminar" v-for="data in selectedSeminar" :key="data.value"
                            :value="data.value" :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Employment Record</td>
                        <td>
                          <v-checkbox v-model="empRec" v-for="data in selectedempRec" :key="data.value"
                            :value="data.value" :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Movement</td>
                        <td>
                          <v-checkbox v-model="movement" v-for="data in selectedMovement" :key="data.value"
                            :value="data.value" :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Medical Records</td>
                        <td>
                          <v-checkbox v-model="medRec" v-for="data in selectedmedRec" :key="data.value"
                            :value="data.value" :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Requirements</td>
                        <td>
                          <v-checkbox v-model="requirements" v-for="data in selectedRequirements" :key="data.value"
                            :value="data.value" :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Work Schedule Information</td>
                        <td>
                          <v-checkbox v-model="scheduleInfo" v-for="data in selectedscheduleInfo" :key="data.value"
                            :value="data.value" :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Documents</td>
                        <td>
                          <v-checkbox v-model="docs" v-for="data in selectedDocs" :key="data.value" :value="data.value"
                            :label="data.title"></v-checkbox>
                        </td>
                      </tr>

                    </tbody>
                  </VTable>
                </v-window-item>

                <v-window-item :value="'Employee Page Access'">
                  <!-- <EmployeePageAccess /> -->
                  <v-row class="mb-10 mt-5 ml-5">
                    <v-col cols="3">
                      <v-label class="mb-2">Can Add Employee?</v-label>
                        <v-radio-group v-model="defualtcondition">
                          <v-radio label="Yes" value="yes"></v-radio>
                          <v-radio class="pb-3" label="No" value="no"></v-radio>
                        </v-radio-group>
                      <!-- <VSelect :items="condition" item-title="item" item-value="value" v-model="defualtcondition"
                        label="-- Select Option --" type="text" /> -->
                    </v-col>
                  </v-row>
                </v-window-item>

                <v-window-item :value="'Navigation Access'">
                  <!-- <NavigationAccess /> -->
                  <VTable class="px-10 mb-10" style="margin-top: 2%;">
                    <tbody>
                      <tr>
                        <td>Calendar</td>
                        <td>
                          <v-checkbox v-model="calendar" v-for="data in selectedCalendar" :key="data.value" :value="data.value"
                            :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Attendance Management</td>
                        <td>
                          <v-checkbox v-model="attendance" v-for="data in selectedAttendance" :key="data.value" :value="data.value"
                            :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>My Team</td>
                        <td>
                          <v-checkbox v-model="myteam" v-for="data in selectedMyteam" :key="data.value" :value="data.value"
                            :label="data.title"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Employee Profile</td>
                        <td>
                          <v-checkbox v-model="empprofile" label="Enable"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Employee Search</td>
                        <td>
                          <v-checkbox v-model="empsearch" label="Enable"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Leave Application</td>
                        <td>
                          <v-checkbox v-model="leaveApp" label="Enable"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Overtime Application</td>
                        <td>
                          <v-checkbox v-model="overtime" label="Enable"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Undertime Application</td>
                        <td>
                          <v-checkbox v-model="undertime" label="Enable"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Official Business Application</td>
                        <td>
                          <v-checkbox v-model="offbusApp" label="Enable"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Certificate of Attendance Application</td>
                        <td>
                          <v-checkbox v-model="coapp" label="Enable"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Schedule Adjustment Application</td>
                        <td>
                          <v-checkbox v-model="saapp" label="Enable"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Employee List Report</td>
                        <td>
                          <v-checkbox v-model="emplistrep" label="Enable"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Email Blast</td>
                        <td>
                          <v-checkbox v-model="emailblast" label="Enable"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Overtime Search</td>
                        <td>
                          <v-checkbox v-model="overtimeSearch" label="Enable"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Memo Search</td>
                        <td>
                          <v-checkbox v-model="memoSearch" label="Enable"></v-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td>Attendance Report</td>
                        <td>
                          <v-checkbox v-model="attendanceRep" label="Enable"></v-checkbox>
                        </td>
                      </tr>
                    </tbody>
                  </VTable>
                </v-window-item>
              </v-window>
            </v-table>
          </VForm>
          </VCard>
        </VCard>
      </v-col>

    </v-row>


  </section>
</template>

<style>
table {
  border-collapse: collapse;
  border: 1px solid #dee2e6;
}

th,
td {
  border: 1px solid #dee2e6;
  padding: 8px;
  text-align: left;
}</style>
