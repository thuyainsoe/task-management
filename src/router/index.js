import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: { requiresAuth: true }
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView
    }
  ]
})

// const isAuthenticated = () => {
//   const itemString = localStorage.getItem('token')
//   if (!itemString) return null
//   const item = JSON.parse(itemString)
//   const currentTime = new Date().getTime()
//   if (currentTime > item.expiration) {
//     localStorage.removeItem('token')
//     return null
//   }
//   return item.token !== null && item.token !== 'undefined'
// }

// router.beforeEach((to, from, next) => {
//   if (to.matched.some((route) => route.meta.requiresAuth) && !isAuthenticated()) {
//     next('/login')
//   } else {
//     next()
//   }
// })

export default router
