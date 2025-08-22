import axios from "@/axios";
import router from "@/router";


export const profile = async () => {
  try {
    const response = await axios.get('/api/patient');
    return response.data;
  } catch (error) {
    console.log(error);
    router.back();
  }
}
// Change password
export const changePassword = async (data, setLoading) => {
  try {
    setLoading(true);
    const response = await axios.put('/api/user/password', data);
    console.log(response.data.message);

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

    sessionStorage.setItem('user', JSON.stringify(response.data.user));

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

export const addMedicalRecord = async (data, setLoading) => {
    try {
        setLoading(true);
        const response = await axios.put('/api/user/patient/store', data);

        sessionStorage.setItem('user', JSON.stringify(response.data.user));
        window.location.reload();
    } catch (error) {
        console.log(error.response.data);
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
