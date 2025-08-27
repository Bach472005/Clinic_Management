// src/services/auth.js
import axios from "@/axios";
import router from "@/router";
import {
  useUserStore
} from '@/stores/user' // ✅ dùng store

// Lấy thông tin user - gọi API bảo vệ có token
export const getUser = async () => {
  return axios.get('/api/user'); // token đã được gắn header qua interceptor
};

export const login = async (data, setLoading) => {
  try {
    setLoading(true)

    const response = await axios.post('/api/login', data)

    const {
      token,
      user
    } = response.data

    sessionStorage.setItem('token', token)

    const userStore = useUserStore()
    userStore.user = user

    sessionStorage.setItem('user', JSON.stringify(user))

    const verifyEmail = sessionStorage.getItem('verifyEmail')
    if (verifyEmail) {
      const {
        id,
        hash
      } = JSON.parse(verifyEmail)

      try {
        await axios.get(`/email/verify/${id}/${hash}`, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        })
        console.log('✅ Email verified after login')
      } catch (verifyErr) {
        console.warn('⚠️ Email verify failed after login:', verifyErr.response?.data || verifyErr)
      }

      sessionStorage.removeItem('verifyEmail')
    }

    // ✅ Redirect sau khi login
    router.push('/')
  } catch (error) {
    if (error.response && error.response.data.errors) {
      return error.response.data.errors
    } else {
      console.log(error)
      return null
    }
  } finally {
    setLoading(false)
  }
}

// Đăng ký - gọi API register, không cần token
export const register = async (data, setLoading) => {
  try {
    setLoading(true);
    const response = await axios.post('/api/register', data);

    router.push('/login');
  } catch (error) {
    if (error.response && error.response.data.errors) {
      return error.response.data.errors;
    } else {
      console.log('Đã có lỗi xảy ra, vui lòng thử lại.');
      return null;
    }
  } finally {
    setLoading(false);
  }
};

// Đăng xuất - gọi API logout có token trong header, xóa token local
export const logout = async () => {
  const userStore = useUserStore()

  const token = sessionStorage.getItem('token')

  try {
    if (token) {
      await axios.post('/api/logout')
    }
  } catch (error) {
    console.warn('API logout failed:', error)
  } finally {
    sessionStorage.removeItem('token')
    sessionStorage.removeItem('user')
    userStore.user = null

    router.push('/login')
  }
}

