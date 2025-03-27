<script setup lang="ts">
import avatar1 from '@images/avatars/avatar-2.png'
</script>

<template>
  
  <VBtn
    color="secondary"
    size="small"
    class="mr-5 mb-2"
    style="margin-top: -13%;"
  >
    <template #prepend>
      <VIcon
        size="20"
        icon="tabler-square-rounded-chevron-down"
      />
    </template>
    <VListItemTitle style="font-size: 20px;">Apply</VListItemTitle>

      <!-- SECTION Menu -->
      <VMenu
        activator="parent"
        width="240"
        location="bottom end"
        offset="14px"
      >
        <VList>

          <!-- 👉 Leave -->
          <VListItem link to="/sidebarLayout/sick_vacation_leave/SickVacationLeave">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-road-sign"
                size="20"
              />
            </template>

            <VListItemTitle style="font-size: 16px;">Leave</VListItemTitle>
          </VListItem>

          <!-- 👉 Overtime -->
          <VListItem link to="/sidebarLayout/overtime/Overtime">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-brand-days-counter"
                size="20"
              />
            </template>

            <VListItemTitle style="font-size: 16px;">Overtime</VListItemTitle>
          </VListItem>

          <!-- 👉 Undertime -->
          <VListItem link to="/sidebarLayout/undertime/Undertime">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-clock-2"
                size="20"
              />
            </template>

            <VListItemTitle style="font-size: 16px;">Undertime</VListItemTitle>
          </VListItem>

          <!-- 👉 Memo -->
          <VListItem link to="/sidebarLayout/official_business/OfficialBusiness">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-zoom-exclamation"
                size="20"
              />
            </template>

            <VListItemTitle style="font-size: 16px;">Official Business</VListItemTitle>
          </VListItem>


          <!-- 👉 Schedule Adjustment -->
          <VListItem link to="/sidebarLayout/schedule_adjustment/ScheduleAdjustment">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-calendar-time"
                size="20"
              />
            </template>

            <VListItemTitle style="font-size: 16px;">Schedule Adjustment</VListItemTitle>
          </VListItem>
          
        </VList>
      </VMenu>
      <!-- !SECTION -->
    </VBtn>
</template>
