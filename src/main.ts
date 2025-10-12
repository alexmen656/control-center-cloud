// CSS
import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import axiosInstance from './axios'
import formatUnit from './utils/formatUnit'

const app = createApp(App)

app.config.globalProperties.$axios = axiosInstance
app.config.globalProperties.$formatUnit = formatUnit
app.use(createPinia())
app.use(router)
app.mount('#app')
