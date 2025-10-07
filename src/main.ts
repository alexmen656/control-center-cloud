// CSS
import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import axiosInstance from './axios'

const app = createApp(App)

app.config.globalProperties.$axios = axiosInstance

app.use(createPinia())
app.use(router)
app.mount('#app')
