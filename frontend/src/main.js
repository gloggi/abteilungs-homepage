import Vue from 'vue'
import App from './App.vue'
import routes from './routes'
/* VueResource */
import VueResource from 'vue-resource'
Vue.use(VueResource);
Vue.http.options.root = 'http://localhost:8080/api/';
/* VueRouter */
import VueRouter from 'vue-router'
Vue.use(VueRouter)
const router = new VueRouter({
  mode: 'history',
  routes
})
/* VueMeta */
import VueMeta from 'vue-meta'

Vue.use(VueMeta, {
  // optional pluginOptions
  refreshOnceOnNavigation: true
})

import 'leaflet/dist/leaflet.css';

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
  router,
}).$mount('#app')
