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
  action: string
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
  getDrives: async () => {
    const response = await api.get('/files.php', {
      params: {
        action: 'get_drives',
      },
    })
    return response.data
  },

  createDrive: async (driveName: string) => {
    const response = await api.post('/files.php', {
      action: 'create_drive',
      drive_name: driveName,
    })
    return response.data
  },

  getFiles: async (drive: string = 'default') => {
    const response = await api.get('/files.php', {
      params: {
        action: 'get_drive',
        drive: drive,
      },
    })
    return response.data
  },

  getFileContents: async (drive: string, file: string) => {
    const response = await api.get('/files.php', {
      params: {
        action: 'get_file_contents',
        drive: drive,
        file: file,
      },
    })
    return response.data
  },

  getRecentFiles: async () => {
    const response = await api.get('/files.php', {
      params: {
        action: 'get_recent_files',
      },
    })
    return response.data
  },
}

export default api
