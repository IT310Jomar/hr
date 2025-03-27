import { setupLayouts } from 'virtual:generated-layouts'
import { createRouter, createWebHistory, RouteLocationNormalized, NavigationGuardNext } from 'vue-router'
import routes from '~pages'
import Login from '@/pages/login.vue';
import Dashboard from '@/pages/index.vue';
import CashAdvance from '@/pages/sidebarLayout/cash_advance/CashAdvance.vue';
import { canNavigate } from '@layouts/plugins/casl'
import { isUserLoggedIn } from './utils'
import axios from 'axios';

// const router = createRouter({
//   history: createWebHistory(import.meta.env.BASE_URL),
//   routes: [
//     ...setupLayouts(routes),
//   ],
// })

// router.beforeEach((to, _, next) => {
//   const isLoggedIn = isUserLoggedIn()
  
//   if (!canNavigate(to)) {
//     // Redirect to login if not logged in
//     if (!isLoggedIn) { return next({ name: 'login' })}

//   }
//   // Redirect if logged in
//   if(isLoggedIn)
//   {
//     if(to.meta.redirectIfLoggedIn)
//     {
//       //console.log('already logged in')

//       if (isLoggedIn) { return next('/')}
    
//       // return ('/');
//     }

//   }

//   return next()
// })


const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/login',
      name: 'Login',
      component: Login,
      beforeEnter:(to, from, next) => {
        const isLoggedIn = isUserLoggedIn();
        if (isLoggedIn) {
          next('/');
        } else {
          next();
        }
      }
    },
    ...setupLayouts(routes).map(route => {
      return {
        ...route,
        meta: { requiresAuth: true }
      }
    }),
    {
      path: '/',
      component: Dashboard,
      beforeEnter:(to, from, next) => {
        const isLoggedIn = isUserLoggedIn();
        if (!isLoggedIn) {
          next('/login');
        } else {
          next();
        }
      }
    },
  ],
});

router.beforeEach(async (to, from, next) => {
  const isLoggedIn = isUserLoggedIn();

  if (to.meta.requiresAuth && !isLoggedIn) {
    next('/login');
  } else {
    next();
  }
});

export default router
