import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";
import Login from "../views/Login.vue";
import Dashboard from "../views/Dashboard.vue";
import DashboardHome from "../views/Dashboard/DashboardHome.vue";
import Pages from "../views/Dashboard/Pages.vue";
import Page from "../views/Dashboard/Page.vue";
import Media from "../views/Dashboard/Media.vue";
import Sections from "../views/Dashboard/Sections.vue";
import Section from "../views/Dashboard/Section.vue";
import Groups from "../views/Dashboard/Groups.vue";
import Group from "../views/Dashboard/Group.vue";
import Contacts from "../views/Dashboard/Contacts.vue";
import Contact from "../views/Dashboard/Contact.vue";
import Forms from "../views/Dashboard/Forms.vue";
import Form from "../views/Dashboard/Form.vue";
import Menu from "../views/Dashboard/Menu.vue";
import Settings from "../views/Dashboard/Settings.vue";
import Locations from "../views/Dashboard/Locations.vue";
import Location from "../views/Dashboard/Location.vue";
import Events from "../views/Dashboard/Events.vue";
import Event from "../views/Dashboard/Event.vue";
import Users from "../views/Dashboard/Users.vue";
import User from "../views/Dashboard/User.vue";
import Camps from "../views/Dashboard/Camps.vue";
import Camp from "../views/Dashboard/Camp.vue";
import Faqs from "../views/Dashboard/Faqs.vue";
import Faq from "../views/Dashboard/Faq.vue";
import EventMail from "../views/Dashboard/EventMail.vue";

export const getRouter = ($t) => {
  const routes = [
    {
      path: "",
      name: "Home",
      component: Home,
    },
    {
      path: "/login",
      name: "Login",
      component: Login,
    },
    {
      path: "/dashboard",
      name: "Dashboard",
      component: Dashboard,
      children: [
        {
          path: "",
          name: "DashboardHome",
          component: DashboardHome,
          meta: {
            title: "Dashboard",
          },
        },
        {
          path: "menu",
          name: "Menu",
          component: Menu,
          meta: {
            title: $t("dashboard.menu"),
          },
        },
        {
          path: "pages",
          name: "Pages",
          component: Pages,
          meta: {
            title: $t("dashboard.pages"),
          },
        },
        {
          path: "pages/:id",
          name: "Page",
          component: Page,
        },
        {
          path: "sections",
          name: "Sections",
          component: Sections,
          meta: {
            title: $t("dashboard.sections"),
          },
        },
        {
          path: "sections/:id",
          name: "Section",
          component: Section,
        },
        {
          path: "groups",
          name: "Groups",
          component: Groups,
          meta: {
            title: $t("dashboard.groups"),
          },
        },
        {
          path: "groups/:id",
          name: "Group",
          component: Group,
        },
        {
          path: "contacts",
          name: "Contacts",
          component: Contacts,
          meta: {
            title: $t("dashboard.contacts"),
          },
        },
        {
          path: "contacts/:id",
          name: "Contact",
          component: Contact,
          meta: {
            title: $t("dashboard.contact"),
          },
        },
        {
          path: "media",
          name: "Media",
          component: Media,
          meta: {
            title: $t("dashboard.media"),
          },
        },
        {
          path: "forms",
          name: "Forms",
          component: Forms,
          meta: {
            title: $t("dashboard.forms"),
          },
        },
        {
          path: "forms/:id",
          name: "Form",
          component: Form,
        },
        {
          path: "locations",
          name: "Locations",
          component: Locations,
          meta: {
            title: $t("dashboard.locations"),
          },
        },
        {
          path: "locations/:id",
          name: "Location",
          component: Location,
        },
        {
          path: "faqs",
          name: "Faqs",
          component: Faqs,
          meta: {
            title: $t("dashboard.faqs"),
          },
        },
        {
          path: "faqs/:id",
          name: "Faq",
          component: Faq,
        },
        {
          path: "events",
          name: "Events",
          component: Events,
          meta: {
            title: $t("dashboard.events"),
          },
        },
        {
          path: "events/:id",
          name: "Event",
          component: Event,
        },
        {
          path: "events/:id/mail",
          name: "Event Mail",
          component: EventMail,
        },
        {
          path: "camps",
          name: "Camps",
          component: Camps,
          meta: {
            title: $t("dashboard.camps"),
          },
        },
        {
          path: "camps/:id",
          name: "Camp",
          component: Camp,
        },
        {
          path: "users",
          name: "Users",
          component: Users,
          meta: {
            title: $t("dashboard.users"),
          },
        },
        {
          path: "users/:id",
          name: "User",
          component: User,
        },
        {
          path: "settings",
          name: "Settings",
          component: Settings,
          meta: {
            title: $t("dashboard.settings"),
          },
        },
      ],
    },
    {
      path: `/${$t("page.groupPagePath")}/:id`,
      name: "GroupPage",
      component: Home,
    },
    {
      path: "/:path",
      name: "Home2",
      component: Home,
    },
    {
      path: "/:path/",
      redirect: { name: "Home2" },
    },
  ];

  const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
    scrollBehavior() {
      // always scroll to top
      return { top: 0 };
    },
  });
  router.beforeEach((to, from, next) => {
    if (to.meta.title) {
      document.title = to.meta.title;
    }
    next();
  });

  return router;
};
