import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { authApi, type LoginCredentials } from '../services/api'

export const useAuthStore = defineStore('auth', () => {
  const token = ref<string | null>(localStorage.getItem('auth_token'))
  const username = ref<string | null>(localStorage.getItem('username'))
  const role = ref<string | null>(localStorage.getItem('role'))
  const isLoading = ref(false)
  const error = ref<string | null>(null)

  const isAuthenticated = computed(() => !!token.value)

  const parseJWT = (token: string) => {
    try {
      const parts = token.split('.')
      if (parts.length !== 3 || !parts[1]) return null

      const base64Url = parts[1]
      const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/')
      const jsonPayload = decodeURIComponent(
        atob(base64)
          .split('')
          .map((c) => '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2))
          .join(''),
      )
      return JSON.parse(jsonPayload)
    } catch (e) {
      return null
    }
  }

  const login = async (credentials: LoginCredentials) => {
    isLoading.value = true
    error.value = null

    try {
      const response = await authApi.login(credentials)

      if (response.token) {
        token.value = response.token
        localStorage.setItem('auth_token', response.token)

        const payload = parseJWT(response.token)
        if (payload) {
          username.value = payload.username
          role.value = payload.role
          localStorage.setItem('username', payload.username)
          localStorage.setItem('role', payload.role)
        }

        return true
      }
      return false
    } catch (err: any) {
      if (err.response?.status === 401) {
        error.value = 'Invalid username or password'
      } else {
        error.value = 'An error occurred. Please try again.'
      }
      return false
    } finally {
      isLoading.value = false
    }
  }

  const logout = () => {
    token.value = null
    username.value = null
    role.value = null
    localStorage.removeItem('auth_token')
    localStorage.removeItem('username')
    localStorage.removeItem('role')
  }

  return {
    token,
    username,
    role,
    isLoading,
    error,
    isAuthenticated,
    login,
    logout,
  }
})
