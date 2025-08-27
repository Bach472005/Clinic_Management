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
import GuestLayout from '@/layouts/GuestLayout.vue'
import PsychologistSchedule from '@/pages/Psychologist/Patient/PsychologistSchedule.vue'
import PatientLayout from '@/layouts/PatientLayout.vue'

const router = createRouter({
  history: createWebHistory(
    import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      component: GuestLayout,
      meta: { layout: 'guest', role: 'guest' },
      children: [
        {
          path: 'login',
          name: 'login',
          component: Login,
        },
        {
          path: 'register',
          name: 'register',
          component: Register,
        },
        // ... thêm các trang guest khác nếu cần
      ]
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
      path: '/psychologist',
      component: GuestLayout,
      meta: { layout: 'patient', role: 'guest, patient'},
      children: [
        { path: ':id/schedule', name: 'PsychologistSchedule', component: PsychologistSchedule, props: true}
      ]
    },
    {
      path: '/',
      component: Dashboard
    },
  ],
})

export default router
