import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import './styles/app.css';
import {mixin} from './mixins.js'
import './assets/tailwind.css'

router.beforeEach((to, from, next) => {
    if (to.name !== 'Login' && !localStorage.user) next({ name: 'Login' })
    else next()
  })

createApp(App).use(store).use(router).mixin(mixin).mount('#app')
