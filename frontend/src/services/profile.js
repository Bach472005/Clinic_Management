import axios from "@/axios";
import router from "@/router";

export const getCompletedFields = (form) => {
  const requiredKeys = ['email', 'name', 'phone', 'dob', 'gender', 'address', 'occupation']
  return requiredKeys.filter((key) => form[key] !== '' && form[key] !== null).length
}

export const getProgressPercentage = (completedFields, totalFields) => {
  if (totalFields === 0) return 0 // tránh chia cho 0
  return Math.floor((completedFields / totalFields) * 100)
}

// Change password
export const changePassword = async (data, setLoading) => {
  try {
    setLoading(true);
    const response = await axios.put('/api/user/password', data);

    window.location.reload();
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

    const updatedUser = response.data?.user ?? (await getUser()).data.user;

    sessionStorage.setItem('user', JSON.stringify(updatedUser));
  } catch (error) {
    if (error.response?.data?.errors) {
      return { success: false, errors: error.response.data.errors };
    } else {
      console.log('Lỗi không xác định:', error);
      return { success: false, errors: null };
    }
  } finally {
    setLoading(false);
  }
};


export const addMedicalRecord = async (data, setLoading) => {
    try {
        setLoading(true);
        const response = await axios.put('/api/user/patient/store', data);

        sessionStorage.setItem('user', JSON.stringify(response.data.user));
        window.location.reload();
    } catch (error) {
        if (error.response && error.response.data.errors) {
            return error.response.data.errors;
        } else {
            console.log(error);
            return null
        }
    } finally {
        setLoading(false);
    }
}
