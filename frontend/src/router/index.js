import {
  createRouter,
  createWebHistory
} from 'vue-router'
import Dashboard from '@/pages/Dashboard.vue'
import Login from '@/pages/Auth/Login.vue'
import Register from '@/pages/Auth/Register.vue'
import ProfileLayout from '@/layouts/ProfileLayout.vue'
import VerifyEmail from '@/pages/Auth/VerifyEmail.vue'

import ChangeProfile from '@/pages/Patient/Components/ChangeProfile.vue'
import ChangePassword from '@/pages/Patient/Components/ChangePassword.vue'
import MedicalRecord from '@/pages/Patient/Components/MedicalRecord.vue'

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
        { path: 'medical-record', component: MedicalRecord },
      ]
    },
    {
      path: '/',
      component: Dashboard
    },
  ],
})

export default router
