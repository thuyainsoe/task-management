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

const isAuthenticated = () => {
  const token = localStorage.getItem('token') 
  return token !== null && token !== 'undefined'
}

// Global navigation guard
router.beforeEach((to, from, next) => {
  if (to.matched.some((route) => route.meta.requiresAuth) && !isAuthenticated()) {
    // Redirect to the login page if the route requires authentication and the user is not authenticated
    next('/login')
  } else {
    // Continue to the requested route
    next()
  }
})

export default router
