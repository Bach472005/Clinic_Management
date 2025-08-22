import {
  createRouter,
  createWebHistory
} from 'vue-router'
import Dashboard from '@/pages/Dashboard.vue'
import Login from '@/pages/Auth/Login.vue'
import Register from '@/pages/Auth/Register.vue'
import ChangeProfile from '@/pages/Auth/Components/ChangeProfile.vue'
import ChangePassword from '@/pages/Auth/Components/ChangePassword.vue'
import ProfileLayout from '@/layouts/ProfileLayout.vue'
import VerifyEmail from '@/pages/Auth/VerifyEmail.vue'

const router = createRouter({
  history: createWebHistory(
    import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta: { layout: 'guest', role: 'guest' }
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
      meta: { layout: 'guest', role: 'guest' }
    },
    {
      path: '/verify-email/:id/:hash',
      name: 'EmailVerify',
      component: VerifyEmail
    },
    {
      path: '/profile',
      component: ProfileLayout,
      meta: { layout: 'guest', role: 'guest' },
      children: [
        { path: '', component: ChangeProfile },
        { path: 'change-password', component: ChangePassword },
      ]
    },
    {
      path: '/',
      component: Dashboard
    },
  ],
})

export default router
