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
    color="error"
    class="mr-5"
  >
  
  <VBtn
    variant="text"
    color="default"
    icon
    size="x-small"
  >
    <VIcon
      size="24"
      icon="tabler-bell-filled"
    />

      <!-- SECTION Menu -->
      <VMenu
        activator="parent"
        width="350"
        location="bottom end"
        offset="14px"
      >
        <VList>
          <!-- 👉 Notification -->
          <VListItem>
            <!-- <template #prepend>
              <VListItemAction start>
                <VBadge
                  dot
                  location="bottom right"
                  offset-x="3"
                  offset-y="3"
                  color="success"
                >
                  <VAvatar
                    color="primary"
                    variant="tonal"
                  >
                    <VImg :src="avatar1" />
                  </VAvatar>
                </VBadge>
              </VListItemAction>
            </template> -->

            <VListItemTitle class="font-weight-semibold">
              Notifications
            <!-- bordered -->
            <VBadge
              content="4"
              inline
            >
            </VBadge>
            </VListItemTitle>
          </VListItem>

          <VDivider class="my-2" />

          <!-- 👉 Message -->
          <VListItem link>
            <template #prepend>
              <VIcon
                class="mr-2"
                icon="tabler-user-circle"
                size="45"
              />
            </template>
              <VListItemTitle style="font-size: 14px;">
                <span class="text-primary" style="margin-left: 5%; margin-right: 1%;">Morgan</span>
              <VBadge
                dot
                location="bottom end"
                offset-x="220"
                offset-y="3"
                bordered
                color="error"
              >
              <span>was comment something</span>
              </VBadge>
              </VListItemTitle>
              <div class="text-center">7 hours ago</div>
          </VListItem>

          <VListItem link>
            <template #prepend>
              <VIcon
                class="mr-2"
                icon="tabler-user-circle"
                size="45"
              />
            </template>
              <VListItemTitle style="font-size: 14px;">
                <span class="text-primary" style="margin-left: 5%; margin-right: 1%;">Lioneli</span>
              <VBadge
                dot
                location="bottom end"
                offset-x="205"
                offset-y="3"
                bordered
                color="error"
              >
              <span>was important message</span>
              </VBadge>
              </VListItemTitle>
              <div class="text-center">2 hours ago</div>
          </VListItem>

          <VListItem link>
            <template #prepend>
              <VIcon
                class="mr-2"
                icon="tabler-user-circle"
                size="45"
              />
            </template>
              <VListItemTitle style="font-size: 14px;">
                <span class="text-primary" style="margin-left: 5%; margin-right: 1%;">Xavier</span>
              <VBadge
                dot
                location="bottom end"
                offset-x="210"
                offset-y="3"
                bordered
                color="error"
              >
              <span>was comment something</span>
              </VBadge>
              </VListItemTitle>
              <div class="text-center">7 hours ago</div>
          </VListItem>

          <!-- Divider -->
          <VDivider class="my-2" />

          <!-- 👉 See more -->
          <VListItem link>
            <VListItemTitle style="font-size: 14px;" class="text-center">See More</VListItemTitle>
          </VListItem>
        </VList>
      </VMenu>
      <!-- !SECTION -->
    </VBtn>
  </VBadge>
</template>
