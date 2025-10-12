import axios from 'axios'

const axiosInstance = axios.create({
  baseURL: 'https://alex.polan.sk/control-center/cloud/',
  headers: {
    Authorization: `Bearer ${localStorage.getItem('auth_token') || ''}`,
  },
})

export default axiosInstance
