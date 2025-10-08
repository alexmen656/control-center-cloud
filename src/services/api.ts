import axios from 'axios'

const API_BASE_URL = 'https://alex.polan.sk/control-center/cloud'

const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
  },
})

api.interceptors.request.use((config) => {
  const token = localStorage.getItem('auth_token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
})

export interface LoginCredentials {
  username: string
  password: string
}

export interface LoginResponse {
  token: string
}

export interface User {
  username: string
  role: string
}

export const authApi = {
  login: async (credentials: LoginCredentials): Promise<LoginResponse> => {
    const response = await api.post<LoginResponse>('/users.php', credentials)
    return response.data
  },

  getUsers: async (): Promise<User[]> => {
    const response = await api.get<User[]>('/users.php')
    return response.data
  },
}

export const filesApi = {
  getFiles: async () => {
    const response = await api.get('/files.php')
    return response.data
  },
}

export default api
