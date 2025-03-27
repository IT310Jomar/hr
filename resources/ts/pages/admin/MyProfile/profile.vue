<script setup lang="ts">
import moment from 'moment';
import avatar1 from '@images/avatars/avatar-1.png';
import signature from '@/pages/admin/MyProfile/my-profile_dialog/signature.vue';
import { formatDate } from '@/helper';
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import jwt_decode, { JwtPayload } from 'jwt-decode';
import { initialAbility } from '@/plugins/casl/ability';
import { useAppAbility } from '@/plugins/casl/useAppAbility';

const ability = useAppAbility()

interface MyJwtPayload extends JwtPayload {
  // add any custom fields to the payload
  sub: string;
  exp: number;
}

const links = ref([{
  id: 1,
  href: '#workInformation',
  to: null,
  icon: 'mdi-briefcase',
  label: 'Work Information',
},
{
  id: 2,
  href: '#workSchedule',
  to: null,
  icon: 'mdi-clock-time-three-outline',
  label: 'Work Schedule',
},
{
  id: 3,
  href: '#governmentInformation',
  to: null,
  icon: 'mdi-city',
  label: 'Government Information',
},
{
  id: 4,
  href: '#educationalBackground',
  to: null,
  icon: 'mdi-school',
  label: 'Educational Background',
},
{
  id: 5,
  href: '#performanceManagement',
  to: null,
  icon: 'mdi-format-list-checks',
  label: 'Performance Management',
},
{
  id: 6,
  href: '#contactInformation',
  to: null,
  icon: 'mdi-account-box-outline',
  label: 'Contact Information',
},
{
  id: 7,
  href: '#visa',
  to: null,
  icon: 'mdi-airplane-takeoff',
  label: 'Visa',
},
{
  id: 8,
  href: '#dependents',
  to: null,
  icon: 'mdi-account-multiple-outline',
  label: 'Dependents',
},
{
  id: 9,
  href: '#benefits',
  to: null,
  icon: 'mdi-star-outline',
  label: 'Benefits',
},
{
  id: 10,
  href: '#leavePlans',
  to: null,
  icon: 'mdi-subway-variant',
  label: 'Leave Plans and Usage',
},
{
  id: 11,
  href: '#salary',
  to: null,
  icon: 'mdi-cash-multiple',
  label: 'Salary',
},
{
  id: 12,
  href: '#advances',
  to: null,
  icon: 'mdi-currency-usd',
  label: 'Advances',
},
{
  id: 13,
  href: '#training',
  to: null,
  icon: 'icon-park-solid:blackboard',
  label: 'Training',
},
{
  id: 14,
  href: '#assets',
  to: null,
  icon: 'mdi-book-open-variant',
  label: 'Assets',
},
{
  id: 15,
  href: '#memo',
  to: null,
  icon: 'mdi-paperclip',
  label: 'Memo',
},
{
  id: 16,
  href: '#seminarsAttended',
  to: null,
  icon: 'mdi-heart-outline',
  label: 'Seminar / Service Training Attended',
},
{
  id: 17,
  href: '#employeeRecord',
  to: null,
  icon: 'tabler-archive',
  label: 'Employee Record',
},
{
  id: 18,
  href: '#movement',
  to: null,
  icon: 'mdi-map-marker',
  label: 'Movement',
},
{
  id: 19,
  href: '#documents',
  to: null,
  icon: 'mdi-archive',
  label: 'Documents',
},
{
  id: 20,
  href: '#medicalrecords',
  to: null,
  icon: 'mdi-medical-bag',
  label: 'Medical Records',
},
{
  id: 21,
  href: '#requirements',
  to: null,
  icon: 'material-symbols:format-list-numbered',
  label: 'Requirements',
},
{
  id: 22,
  href: '#accessLevel',
  to: null,
  icon: 'mdi-key',
  label: 'Access Level',
},

]);

const userData = ref();
const userAdmin = ref();


// const token = JSON.parse(localStorage.accessToken);
const router = useRouter();

const token = JSON.parse(localStorage.getItem('accessToken') || 'null');

const logout = () => {
  // remove user data from local storage
  localStorage.removeItem('accessToken');
  localStorage.removeItem('userData');
  localStorage.removeItem('userAbilities');
  localStorage.removeItem('userRole')
      
  ability.update(initialAbility)
  // redirect to the login page
  router.push('/login');
};

const checkAuth = () => {
  const token = JSON.parse(localStorage.getItem('accessToken') || 'null');
  if (token) {
    // decode the token to get its expiration date
    const decodedToken = jwt_decode<MyJwtPayload>(token);
    const currentTime = Math.floor(Date.now() / 1000);
    // check if the token has expired
    if (decodedToken.exp < currentTime) {
      // token has expired, log the user out
      logout();
    }
  } else {
    // token is null, log the user out
    logout();
  }
};

setTimeout(() => {
  checkAuth();
}, 6000)

// call the checkAuth function periodically to check if the token has expired
// setInterval(checkAuth, 1000); // check every minute

const loginUser = () => {
  axios.get('/api/user/user-profile', {
    params: {
      token: token
    }
  })
    .then(response => {
      if (response.data.success) {
        if (response.data.dataUser) {
          if (response.data.dataUser.level_id === 'God Mode') {
            userAdmin.value = response.data.dataUser;
            // console.log(userAdmin.value);
          } else {
            userData.value = response.data.dataUser.employees[0]
            // console.log(userData.value)
          }
        }
      } if (!token) {
        logout();
      }
    })
};

  const fileInput = ref();
  const fileInputEmployee = ref()

  const openFileDialog = () => {
    fileInput.value.click();
  };

  const openFileDialogEmployee = () => {
    fileInputEmployee.value.click();
  }

onMounted(() => {
  loginUser();
  checkAuth();
})

</script>

