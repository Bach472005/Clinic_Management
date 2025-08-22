// axios.js
import axios from "axios";

axios.defaults.baseURL = 'http://localhost:8000'; // Laravel API
axios.defaults.withCredentials = true;
// Cấu hình axios mặc định gửi token trong header Authorization nếu có
const getToken = () => sessionStorage.getItem('token');

axios.interceptors.request.use(config => {
    const token = getToken();
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  });

export default axios;
