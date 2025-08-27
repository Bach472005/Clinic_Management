import axios from "@/axios";
import router from "@/router";

export const bookAppointment = async (payload) => {
  return axios.post('/api/appointments', payload)
}

export const psychologistSchedule = async (psychologistID) => {
    try {
      const response  = await axios.get(`/api/psychologist/${psychologistID}/schedule`)
      return response.data;
    } catch (err) {
      console.log('Lỗi khi tải lịch:', err)
      return null;
    }
}