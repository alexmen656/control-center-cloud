// CSS
import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import axiosInstance from './axios'
import formatUnit from './utils/formatUnit'
import GoogleSignInPlugin from 'vue3-google-signin'

const app = createApp(App)

app.config.globalProperties.$axios = axiosInstance
app.config.globalProperties.$formatUnit = formatUnit

app.use(GoogleSignInPlugin, {
  clientId: import.meta.env.VITE_GOOGLE_CLIENT_ID,
})

app.use(createPinia())
app.use(router)
app.mount('#app')
