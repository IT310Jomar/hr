<script setup lang="ts">
import avatar1 from '@images/avatars/avatar-2.png'
</script>

<template>
  <VBadge
    dot
    location="bottom right"
    offset-x="3"
    offset-y="3"
    bordered
    color="success"
    class="mr-5 ml-4"
  >
  
  <VBtn
    variant="text"
    color="default"
    icon
    size="x-small"
  >
    <VIcon
      size="24"
      icon="tabler-tool"
    />

      <!-- SECTION Menu -->
      <VMenu
        activator="parent"
        width="210"
        location="bottom end"
        offset="14px"
      >
        <VList>
          <!-- 👉 Assets -->
          <VListItem link to="/admin/maintenance/assets">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-asset"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Assets</VListItemTitle>
          </VListItem>

          <!-- 👉 Locations -->
          <VListItem link to="/admin/maintenance/locations">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-location"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Locations</VListItemTitle>
          </VListItem>

          <!-- 👉 Biometrics -->
          <VListItem link to="/admin/maintenance/biometrics">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-user-search"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Biometrics</VListItemTitle>
          </VListItem>

          <!-- 👉 Access Levels -->
          <VListItem link to="/admin/maintenance/access-levels">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-accessible"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Access Levels</VListItemTitle>
          </VListItem>

          <!-- 👉 Leave Settings -->
          <VListItem link to="/admin/maintenance/leave-setting">
            <template #prepend>
              <VIcon
                class="me-2"
                icon="tabler-file-settings"
                size="18"
              />
            </template>

            <VListItemTitle style="font-size: 15px;">Leave Settings</VListItemTitle>
          </VListItem>
        </VList>
      </VMenu>
      <!-- !SECTION -->
    </VBtn>
  </VBadge>
</template>
