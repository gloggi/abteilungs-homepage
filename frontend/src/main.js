import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import {mixin} from './mixins.js'
import './assets/tailwind.css'
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";


router.beforeEach((to, from, next) => {
    if (to.name !== 'Login' && !localStorage.user) next({ name: 'Login' })
    else next()
  })

createApp(App).use(store).use(router).mixin(mixin).component("font-awesome-icon", FontAwesomeIcon).mount('#app')
