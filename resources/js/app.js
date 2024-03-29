import { createApp } from 'vue'
import App from './components/App.vue'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'
import router from './router'

createApp(App).use(router).mount('#app')
