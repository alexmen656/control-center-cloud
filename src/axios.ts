import axios from 'axios'

const axiosInstance = axios.create({
  baseURL: 'https://alex.polan.sk/control-center/cloud/',
})

export default axiosInstance
