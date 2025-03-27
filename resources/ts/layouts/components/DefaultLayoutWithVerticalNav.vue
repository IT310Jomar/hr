<script lang="ts" setup>
    import navItems from '@/navigation/vertical'
    import {
        useThemeConfig
    } from '@core/composable/useThemeConfig'

    // Components
    import Footer from '@/layouts/components/Footer.vue'
    import NavbarThemeSwitcher from '@/layouts/components/NavbarThemeSwitcher.vue'
    import UserProfile from '@/layouts/components/UserProfile.vue'
    import Notification from '@/layouts/components/Notification.vue'
    import Company from '@/layouts/components/Company.vue'
    import Settings from '@/layouts/components/Settings.vue'
    import Analytics from '@/layouts/components/Analytics.vue'

    // @layouts plugin
    import {
        VerticalNavLayout
    } from '@layouts'

    const {
        appRouteTransition,
        isLessThanOverlayNavBreakpoint
    } = useThemeConfig()
    const {
        width: windowWidth
    } = useWindowSize()


  const userRole = JSON.parse(localStorage.getItem('userRole') || 'null')

</script>

<template>
    <VerticalNavLayout :nav-items="navItems">
        <!-- 👉 navbar -->
        <template #navbar="{ toggleVerticalOverlayNavActive }">
            <div class="d-flex h-100 align-center">
                <VBtn v-if="isLessThanOverlayNavBreakpoint(windowWidth)" icon variant="text" color="default" class="ms-n3"
                    size="small" @click="toggleVerticalOverlayNavActive(true)">
                    <VIcon icon="tabler-menu-2" size="24" />
                </VBtn>

                <!-- <NavbarThemeSwitcher /> -->

                <Company />

                <Settings  v-if="userRole == 'God Mode' || userRole == 'Administrator' || userRole == 'Supervisor / Manager'"/>

                <Analytics v-if="userRole == 'God Mode' || userRole == 'Administrator'"/>

                <VSpacer />


                <!-- 👉 Search  -->
                <div style="width: 15rem; border-radius: 10%;" class="mr-10">
                    <VTextField placeholder="Search Employee" density="compact" variant="solo" label="Search Employee"
                        append-inner-icon="mdi-magnify" single-line hide-details />
                </div>


                <Notification />


                <UserProfile />
            </div>
        </template>

        <!-- 👉 Pages -->
        <RouterView v-slot="{ Component }">
            <Transition :name="appRouteTransition" mode="out-in">
                <Component :is="Component" />
            </Transition>
        </RouterView>

        <!-- 👉 Footer -->
        <template #footer>
            <Footer />
        </template>

        <!-- 👉 Customizer -->
        <!-- <TheCustomizer /> -->
    </VerticalNavLayout>
</template>
