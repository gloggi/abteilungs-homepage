import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'
import Dashboard from '../views/Dashboard.vue'
import DashboardHome from '../views/Dashboard/DashboardHome.vue'
import Pages from '../views/Dashboard/Pages.vue'
import Page from '../views/Dashboard/Page.vue'
import FileUploadTest from '../views/Dashboard/FileUploadTest.vue'
import Media from '../views/Dashboard/Media.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
    children: [
      {
        path: '',
        name: 'DashboardHome',
        component: DashboardHome
      },
      {
        path: 'pages',
        name: 'Pages',
        component: Pages
      },
      {
        path: 'pages/:id',
        name: 'Page',
        component: Page
      },
      {
        path: 'files',
        name: 'Files',
        component: FileUploadTest
      },
      {
        path: 'media',
        name: 'Media',
        component: Media
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
