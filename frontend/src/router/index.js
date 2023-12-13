import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'
import Dashboard from '../views/Dashboard.vue'
import DashboardHome from '../views/Dashboard/DashboardHome.vue'
import Pages from '../views/Dashboard/Pages.vue'
import Page from '../views/Dashboard/Page.vue'
import FileUploadTest from '../views/Dashboard/FileUploadTest.vue'
import Media from '../views/Dashboard/Media.vue'
import Sections from '../views/Dashboard/Sections.vue'
import Section from '../views/Dashboard/Section.vue'
import Groups from '../views/Dashboard/Groups.vue'
import Group from '../views/Dashboard/Group.vue'
import Contacts from '../views/Dashboard/Contacts.vue'
import Contact from '../views/Dashboard/Contact.vue'
import Forms from '../views/Dashboard/Forms.vue'
import Form from '../views/Dashboard/Form.vue'
import Menu from '../views/Dashboard/Menu.vue'
import Settings from '../views/Dashboard/Settings.vue'
import Locations from '../views/Dashboard/Locations.vue'
import Location from '../views/Dashboard/Location.vue'
import Events from '../views/Dashboard/Events.vue'
import Event from '../views/Dashboard/Event.vue'
import Users from '../views/Dashboard/Users.vue'
import User from '../views/Dashboard/User.vue'

const routes = [
  {
    path: '',
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
        component: DashboardHome,
        meta: {
          title: "Dashboard",
        },
      },
      {
        path: 'menu',
        name: 'Menu',
        component: Menu,
        meta: {
          title: "Menu",
        },
      },
      {
        path: 'pages',
        name: 'Pages',
        component: Pages,
        meta: {
          title: "Pages",
        },
      },
      {
        path: 'pages/:id',
        name: 'Page',
        component: Page
      },
      {
        path: 'sections',
        name: 'Sections',
        component: Sections,
        meta: {
          title: "Sections",
        },
      },
      {
        path: 'sections/:id',
        name: 'Section',
        component: Section
      },
      {
        path: 'groups',
        name: 'Groups',
        component: Groups,
        meta: {
          title: "Groups",
        },
      },
      {
        path: 'groups/:id',
        name: 'Group',
        component: Group
      },
      {
        path: 'contacts',
        name: 'Contacts',
        component: Contacts,
        meta: {
          title: "Contacts",
        },
      },
      {
        path: 'files',
        name: 'Files',
        component: FileUploadTest,
        meta: {
          title: "Files",
        },
      },
      {
        path: 'contacts/:id',
        name: 'Contact',
        component: Contact,
        meta: {
          title: "Contact",
        },
      },
      {
        path: 'media',
        name: 'Media',
        component: Media,
        meta: {
          title: "Media",
        },
      },
      {
        path: 'forms',
        name: 'Forms',
        component: Forms,
        meta: {
          title: "Forms",
        }
      },
      {
        path: 'forms/:id',
        name: 'Form',
        component: Form
      },
      {
        path: 'locations',
        name: 'Locations',
        component: Locations,
        meta: {
          title: "Locations",
        }
      },
      {
        path: 'locations/:id',
        name: 'Location',
        component: Location
      },
      {
        path: 'events',
        name: 'Events',
        component: Events,
        meta: {
          title: "Events",
        }
      },
      {
        path: 'events/:id',
        name: 'Event',
        component: Event
      },
      {
        path: 'users',
        name: 'Users',
        component: Users,
        meta: {
          title: "Users",
        }
      },
      {
        path: 'users/:id',
        name: 'User',
        component: User
      },
      {
        path: 'settings',
        name: 'Settings',
        component: Settings,
        meta: {
          title: "Settings",
        }
      },
    ],
    
  },
  {
    path: '/:path',
    name: 'Home2',
    component: Home
  },
  
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})
router.beforeEach((to, from, next) => {
  if (to.meta.title) {
    document.title = to.meta.title;
  }
  next();
});

export default router