<template>
  <section>
  <v-row>

      <v-col cols="12" md="6" lg="4" v-show="userAdmin">
        <VCard class="d-flex flex-column mb-4" v-if="userAdmin">
          <div>
            <div>
              <div class="profile-card text-center mb-2">
                <div class="profile-card-photo">
                  <VAvatar class="cursor-pointer" color="primary" variant="tonal"
                    style="width: 120px; height: 120px; margin-top: 10%; margin-bottom: 3%;">
                    <VImg :src="avatar1" />
                  </VAvatar>
                </div>
                <div style="font-weight: bold;">{{ userAdmin.username }}</div>
                <div style="font-weight: bold;" v-if="userAdmin?.level_id ?? false">{{
                  userAdmin.level_id }}</div>
                <div class="mb-4"></div>
                <VListItem link>
                  <input ref="fileInput" type="file" hidden>
                  <v-btn @click="openFileDialog()" rounded="pill" size="small" class="btn btn-rounded btn-sm">
                    Upload Photo
                  </v-btn> &nbsp;
                </VListItem>

                <VListItem link>
                  <signature />
                </VListItem>
            </div>

            <VDivider />

              <VRow>
                <VCol>
                  <div class="profile-statistic tbl">
                    <VRow>
                      <VCol class="text-center mt-2" style="margin-bottom: -15%;">
                        <VListItemTitle><b v-if="userAdmin?.gender ?? false">{{ userAdmin.gender }}</b></VListItemTitle>
                        <VListItemTitle>Gender</VListItemTitle>
                      </VCol>
                      <VCol class="text-center mt-2">
                        <VListItemTitle><b v-if="userAdmin?.civil_status ?? false">{{ userAdmin.civil_status }}</b>
                        </VListItemTitle>
                        <VListItemTitle>Civil Status</VListItemTitle>
                      </VCol>
                    </VRow>
                  </div>
                </VCol>
            </VRow>

            <VRow>
                <VCol>
                  <div class="profile-statistic tbl">
                    <VRow>
                      <VCol class="text-center mt-2">
                        <VListItemTitle><b v-if="userAdmin?.birthdate ?? false">{{ formatDate(userAdmin.birthdate) }}</b>
                        </VListItemTitle>
                        <VListItemTitle>Date of Birth</VListItemTitle>
                      </VCol>
                      <VCol class="text-center mt-2">
                        <VListItemTitle><b v-if="userAdmin.employments?.id ?? false">{{ userAdmin.employments.id }}</b>
                        </VListItemTitle>
                        <VListItemTitle>Employee ID</VListItemTitle>
                      </VCol>
                    </VRow>
                  </div>
                </VCol>
              </VRow>

              <VDivider class="mt-2" />


              <VCard height="auto" class="d-flex flex-column" style="padding-right: -10%;">
                <VCardText class="flex-grow-1 overflow-auto">
                  <v-list>
                    <v-list-item v-for="link in links" :key="link.id" :href="link.href">
                      <v-list-item-content class="d-flex justify-start gap-2">
                        <v-icon size="18">{{ link.icon }}</v-icon>
                        <v-list-item-title style="font-size: medium;" v-text="link.label" />
                      </v-list-item-content>
                    </v-list-item>
                  </v-list>
                </VCardText>
              </VCard>
            </div>
          </div>
        </VCard>
      </v-col>

      <v-col cols="12" md="6" lg="4" v-show="userData">
        <VCard class="d-flex flex-column mb-4" v-if="userData">
          <div>
            <div>
              <div class="profile-card text-center mb-2">
                <div class="profile-card-photo">
                  <VAvatar class="cursor-pointer" color="primary" variant="tonal"
                    style="width: 120px; height: 120px; margin-top: 10%; margin-bottom: 3%;">
                    <VImg :src="avatar1" />
                  </VAvatar>
                </div>
                <div style="font-weight: bold;">{{ userData.employments.user.username }}</div>
                <div style="font-weight: bold;" v-if="userData.employments.user?.user_levels ?? false">{{
                  userData.employments.user.user_levels.name }}</div>
                <div class="mb-4" v-if="userData.employments?.locations ?? false">{{ userData.employments.locations.name
                }}</div>
                <VListItem link>
                  <input ref="fileInputEmployee" type="file" hidden>
                  <v-btn @click="openFileDialogEmployee()" rounded="pill" size="small" class="btn btn-rounded btn-sm">
                    Upload Photo
                  </v-btn> &nbsp;
                </VListItem>

                <VListItem link>
                  <signature />
                </VListItem>
              </div>

              <VDivider />

              <VRow>
                <VCol>
                  <div class="profile-statistic tbl">
                    <VRow>
                      <VCol class="text-center mt-2" style="margin-bottom: -15%;">
                        <VListItemTitle><b v-if="userData?.gender ?? false">{{ userData.gender }}</b></VListItemTitle>
                        <VListItemTitle>Gender</VListItemTitle>
                      </VCol>
                      <VCol class="text-center mt-2">
                        <VListItemTitle><b v-if="userData?.civil_status ?? false">{{ userData.civil_status }}</b>
                        </VListItemTitle>
                        <VListItemTitle>Civil Status</VListItemTitle>
                      </VCol>
                    </VRow>
                  </div>
                </VCol>
              </VRow>

              <VRow>
                <VCol>
                  <div class="profile-statistic tbl">
                    <VRow>
                      <VCol class="text-center mt-2">
                        <VListItemTitle><b v-if="userData?.birthdate ?? false">{{ formatDate(userData.birthdate) }}</b>
                        </VListItemTitle>
                        <VListItemTitle>Date of Birth</VListItemTitle>
                      </VCol>
                      <VCol class="text-center mt-2">
                        <VListItemTitle><b v-if="userData.employments?.id ?? false">{{ userData.employments.id }}</b>
                        </VListItemTitle>
                        <VListItemTitle>Employee ID</VListItemTitle>
                      </VCol>
                    </VRow>
                  </div>
                </VCol>
              </VRow>

              <VDivider class="mt-2" />


              <VCard height="auto" class="d-flex flex-column" style="padding-right: -10%;">
                <VCardText class="flex-grow-1 overflow-auto">
                  <v-list>
                    <v-list-item v-for="link in links" :key="link.id" :href="link.href">
                      <v-list-item-content class="d-flex justify-start gap-2">
                        <v-icon size="18">{{ link.icon }}</v-icon>
                        <v-list-item-title style="font-size: medium;" v-text="link.label" />
                      </v-list-item-content>
                    </v-list-item>
                  </v-list>
                </VCardText>
              </VCard>
            </div>
          </div>
        </VCard>
      </v-col>

      <VCol cols="12" md="6" lg="8" v-show="userData">
        <v-card class="headline mb-8" title="Work Information" id="workInformation" tabindex="-1" v-if="userData">
          <VDivider />
          <v-card-text>
            <v-table>

              <tbody>
                <tr v-for="row in userData.employee_rec" :key="row.id">
                  <td width="300px"><strong>Company</strong></td>
                  <td>{{ row.company }}</td>
                </tr>
                <tr>
                  <td><strong>Department / Line of Business</strong></td>
                  <td>{{ userData.employments.departments.name }}</td>
                </tr>
                <tr>
                  <td><strong>Location</strong></td>
                  <td>{{ userData.employments.locations.name }}</td>
                </tr>
                <!-- <tr>
                                        <td><strong>Client Name</strong></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Job Code</strong></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Job Grade</strong></td>
                                            <td>1</td>
                                        </tr> -->
                <tr>
                  <td><strong>Billability</strong></td>
                  <td>{{ userData.employments.billability }}</td>
                </tr>
                <tr>
                  <td><strong>Employee Type</strong></td>
                  <td>{{ userData.employments.type }}</td>
                </tr>
                <tr>
                  <td><strong>Title</strong></td>
                  <td v-if="userData.employments?.title ?? false">{{ userData.employments.title }}</td>
                </tr>
                <tr>
                  <td><strong>Hire Date</strong></td>
                  <td>{{ formatDate(userData.employments.date_hired) }}</td>
                </tr>
                <tr>
                  <td><strong>Expected Regularization Date</strong></td>
                  <td>{{ formatDate(userData.employments.date_regularization) }}</td>
                </tr>
                <tr>
                  <td><strong>Regularization Date</strong></td>
                  <td>{{ formatDate(userData.employments.date_regularization) }}</td>
                </tr>
                <!-- <tr>
                                            <td><strong>Reports To</strong></td>
                                            <td></td>
                                        </tr> -->
              <tr>
                <td><strong>User Type</strong></td>
                  <td v-if="userData.employments.user.user_levels !== null">{{ userData.employments.user.user_levels.name
                  }}</td>
                </tr>
                <tr>
                  <td><strong>Employment Status</strong></td>
                  <td>{{ userData.employments.employmentstatus.name }}</td>
                </tr>
                <tr>
                  <td><strong>Employee Remarks</strong></td>

                  <td v-if="userData.employments?.remarks ?? false">
                    {{ userData.employments.remarks }}
                  </td>
                </tr>
                <!-- <tr>
                                            <td><strong>Attendance Request Approvers</strong></td>
                                            <td>Level 1 : </td>
                                        </tr> -->
                <tr>
                  <td><strong>Biometric ID</strong></td>
                  <td>{{ userData.employments.biometric }}</td>
                </tr>
                <tr>
                  <td><strong>Payroll Type</strong></td>
                  <td>{{ userData.employments.payroll_type }}</td>
                </tr>
                <tr>
                  <td><strong>Payroll Pie ID</strong></td>
                  <td>{{ userData.employments.payroll_pie_id }}</td>
                </tr>
              </tbody>
            </v-table>
          </v-card-text>
        </v-card>

        <v-card class="mb-8" title="Work Schedule" id="workSchedule" v-if="userData">
          <!-- <VToolbar title="Work Schedule" color="primary"></VToolbar> -->
          <VDivider />
          <v-card-text>
            <VTable class="mb-5">
              <template v-slot:default>
                <tbody>
                  <tr>
                    <td width="300px"><strong>Schedule Type</strong></td>
                    <td v-if="userData.employments?.schedule_types ?? false">{{ userData.employments.schedule_types.name
                    }}
                    </td>
                  </tr>
                  <tr>
                    <td><strong>No of hours to work including break hours</strong></td>
                    <td v-if="userData.employments?.working_hours ?? false">{{ userData.employments.working_hours }}</td>
                  </tr>
                </tbody>
              </template>
            </VTable>
            <VTable>
              <thead>
                <tr>
                  <td><strong>Day</strong></td>
                  <td><strong>Shift Start</strong></td>
                  <td><strong>Shift End</strong></td>
                  <td><strong>Break Start</strong></td>
                  <td><strong>Break End</strong></td>
                  <td><strong>Rest Day</strong></td>
                </tr>
              </thead>
              <tbody>
                <tr v-for="row in userData.schedule" :key="row.day">
                  <td>{{ row.day }}</td>
                  <td>{{ moment(row.shift_start, 'hh:mm A').format('hh:mm A') }}</td>
                  <td>{{ moment(row.shift_end, 'hh:mm A').format('hh:mm A') }}</td>
                  <td>{{ moment(row.break_start, 'hh:mm A').format('hh:mm A') }}</td>
                  <td>{{ moment(row.break_end, 'hh:mm A').format('hh:mm A') }}</td>
                  <td>
                    <VRow>
                      <VCol class="text-center ml-5">
                        <VCheckbox :value="1" :checked="row.rest_day == 1" v-model="row.rest_day" readonly />
                      </VCol>
                    </VRow>
                  </td>
                </tr>
              </tbody>
            </VTable>
          </v-card-text>
        </v-card>

        <v-card v-if="userData" class="headline mb-8" title="Government Information" id="governmentInformation"
          tabindex="-1">
          <VDivider />
          <v-card-text>
            <VTable>

              <tbody>
                <tr>
                <td width="300px"><strong>SSS</strong></td>
                <td v-if="userData.government?.sss ?? false">{{ userData.government.sss }}</td>
              </tr>
              <tr>
                <td><strong>TIN</strong></td>
                <td v-if="userData.government?.tin ?? false">{{ userData.government.tin }}</td>
              </tr>
              <tr>
                <td><strong>Phil Health</strong></td>
                <td v-if="userData.government?.phil_health ?? false">{{ userData.government.phil_health }}</td>
              </tr>
              <tr>
                <td><strong>PAG IBIG</strong></td>
                <td v-if="userData.government?.pag_ibig ?? false">{{ userData.government.pag_ibig }}</td>
              </tr>
              <tr>
                <td><strong>PRC License No.</strong></td>
                <td v-if="userData.government?.prc ?? false">{{ userData.government.prc }}</td>
                </tr>
                <tr>
                  <td><strong>Passport No.</strong></td>
                <td v-if="userData.government?.passport ?? false">{{ userData.government.passport }}</td>
              </tr>
                <tr>
                  <td><strong>Tax Status</strong></td>
                  <td v-if="userData.government?.tax_status ?? false">{{ userData.government.tax_status.name }}</td>
                </tr>
              </tbody>
            </VTable>
          </v-card-text>
        </v-card>

        <v-card v-if="userData" class="headline mb-8" title="Educational Background" id="educationalBackground"
          tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Type</strong></th>
                <th><strong>School</strong></th>
                <th><strong>From</strong></th>
                <th><strong>To</strong></th>
                <th><strong>Degree</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in userData.educations" :key="row.id">
                <td>{{ row.education_type.name }}</td>
                <td>{{ row.school }}</td>
                <td>{{ formatDate(row.from) }}</td>
                <td>{{ formatDate(row.to) }}</td>
                <td>{{ row.degree }}</td>
              </tr>
            </tbody>
          </VTable>
        </v-card>

        <!-- <v-card class="headline mb-8" title="Performance Management" id="performanceManagement" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Goal</strong></th>
                <th><strong>Due Date</strong></th>
                <th><strong>Feddback</strong></th>
                <th><strong>Filename</strong></th>
                <th><strong>Creation Time</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
        </v-card> -->

        <v-card v-if="userData" class="mb-8" title="Contact Information" id="contactInformation">
          <VDivider />
          <v-card-text class="px-3">
            <VTable class="mb-3">
              <template v-slot:default>
                <tbody>
                  <tr>
                    <td><strong>Local Trunk Line</strong></td>
                  <td v-if="userData.contacts?.local_trunk_line ?? false">{{ userData.contacts.local_trunk_line }}</td>
                </tr>
                <tr>
                  <td><strong>Pin</strong></td>
                  <td v-if="userData.contacts?.pin ?? false">{{ userData.contacts.pin }}</td>
                  <td></td>
                </tr>
                <tr>
                  <td><strong>Skype ID</strong></td>
                  <td v-if="userData.contacts?.skype_id ?? false">{{ userData.contacts.skype_id }}</td>
                  <td></td>
                </tr>
              </tbody>
            </template>
          </VTable>
          <v-subheader class="my-3" style="font-size: large;">Emergency Contact Number</v-subheader>
          <vTable class="mb-3 mt-3">
            <template v-slot:default>
                <thead>
                  <tr>
                    <th>Phone No</th>
                    <th>Contact Person</th>
                    <th>Relationship</th>
                    <th>Address</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="row in userData.emergency" :key="row.id">
                    <td>{{ row.phone }}</td>
                    <td>{{ row.name }}</td>
                    <td>{{ row.relationship }}</td>
                    <td>{{ row.address }}</td>
                  </tr>
                </tbody>
              </template>
            </vTable>
            <v-subheader class="my-3" style="font-size: large;">Alternate Phone Number</v-subheader>
            <VTable class="mt-3">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Phone No</th>
                  <th>Contact Person</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="row in userData.alternate" :key="row.id">
                  <td>{{ row.title_id }}</td>
                  <td>{{ row.phone_number }}</td>
                  <td>{{ row.contact_person }}</td>

                </tr>
              </tbody>
            </VTable>
          </v-card-text>
        </v-card>

        <!-- <v-card class="headline mb-8" title="Visa" id="visa" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Visa Type</strong></th>
                <th><strong>Visa Number</strong></th>
                <th><strong>Issue date</strong></th>
                <th><strong>Place of Issue</strong></th>
                <th><strong>Notes</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
        </v-card> -->

        <v-card v-if="userData" class="headline mb-8" title="Dependents" id="dependents" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>First Name</strong></th>
                <th><strong>Middle Name</strong></th>
                <th><strong>Last Name</strong></th>
                <th><strong>Relationship</strong></th>
                <th><strong>Date of Birth</strong></th>
                <th><strong>Gender</strong></th>
                <th><strong>Notes</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in userData.dependents" :key="row.id">
                <td>{{ row.first_name }}</td>
                <td>{{ row.middle_name }}</td>
                <td>{{ row.last_name }}</td>
                <td>{{ row.relationship }}</td>
                <td>{{ formatDate(row.birthdate) }}</td>
                <td>{{ row.gender }}</td>
                <td>{{ row.notes }}</td>
              </tr>
            </tbody>
          </VTable>
        </v-card>

        <v-card v-if="userData" class="headline mb-8" title="Benefits" id="benefits" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Type</strong></th>
                <th><strong>Active</strong></th>
                <th><strong>Effective Date</strong></th>
                <th><strong>Enrollment Date</strong></th>
                <th><strong>Plan</strong></th>
                <th><strong>Beneficiary</strong></th>
                <th><strong>Notes</strong></th>
                <th><strong>Payment Type</strong></th>
              </tr>
            </thead>
            <tbody v-for="row in userData.benefits" :key="row.id">
              <tr>
                <td>{{ row.benefit_type.name }}</td>
                <td>{{ row.active }}</td>
                <td>{{ formatDate(row.effective_date) }}</td>
                <td>{{ formatDate(row.enrollment_date) }}</td>
                <td>{{ userData.plan }}</td>
                <td>{{ userData.beneficiary }}</td>
                <td>{{ userData.plan.notes }}</td>
                <td>{{ userData.payment_type }}</td>


              </tr>
            </tbody>
          </VTable>
        </v-card>

        <v-card v-if="userData" class="mb-8" title="Leave Plans and Usage" id="leavePlans">
          <VDivider />
          <v-container fluid>
            <v-row>
              <v-col cols="12">
                <VListItemTitle>
                  <p class="lead" style="margin-bottom: 1px">
                    Leave Plans and usage
                  </p>
                </VListItemTitle>
                <VListItemTitle>
                  <small class="text-muted">This is a summary of your leave plans.</small>
                </VListItemTitle>
                <hr class="my-3">
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="6" lg="12">
                <VListItemTitle>
                  <p class="lead" style="margin-bottom: 1px">
                    Sick : Default Sick leave
                  </p>
                </VListItemTitle>
                <VListItemTitle class="mb-5">
                  <small class="text-muted">{{ userData.leave_credits_sick.credits }} available credits</small>
                </VListItemTitle>
                <!-- <div class="d-flex justify-end mb-3">
                  <v-btn size="small" class="mr-2" color="primary">
                    <v-icon>mdi-printer</v-icon> Print
                  </v-btn>
                  <v-btn size="small" color="primary">
                    <v-icon>mdi-download</v-icon> Download
                  </v-btn>
                </div> -->

                <VDivider />
                <VTable>
                  <thead>
                    <tr>
                      <th><strong>Transaction Date</strong></th>
                      <th><strong>Usage Date</strong></th>
                      <th><strong>Activity</strong></th>
                      <th><strong>Credit / Debit</strong></th>
                      <th><strong>Reason</strong></th>
                      <th><strong>Status</strong></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                </VTable>
                <p class="text-center mt-3">
                  <strong>Total available credits to date: 0</strong>
              </p>
              <hr class="my-3">
            </v-col>

              <v-col cols="12" sm="6" lg="12" style="margin-top: -8px;">
                <VListItemTitle>
                  <p class="lead" style="margin-bottom: 1px">
                    Vacation : Default Vacation leave
                  </p>
                </VListItemTitle>
                <VListItemTitle class="mb-5">
                  <small class="text-muted">{{ userData.leave_credits_vacation.credits }} available credits</small>
                </VListItemTitle>
                <!-- <div class="d-flex justify-end mb-3">
                  <v-btn size="small" class="mr-2" color="primary">
                    <v-icon>mdi-printer</v-icon> Print
                  </v-btn>
                  <v-btn size="small" color="primary">
                    <v-icon>mdi-download</v-icon> Download
                  </v-btn>
                </div> -->

              <VDivider />
                <VTable>
                  <thead>
                    <tr>
                      <th><strong>Transaction Date</strong></th>
                      <th><strong>Usage Date</strong></th>
                      <th><strong>Activity</strong></th>
                      <th><strong>Credit / Debit</strong></th>
                      <th><strong>Reason</strong></th>
                      <th><strong>Status</strong></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                </VTable>
                <p class="text-center mt-3">
                  <strong>Total available credits to date: 0</strong>
                </p>
              </v-col>
            </v-row>
          </v-container>
        </v-card>

        <v-card v-if="userData" class="headline mb-8" title="Salary" id="salary" tabindex="-1">
          <VDivider />
          <VTable class="px-3">
            <tbody>
              <!-- <tr>
                                        <td width="330px"><strong>SSS</strong></td>
                                        <td></td>
                                    </tr> -->
              <tr>
                <td><strong>Bank</strong></td>
                <td>{{ userData.banks.name }}</td>
              </tr>
              <tr>
                <td><strong>Bank Account No</strong></td>
                <td>{{ userData.banks.account_number }}</td>
              </tr>
              <tr>
                <td><strong>Date From</strong></td>
                <td v-if="userData.salaries?.date_from ?? false">{{ formatDate(userData.salaries.date_from) }}</td>
                <td v-else></td>

              </tr>
              <tr>
                <td><strong>Base Salary</strong></td>
                <td v-if="userData.salaries?.base_salary ?? false">{{ userData.salaries.base_salary }}</td>
              </tr>
              <!-- <tr>
                                        <td><strong>Deminimis</strong></td>
                                        <td>0</td>
                                    </tr> -->
              <tr>
                <td><strong>Others Type</strong></td>
                <td v-if="userData.salaries?.others_type ?? false">{{ userData.salaries.others_type }}</td>
              </tr>
              <tr>
                <td><strong>Other Supplies</strong></td>
                <td v-if="userData.salaries?.other_supplies ?? false">{{ userData.salaries.other_supplies }}</td>
              </tr>
              <tr>
                <td><strong>Monthly Gross</strong></td>
                <td v-if="userData.salaries?.monthly_gross ?? false">{{ userData.salaries.monthly_gross }}</td>
              </tr>
              <tr>
                <td><strong>Percentage Increase</strong></td>
                <td v-if="userData.salaries?.percentage_increase ?? false">{{ userData.salaries.percentage_increase }}</td>
              </tr>
              <tr>
                <td><strong>Raise Amount</strong></td>
                <td v-if="userData.salaries?.raise_amount ?? false">{{ userData.salaries.raise_amount }}</td>
              </tr>
              <tr>
                <td><strong>Raise %</strong></td>
                <td v-if="userData.salaries?.raise_percentage ?? false">{{ userData.salaries.raise_percentage }}</td>
              </tr>
              <tr>
                <td><strong>Comission</strong></td>
                <td v-if="userData.salaries?.commission ?? false">{{ userData.salaries.commission }}</td>
              </tr>
              <tr>
                <td><strong>Action For</strong></td>
                <td v-if="userData.salaries?.salary_action ?? false">{{ userData.salaries.salary_action.name }}</td>
              </tr>
              <tr>
                <td><strong>Notes</strong></td>
                <td v-if="userData.salaries?.notes ?? false">{{ userData.salaries.notes }}</td>
              </tr>
            </tbody>
          </VTable>

          <VCardTitle class="mt-3">
            <p style="font-style: normal;">Allowances</p>
          </VCardTitle>

          <VDivider class="mb-2" />

        <VTable class="px-4">
          <thead>
            <tr>
              <th><strong>Allowances Name</strong></th>
              <th><strong>Amount</strong></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Clothing</td>
              <td v-if="userData.salaries?.clothing ?? false">₱ {{ userData.salaries.clothing }}</td>
            </tr>
            <tr>
              <td>Communication</td>
              <td v-if="userData.salaries?.communication ?? false">₱ {{ userData.salaries.communication }}</td>
            </tr>
            <tr>
              <td>Discretionary</td>
              <td v-if="userData.salaries?.discretionary ?? false">₱ {{ userData.salaries.discretionary }}</td>
            </tr>
            <tr>
              <td>Laundry</td>
              <td v-if="userData.salaries?.laundry ?? false">₱ {{ userData.salaries.laundry }}</td>
            </tr>
            <tr>
              <td>Meal</td>
              <td v-if="userData.salaries?.meal ?? false">₱ {{ userData.salaries.meal }}</td>
            </tr>
            <tr>
              <td>Medical</td>
              <td v-if="userData.salaries?.medical ?? false">₱ {{ userData.salaries.medical }}</td>
            </tr>
            <tr>
              <td>Productivity</td>
              <td v-if="userData.salaries?.productivity ?? false">₱ {{ userData.salaries.productivity }}</td>
            </tr>
            <tr>
              <td>Rice</td>
              <td v-if="userData.salaries?.rice ?? false">₱ {{ userData.salaries.rice }}</td>
            </tr>
            <tr>
              <td>Transportation</td>
              <td v-if="userData.salaries?.transportation ?? false">₱ {{ userData.salaries.transportation }}</td>
            </tr>
            <tr>
              <td>Travel</td>
              <td v-if="userData.salaries?.travel ?? false">₱ {{ userData.salaries.travel }}</td>
            </tr>
            <tr>
              <td>Others</td>
              <td v-if="userData.salaries?.others ?? false">₱ {{ userData.salaries.others }}</td>
            </tr>
          </tbody>
        </VTable>

      </v-card>

      <!-- <v-card v-if="userData" class="headline mb-8" title="Advances" id="advances" tabindex="-1">
                    <VDivider />
                    <VTable>
                        <thead>
                            <tr>
                                <th><strong>Loan Type</strong></th>
                                <th><strong>Date Request</strong></th>
                                <th><strong>Date Released</strong></th>
                                <th><strong>Start of Deduction</strong></th>
                                <th><strong>End of Deduction</strong></th>
                                <th><strong>Total Amount</strong></th>
                                    <th><strong>Pay Periods</strong></th>
                                    <th><strong>Pay Amount / Period</strong></th>
                                    <th><strong>Total Paid Amounts</strong></th>
                                    <th><strong>Balance</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                </tr>
                            </tbody>
                        </VTable>
                        <v-card-text class="text-center">
                          <h3 class="mb-3">
                            Current Outstanding Balance: ₱ 0.00
                          </h3>
                        </v-card-text>
                    </v-card>

                    <v-card v-if="employee" class="headline mb-8" title="Training" id="training" tabindex="-1">
                        <VDivider />
                        <VTable>
                            <thead>
                                <tr>
                                    <th><strong>Training Date</strong></th>
                                    <th><strong>Training Name</strong></th>
                                    <th><strong>Instructor / Institution</strong></th>
                                    <th><strong>Nature of Training</strong></th>
                                    <th><strong>Training Cost</strong></th>
                                    <th><strong>Returning Service Period</strong></th>
                                    <th><strong>Corresponding Amount</strong></th>
                                    <th><strong>Training Notes</strong></th>
                                <th><strong>Start of Training</strong></th>
                                <th><strong>End of Training</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                            </tr>
                        </tbody>
                    </VTable>
                    <v-card-text class="text-center">
                      <VTable>
                        <thead>
                            <tr>
                                    <th class="text-center"><strong>Filename</strong></th>
                                    <th class="text-center"><strong>Creation Time</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                </tr>
                            </tbody>
                          </VTable>
                        </v-card-text>
                    </v-card> -->

        <v-card v-if="userData" class="headline mb-8" title="Assets" id="assets" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Item</strong></th>
                <th><strong>Category</strong></th>
                <th><strong>Condition</strong></th>
                <th><strong>Purchase Price</strong></th>
                <th><strong>Serial Number</strong></th>
                <th><strong>Acquired Date</strong></th>
                <th><strong>Date Issued</strong></th>
                <th><strong>Date Returned</strong></th>
                <th><strong>Notes</strong></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in userData.assets" :key="row.id">
              <td>{{ row.item }}</td>
              <td>{{ row.category_action.name }}</td>
              <td>{{ row.condition_action.name }}</td>
              <td>₱ {{ row.price }}</td>
              <td>{{ row.serial_number }}</td>
              <td>{{ formatDate(row.date_acquired) }}</td>
              <td>{{ formatDate(row.date_issued) }}</td>
              <td>{{ formatDate(row.date_returned) }}</td>
              <td>{{ row.notes }}</td>
            </tr>
            </tbody>
          </VTable>
          <!-- <v-card-text class="text-center">
                      <VTable>
                        <thead>
                            <tr>
                                <th class="text-center"><strong>Filename</strong></th>
                                <th class="text-center"><strong>Creation Time</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                            </tr>
                        </tbody>
                      </VTable>
                    </v-card-text> -->
      </v-card>

        <v-card v-if="userData" class="headline mb-8" title="Memo" id="memo" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Offense Level</strong></th>
                <th><strong>DA Type</strong></th>
                <th><strong>Infraction / Violation Category</strong></th>
                <th><strong>Date Served & Received</strong></th>
                <th><strong>Slide Date</strong></th>
                <th><strong>Notes</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in userData.memo" :key="row.id">
                <td>{{ row.offense_level.name }}</td>
                <td>{{ row.da_Types.name }}</td>
                <td>{{ row.memo_subject }}</td>
                <td>{{ formatDate(row.memo_date) }}</td>
                <td>{{ formatDate(row.slide_date) }}</td>
                <td>{{ row.memo_note }}</td>
              </tr>
            </tbody>
          </VTable>
          <!-- <v-card-text class="text-center">
                          <VTable>
                            <thead>
                                <tr>
                                    <th class="text-center"><strong>Filename</strong></th>
                                    <th class="text-center"><strong>Creation Time</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                </tr>
                            </tbody>
                          </VTable>
                        </v-card-text> -->
        </v-card>

        <!-- <v-card class="headline mb-8" title="Seminars / Service Training Attended" id="seminarsAttended" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Course / Training</strong></th>
                <th><strong>Location</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
        </v-card> -->

        <v-card v-if="userData" class="headline mb-8" title="Employment Record" id="employeeRecord" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Position</strong></th>
                <th><strong>Company</strong></th>
                <th><strong>Industry</strong></th>
                <th><strong>From</strong></th>
                <th><strong>To</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in userData.employee_rec" :key="row.id">
                <td>{{ row.position }}</td>
                <td>{{ row.company }}</td>
                <td>{{ row.industry }}</td>
                <td>{{ formatDate(row.from) }}</td>
                <td>{{ formatDate(row.to) }}</td>
              </tr>
            </tbody>
          </VTable>
        </v-card>

        <v-card v-if="userData" class="headline mb-8" title="Movement" id="movement" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>From</strong></th>
                <th><strong>To</strong></th>
                <th><strong>Position</strong></th>
                <th><strong>Department / Account</strong></th>
                <th><strong>Employment Type</strong></th>
                <th><strong>Employment Status</strong></th>
                <th><strong>Position</strong></th>
                <th><strong>Department / Account</strong></th>
                <th><strong>Employment Type</strong></th>
                <th><strong>Employment Status</strong></th>
                <th><strong>Action For</strong></th>
                <th><strong>Notes</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in userData.movements" :key="row.id">
                <td>{{ formatDate(row.date_from) }}</td>
                <td>{{ formatDate(row.date_to) }}</td>
                <td>{{ row.from_position }}</td>
                <td>{{ row.from_department }}</td>
                <td>{{ row.employment_type.name }}</td>
                <td>{{ row.employment_status.name }}</td>
                <td>{{ row.to_position }}</td>
                <td>{{ row.to_department }}</td>
                <td>{{ row.employment_type.name }}</td>
                <td>{{ row.employment_status.name }}</td>
                <td>{{ row.action_for }}</td>
                <td>{{ row.notes }}</td>

              </tr>
            </tbody>
          </VTable>
        </v-card>

        <v-card v-if="userData" class="headline mb-8" title="Documents" id="documents" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>File Name</strong></th>
                <th><strong>Creation Time</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in userData.documents" :key="row.id">
                <td>{{ row.file_name }}</td>
                <td>{{ row.creation_time }}</td>
              </tr>
            </tbody>
          </VTable>
        </v-card>

        <v-card v-if="userData" class="headline mb-8" title="Medical Records" id="medicalRecords" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>File Name</strong></th>
                <th><strong>Creation Time</strong></th>
                <th><strong>Classificaiton</strong></th>
                <th><strong>Notes</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in userData.medical_record" :key="row.id">
                <td>{{ row.file_name }}</td>
                <td>{{ row.creation_time }}</td>
                <td>{{ row.classification }}</td>
                <td>{{ row.notes }}</td>
              </tr>
            </tbody>
          </VTable>
        </v-card>

        <v-card v-if="userData" class="headline mb-8" title="Requirements" id="requirements" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Completed</strong></th>
                <th><strong>Requirement Name</strong></th>
                <th><strong>Notes</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in userData.requirements" :key="row.id">
                <td class="text-center">
                  <VCol hidden>
                    <VTextField type="number" v-model="row.require_id" />
                  </VCol>
                  <VCol hidden>
                    <VTextField type="number" v-model="row.r_id" readonly />
                  </VCol>
                  <VChip color="success" v-if="row.completed == 1">
                    Completed
                  </VChip>
                  <VChip color="error" v-if="row.completed == 0">
                    Not Complete
                  </VChip>
                </td>
                <td style="padding-left:5vw">
                  {{ row.requirement_name }}
                </td>
                <td>{{ row.notes }}</td>
              </tr>
            </tbody>
          </VTable>
        </v-card>

        <v-card v-if="userData" class="headline mb-8" title="Access Level" id="accessLevel" tabindex="-1">
          <VDivider />
          <v-card-text>
            <VTable>
              <tbody>
                <tr>
                  <td width="300px">Employee Code</td>
                  <td>{{ userData.id }}</td>
                </tr>
                <tr>
                  <td>Login Name</td>
                  <td>{{ userData.employments.user.username }}</td>
                </tr>
                <tr>
                  <td>User Level</td>
                  <td>{{ userData.employments.user.user_levels.name }}</td>
                </tr>
                <tr>
                  <td>Password</td>
                  <td>********** {{ userData.employments.user.password }}</td>
                </tr>
              </tbody>
            </VTable>
          </v-card-text>
        </v-card>

      </VCol>

      <VCol cols="12" md="6" lg="8" v-show="userAdmin">
                <v-card class="headline mb-8" title="Work Information" id="workInformation" tabindex="-1">
                    <VDivider />
                    <v-card-text>
                        <v-table>

                            <tbody>
                                <tr>
                                    <td width="300px"><strong>Company</strong></td>
                                    <td>Specialized Outsource Partners, Inc.</td>
                                </tr>
                                <tr>
                                    <td><strong>Department / Line of Business</strong></td>
                                    <td>IT</td>
                                </tr>
                                <tr>
                                    <td><strong>Location</strong></td>
                                    <td>3rd Floor Cartalitz Bldg</td>
                                </tr>
                                <tr>
                                    <td><strong>Client Name</strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>Job Code</strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>Job Grade</strong></td>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <td><strong>Billability</strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>Employee Type</strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>Title</strong></td>
                                    <td>Web Developer</td>
                                </tr>
                                <tr>
                                    <td><strong>Hire Date</strong></td>
                                    <td>05 / 20 / 2018</td>
                                </tr>
                                <tr>
                                    <td><strong>Expected Regularization Date</strong></td>
                                    <td>05 / 20 / 2018</td>
                                </tr>
                                <tr>
                                    <td><strong>Regularization Date</strong></td>
                                    <td>05 / 20 / 2018</td>
                                </tr>
                                <tr>
                                    <td><strong>Reports To</strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>User Type</strong></td>
                                    <td>Employee</td>
                                </tr>
                                <tr>
                                    <td><strong>Employment Status</strong></td>
                                    <td>Probationary</td>
                                </tr>
                                <tr>
                                    <td><strong>Employee Remarks</strong></td>

                                    <td>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Officia assumenda
                                        earum rerum aspernatur odio adipisci
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Attendance Request Approvers</strong></td>
                                    <td>Level 1 : </td>
                                </tr>
                                <tr>
                                    <td><strong>Biometric ID</strong></td>
                                    <td>82</td>
                                </tr>
                                <tr>
                                    <td><strong>Payroll Type</strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><strong>Payroll Pie ID</strong></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </v-table>
                    </v-card-text>
                </v-card>

        <v-card class="mb-8" title="Work Schedule" id="workSchedule">
          <!-- <v-card-title class="headline grey lighten-2">
                        
                      </v-card-title> -->
          <VDivider />
          <v-card-text>
            <VTable class="mb-5">
              <template v-slot:default>
                <tbody>
                  <tr>
                    <td width="300px"><strong>Schedule Type</strong></td>
                    <td>Normal Shift</td>
                  </tr>
                  <tr>
                    <td><strong>No of hours to work including break hours</strong></td>
                    <td>9</td>
                  </tr>
                </tbody>
              </template>
            </VTable>
            <VTable>
              <thead>
                <tr>
                  <td><strong>Day</strong></td>
                  <td><strong>Shift Start</strong></td>
                  <td><strong>Shift End</strong></td>
                  <td><strong>Break Start</strong></td>
                  <td><strong>Break End</strong></td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Sunday</td>
                  <td>--:-- --</td>
                  <td>--:-- --</td>
                  <td>--:-- --</td>
                  <td>--:-- --</td>
                </tr>
                <tr>
                  <td>Monday</td>
                  <td>10:00 PM</td>
                  <td>07:00 AM</td>
                  <td>02:00 AM</td>
                  <td>03:00 AM</td>
                </tr>
                <tr>
                  <td>Tuesday</td>
                  <td>10:00 PM</td>
                  <td>07:00 AM</td>
                  <td>02:00 AM</td>
                  <td>03:00 AM</td>
                </tr>
                <tr>
                  <td>Wednesday</td>
                  <td>10:00 PM</td>
                  <td>07:00 AM</td>
                  <td>02:00 AM</td>
                  <td>03:00 AM</td>
                </tr>
                <tr>
                  <td>Thursday</td>
                  <td>10:00 PM</td>
                  <td>07:00 AM</td>
                  <td>02:00 AM</td>
                  <td>03:00 AM</td>
                </tr>
                <tr>
                  <td>Friday</td>
                  <td>10:00 PM</td>
                  <td>07:00 AM</td>
                  <td>02:00 AM</td>
                  <td>03:00 AM</td>
                </tr>
                <tr>
                  <td>Saturday</td>
                  <td>10:00 PM</td>
                  <td>07:00 AM</td>
                  <td>02:00 AM</td>
                  <td>03:00 AM</td>
                </tr>
              </tbody>
            </VTable>
          </v-card-text>
        </v-card>

        <v-card class="headline mb-8" title="Government Information" id="governmentInformation" tabindex="-1">
          <VDivider />
          <v-card-text>
            <VTable>

              <tbody>
                <tr>
                  <td width="300px"><strong>SSS</strong></td>
                  <td></td>
                </tr>
                <tr>
                  <td><strong>TIN</strong></td>
                  <td></td>
                </tr>
                <tr>
                  <td><strong>Phil Health</strong></td>
                  <td></td>
                </tr>
                <tr>
                  <td><strong>PAG IBIG</strong></td>
                  <td></td>
                </tr>
                <tr>
                  <td><strong>PRC License No.</strong></td>
                  <td></td>
                </tr>
                <tr>
                  <td><strong>Passport No.</strong></td>
                  <td></td>
                </tr>
                <tr>
                  <td><strong>Tax Status</strong></td>
                  <td>M1</td>
                </tr>
              </tbody>
            </VTable>
          </v-card-text>
        </v-card>

        <v-card class="headline mb-8" title="Educational Background" id="educationalBackground" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Type</strong></th>
                <th><strong>School</strong></th>
                <th><strong>From</strong></th>
                <th><strong>To</strong></th>
                <th><strong>Degree</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
        </v-card>

        <v-card class="headline mb-8" title="Performance Management" id="performanceManagement" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Goal</strong></th>
                <th><strong>Due Date</strong></th>
                <th><strong>Feddback</strong></th>
                <th><strong>Filename</strong></th>
                <th><strong>Creation Time</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
        </v-card>

        <v-card class="mb-8" title="Contact Information" id="contactInformation">
          <!-- <v-card-title class="headline">
                          Contact Information
                      </v-card-title> -->
          <VDivider />
          <v-card-text class="px-3">
            <VTable class="mb-3">
              <template v-slot:default>
                <tbody>
                  <tr>
                    <td><strong>Local Trunk Line</strong></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><strong>Pin</strong></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><strong>Skype ID</strong></td>
                    <td></td>
                  </tr>
                </tbody>
              </template>
            </VTable>
            <v-subheader class="my-3" style="font-size: large;">Emergency Contact Number</v-subheader>
            <vTable class="mb-3 mt-3">
              <template v-slot:default>
                <tbody>
                  <tr>
                    <td><strong>Phone No</strong></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><strong>Contact Person</strong></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><strong>Relationship</strong></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><strong>Address</strong></td>
                    <td></td>
                  </tr>
                </tbody>
              </template>
            </vTable>
            <v-subheader class="my-3" style="font-size: large;">Alternate Phone Number</v-subheader>
            <VTable class="mt-3">
              <template v-slot:default>
                <tbody>
                  <tr>
                    <td><strong>Title</strong></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><strong>Phone No</strong></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><strong>Contact Person</strong></td>
                    <td></td>
                  </tr>
                </tbody>
              </template>
            </VTable>
          </v-card-text>
        </v-card>

        <v-card class="headline mb-8" title="Visa" id="visa" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Visa Type</strong></th>
                <th><strong>Visa Number</strong></th>
                <th><strong>Issue date</strong></th>
                <th><strong>Place of Issue</strong></th>
                <th><strong>Notes</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
        </v-card>

        <v-card class="headline mb-8" title="Dependents" id="dependents" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>First Name</strong></th>
                <th><strong>Middle Name</strong></th>
                <th><strong>Last Name</strong></th>
                <th><strong>Relationship</strong></th>
                <th><strong>Date of Birth</strong></th>
                <th><strong>Gender</strong></th>
                <th><strong>Notes</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
        </v-card>


        <v-card class="headline mb-8" title="Benefits" id="benefits" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Type</strong></th>
                <th><strong>Active</strong></th>
                <th><strong>Effective Date</strong></th>
                <th><strong>Enrollment Date</strong></th>
                <th><strong>Plan</strong></th>
                <th><strong>Beneficiary</strong></th>
                <th><strong>Notes</strong></th>
                <th><strong>Payment Type</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
        </v-card>

        <v-card class="mb-8" title="Leave Plans and Usage" id="leavePlans">
          <VDivider />
          <v-container fluid>
            <v-row>
              <v-col cols="12">
                <VListItemTitle>
                  <p class="lead" style="margin-bottom: 1px">
                    Leave Plans and usage
                  </p>
                </VListItemTitle>
                <VListItemTitle>
                  <small class="text-muted">This is a summary of your leave plans.</small>
                </VListItemTitle>
                <hr class="my-3">
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="6" lg="12">
                <VListItemTitle>
                  <p class="lead" style="margin-bottom: 1px">
                    Sick : Default Sick leave
                  </p>
                </VListItemTitle>
                <VListItemTitle class="mb-5">
                  <small class="text-muted">0 available credits</small>
                </VListItemTitle>
                <div class="d-flex justify-end mb-3">
                  <v-btn size="small" class="mr-2" color="primary">
                    <v-icon>mdi-printer</v-icon> Print
                  </v-btn>
                  <v-btn size="small" color="primary">
                    <v-icon>mdi-download</v-icon> Download
                  </v-btn>
                </div>

                <VDivider />
                <VTable>
                  <thead>
                    <tr>
                      <th><strong>Transaction Date</strong></th>
                      <th><strong>Usage Date</strong></th>
                      <th><strong>Activity</strong></th>
                      <th><strong>Credit / Debit</strong></th>
                      <th><strong>Reason</strong></th>
                      <th><strong>Status</strong></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td></td>
                    </tr>
                  </tbody>
                </VTable>
                <p class="text-center mt-3">
                  <strong>Total available credits to date: 0</strong>
                </p>
                <hr class="my-3">
              </v-col>

              <v-col cols="12" sm="6" lg="12" style="margin-top: -8px;">
                <VListItemTitle>
                  <p class="lead" style="margin-bottom: 1px">
                    Vacation : Default Vacation leave
                  </p>
                </VListItemTitle>
                <VListItemTitle class="mb-5">
                  <small class="text-muted">0 available credits</small>
                </VListItemTitle>
                <div class="d-flex justify-end mb-3">
                  <v-btn size="small" class="mr-2" color="primary">
                    <v-icon>mdi-printer</v-icon> Print
                  </v-btn>
                  <v-btn size="small" color="primary">
                    <v-icon>mdi-download</v-icon> Download
                  </v-btn>
                </div>

                <VDivider />
                <VTable>
                  <thead>
                    <tr>
                      <th><strong>Transaction Date</strong></th>
                      <th><strong>Usage Date</strong></th>
                      <th><strong>Activity</strong></th>
                      <th><strong>Credit / Debit</strong></th>
                      <th><strong>Reason</strong></th>
                      <th><strong>Status</strong></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td></td>
                    </tr>
                  </tbody>
                </VTable>
                <p class="text-center mt-3">
                  <strong>Total available credits to date: 0</strong>
                </p>
              </v-col>
            </v-row>
          </v-container>
        </v-card>

        <v-card class="headline mb-8" title="Salary" id="salary" tabindex="-1">
          <VDivider />
          <VTable class="px-3">
            <tbody>
              <tr>
                <td width="330px"><strong>SSS</strong></td>
                <td></td>
              </tr>
              <tr>
                <td><strong>Bank</strong></td>
                <td></td>
              </tr>
              <tr>
                <td><strong>Bank Account No</strong></td>
                <td></td>
              </tr>
              <tr>
                <td><strong>Date From</strong></td>
                <td>01 / 01 / 1900</td>
              </tr>
              <tr>
                <td><strong>Base Salary</strong></td>
                <td> ₱ 10,000.00</td>
              </tr>
              <tr>
                <td><strong>Deminimis</strong></td>
                <td>0</td>
              </tr>
              <tr>
                <td><strong>Others Type</strong></td>
                <td></td>
              </tr>
              <tr>
                <td><strong>Other Supplies</strong></td>
                <td>0</td>
              </tr>
              <tr>
                <td><strong>Monthly Gross</strong></td>
                <td>₱ 10,000.00</td>
              </tr>
              <tr>
                <td><strong>Percentage Increase</strong></td>
                <td>0.00</td>
              </tr>
              <tr>
                <td><strong>Raise Amount</strong></td>
                <td>0.00</td>
              </tr>
              <tr>
                <td><strong>Raise %</strong></td>
                <td>0.00</td>
              </tr>
              <tr>
                <td><strong>Comission</strong></td>
                <td></td>
              </tr>
              <tr>
                <td><strong>Action For</strong></td>
                <td></td>
              </tr>
              <tr>
                <td><strong>Notes</strong></td>
                <td></td>
              </tr>
            </tbody>
          </VTable>

          <VCardTitle class="mt-3">
            <p style="font-style: normal;">Allowances</p>
          </VCardTitle>

          <VDivider class="mb-2" />

          <VTable class="px-4">
            <thead>
              <tr>
                <th><strong>Allowances Name</strong></th>
                <th><strong>Amount</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Clothing</td>
                <td>₱ 0.00</td>
              </tr>
              <tr>
                <td>Communication</td>
                <td>₱ 0.00</td>
              </tr>
              <tr>
                <td>Discretionary</td>
                <td>₱ 0.00</td>
              </tr>
              <tr>
                <td>Laundry</td>
                <td>₱ 0.00</td>
              </tr>
              <tr>
                <td>Meal</td>
                <td>₱ 0.00</td>
              </tr>
              <tr>
                <td>Medical</td>
                <td>₱ 0.00</td>
              </tr>
              <tr>
                <td>Productivity</td>
                <td>₱ 0.00</td>
              </tr>
              <tr>
                <td>Rice</td>
                <td>₱ 0.00</td>
              </tr>
              <tr>
                <td>Transportation</td>
                <td>₱ 0.00</td>
              </tr>
              <tr>
                <td>Travel</td>
                <td>₱ 0.00</td>
              </tr>
              <tr>
                <td>Others</td>
                <td>₱ 0.00</td>
              </tr>
            </tbody>
          </VTable>

        </v-card>

        <v-card class="headline mb-8" title="Advances" id="advances" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Loan Type</strong></th>
                <th><strong>Date Request</strong></th>
                <th><strong>Date Released</strong></th>
                <th><strong>Start of Deduction</strong></th>
                <th><strong>End of Deduction</strong></th>
                <th><strong>Total Amount</strong></th>
                <th><strong>Pay Periods</strong></th>
                <th><strong>Pay Amount / Period</strong></th>
                <th><strong>Total Paid Amounts</strong></th>
                <th><strong>Balance</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
          <v-card-text class="text-center">
            <h3 class="mb-3">
              Current Outstanding Balance: ₱ 0.00
            </h3>
          </v-card-text>
        </v-card>

        <v-card class="headline mb-8" title="Training" id="training" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Training Date</strong></th>
                <th><strong>Training Name</strong></th>
                <th><strong>Instructor / Institution</strong></th>
                <th><strong>Nature of Training</strong></th>
                <th><strong>Training Cost</strong></th>
                <th><strong>Returning Service Period</strong></th>
                <th><strong>Corresponding Amount</strong></th>
                <th><strong>Training Notes</strong></th>
                <th><strong>Start of Training</strong></th>
                <th><strong>End of Training</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
          <v-card-text class="text-center">
            <VTable>
              <thead>
                <tr>
                  <th class="text-center"><strong>Filename</strong></th>
                  <th class="text-center"><strong>Creation Time</strong></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td></td>
                </tr>
              </tbody>
            </VTable>
          </v-card-text>
        </v-card>

        <v-card class="headline mb-8" title="Assets" id="assets" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Item</strong></th>
                <th><strong>Category</strong></th>
                <th><strong>Condition</strong></th>
                <th><strong>Purchase Price</strong></th>
                <th><strong>Serial Number</strong></th>
                <th><strong>Acquired Date</strong></th>
                <th><strong>Date Issued</strong></th>
                <th><strong>Date Returned</strong></th>
                <th><strong>Notes</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
          <v-card-text class="text-center">
            <VTable>
              <thead>
                <tr>
                  <th class="text-center"><strong>Filename</strong></th>
                  <th class="text-center"><strong>Creation Time</strong></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td></td>
                </tr>
              </tbody>
            </VTable>
          </v-card-text>
        </v-card>

        <v-card class="headline mb-8" title="Memo" id="memo" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Offense Level</strong></th>
                <th><strong>DA Type</strong></th>
                <th><strong>Infraction / Violation Category</strong></th>
                <th><strong>Date Served & Received</strong></th>
                <th><strong>Slide Date</strong></th>
                <th><strong>Notes</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
          <v-card-text class="text-center">
            <VTable>
              <thead>
                <tr>
                  <th class="text-center"><strong>Filename</strong></th>
                  <th class="text-center"><strong>Creation Time</strong></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td></td>
                </tr>
              </tbody>
            </VTable>
          </v-card-text>
        </v-card>

        <v-card class="headline mb-8" title="Seminars / Service Training Attended" id="seminarsAttended" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Course / Training</strong></th>
                <th><strong>Location</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
        </v-card>

        <v-card class="headline mb-8" title="Employment Record" id="employeeRecord" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Position</strong></th>
                <th><strong>Company</strong></th>
                <th><strong>Industry</strong></th>
                <th><strong>From</strong></th>
                <th><strong>To</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
        </v-card>

        <v-card class="headline mb-8" title="Movement" id="movement" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>From</strong></th>
                <th><strong>To</strong></th>
                <th><strong>Position</strong></th>
                <th><strong>Department / Account</strong></th>
                <th><strong>Employment Type</strong></th>
                <th><strong>Employment Status</strong></th>
                <th><strong>Position</strong></th>
                <th><strong>Department / Account</strong></th>
                <th><strong>Employment Type</strong></th>
                <th><strong>Employment Status</strong></th>
                <th><strong>Action For</strong></th>
                <th><strong>Notes</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
        </v-card>

        <v-card class="headline mb-8" title="Documents" id="documents" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>File Name</strong></th>
                <th><strong>Creation Time</strong></th>
                <th><strong>Action</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
        </v-card>

        <v-card class="headline mb-8" title="Medical Records" id="medicalRecords" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>File Name</strong></th>
                <th><strong>Creation Time</strong></th>
                <th><strong>Classificaiton</strong></th>
                <th><strong>Notes</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
        </v-card>

        <v-card class="headline mb-8" title="Requirements" id="requirements" tabindex="-1">
          <VDivider />
          <VTable>
            <thead>
              <tr>
                <th><strong>Completed</strong></th>
                <th><strong>Requirement Name</strong></th>
                <th><strong>Notes</strong></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
              </tr>
            </tbody>
          </VTable>
        </v-card>

        <v-card class="headline mb-8" title="Access Level" id="accessLevel" tabindex="-1">
          <VDivider />
          <v-card-text>
            <VTable>

              <tbody>
                <tr>
                  <td width="300px">Employee Code</td>
                  <td></td>
                </tr>
                <tr>
                  <td>Login Name</td>
                  <td>jhondoe</td>
                </tr>
                <tr>
                  <td>User Level</td>
                  <td>Employee</td>
                </tr>
                <tr>
                  <td>Password</td>
                  <td></td>
                </tr>
              </tbody>
            </VTable>
          </v-card-text>
        </v-card>

      </VCol>
    </v-row>
  </section>
</template>

<style>
.overflow-auto::-webkit-scrollbar {
  block-size: 0;
  inline-size: 0;
}

.overflow-auto:hover::-webkit-scrollbar {
  block-size: 6px;
  inline-size: 6px;
}

.overflow-auto::-webkit-scrollbar-thumb {
  border-radius: 3px;
  background-color: #3a7fc9;
  transition: background-color 0.2s ease-in-out;
}

.overflow-auto::-webkit-scrollbar-thumb:hover {
  background-color: #255da8;
}

.scrollbar {
  overflow-y: auto;
  scrollbar-width: thin;
}
</style>
