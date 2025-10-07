import './assets/main.css'
import './bootstrap.js'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import { createNotivue } from 'notivue'
import 'notivue/notification.css'
import 'notivue/animations.css' 

import App from './App.vue'
import router from './router'

const app = createApp(App)
const notivue = createNotivue()

app.use(createPinia())
app.use(router)
app.use(notivue)

app.mount('#app')
