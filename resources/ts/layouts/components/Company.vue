<script setup lang="ts">
import avatar1 from '@images/avatars/avatar-2.png'

const userRole = JSON.parse(localStorage.getItem('userRole') || 'null')

</script>

<template>
  <VBadge
    dot
    location="bottom right"
    offset-x="3"
    offset-y="3"
    bordered
    color="success"
    class="mr-5 ml-3"
  >
  
  <VBtn
    variant="text"
    color="default"
    icon
    size="x-small"
  >
    <VIcon
      size="24"
      icon="tabler-building"
    />

      <!-- SECTION Menu -->
      <VMenu
        activator="parent"
        width="225"
        location="bottom end"
        offset="14px"
      >
        <VList>
          <!-- 👉 Calendar -->
          <VListItem link to="/admin/company/calendar/calendar">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-calendar"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Calendar</VListItemTitle>
          </VListItem>

          <!-- 👉 Employee Directory -->
          <VListItem link to="/admin/company/employee-directory/employee" v-if="userRole == 'God Mode' || userRole == 'Administrator'">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-user-check"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Employee Directory</VListItemTitle>
          </VListItem>

          <!-- 👉 Employee Search -->
          <VListItem link to="/admin/company/employee-directory/employee_search" v-if="userRole == 'God Mode' || userRole == 'Administrator'">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-user-search"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Employee Search</VListItemTitle>
          </VListItem>

          <!-- 👉 HR -->
          <VListItem link to="/admin/company/analytics/hr" v-if="userRole == 'God Mode' || userRole == 'Administrator'">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-report-analytics"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">HR Analytics</VListItemTitle>
          </VListItem>
        </VList>
      </VMenu>
      <!-- !SECTION -->
    </VBtn>
  </VBadge>
</template>
