import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import './styles/app.css';
import {mixin} from './mixins.js'

router.beforeEach((to, from, next) => {
    if (to.name !== 'Login' && !localStorage.userIRI) next({ name: 'Login' })
    else next()
  })

createApp(App).use(store).use(router).mixin(mixin).mount('#app')
