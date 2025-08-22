// src/services/auth.js
import axios from "@/axios";
import router from "@/router";

// Lấy thông tin user - gọi API bảo vệ có token
export const getUser = async () => {
  return axios.get('/api/user'); // token đã được gắn header qua interceptor
};

// Đăng nhập - gọi API login, lưu token và user vào sessionStorage
export const login = async (data, setLoading) => {
  try {
    setLoading(true);
    const response = await axios.post('/api/login', data);

    const {
      token,
      user
    } = response.data;

    sessionStorage.setItem('token', token);
    sessionStorage.setItem('user', JSON.stringify(user));

    const verifyEmail = sessionStorage.getItem('verifyEmail');
    if (verifyEmail) {
      const { id, hash } = JSON.parse(verifyEmail);

      try {
        await axios.get(`/email/verify/${id}/${hash}`, {
          headers: { Authorization: `Bearer ${token}` }
        });
        console.log('✅ Email verified after login');
      } catch (verifyErr) {
        console.warn('⚠️ Email verify failed after login:', verifyErr.response?.data || verifyErr);
      }

      sessionStorage.removeItem('verifyEmail');
    }

    router.push('/');
  } catch (error) {
    if (error.response && error.response.data.errors) {
      return error.response.data.errors;
    } else {
      console.log(error);
      return null;
    }
  } finally {
    setLoading(false);
  }
};


// Đăng ký - gọi API register, không cần token
export const register = async (data, setLoading) => {
  try {
    setLoading(true);
    const response = await axios.post('/api/register', data);

    console.log(response);
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
  try {
    const response = await axios.post(
    '/api/logout'); // token đã được gửi qua header interceptor

    sessionStorage.removeItem('token');
    sessionStorage.removeItem('user');

    console.log(response);
    router.push('/login');
  } catch (error) {
    console.log('Đăng xuất không thành công. Vui lòng thử lại.');
  }
};

// Change password

export const changePassword = async (data, setLoading) => {
  try {
    setLoading(true);
    const response = await axios.put('/api/user/password', data);
    console.log(response.data.message);
    
    router.back();
  } catch (error) {
    console.log(error.response.data);
    if (error.response && error.response.data.errors) {
      return error.response.data.errors;
    } else {
      console.log('Da co loi xay ra vui long thu lai');
      return null;
    }
  } finally {
    setLoading(false);
  }
}

export const changeProfile = async (data, setLoading) => {
  try {
    setLoading(true);
    const response = await axios.put('/api/user/profile', data);

    sessionStorage.setItem('user', JSON.stringify(response.data.user));
    
    router.back();
  } catch (error) {
    console.log(error.response.data);
    if (error.response && error.response.data.errors) {
      return error.response.data.errors;
    } else {
      console.log('Da co loi xay ra vui long thu lai');
      return null;
    }
  } finally {
    setLoading(false);
  }
}
