import { createApp } from "vue";
import App from "./App.vue";
import { getRouter } from "./router";
import store from "./store";
import { mixin } from "./mixins.js";
import "./assets/tailwind.css";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { messages } from "./translations.js";
import { createI18n } from "vue-i18n";

const i18n = createI18n({
  locale: window.navigator.language,
  fallbackLocale: "de",
  messages,
});

const router = getRouter(i18n.global.t);

router.beforeEach((to) => {
  let splitPath = to.path.split("/");
  let isDashboard = splitPath[1] === "dashboard";
  if (isDashboard && !localStorage.token) {
    return { name: "Login" };
  }
});

const app = createApp(App)
  .use(store)
  .use(router)
  .use(i18n)
  .mixin(mixin)
  .component("font-awesome-icon", FontAwesomeIcon);
app.directive("router-link", {
  mounted(el) {
    el.addEventListener("click", (event) => {
      const link = event.target.closest("a");
      if (!link) {
        return;
      }

      const href = link.getAttribute("href");
      if (!href) {
        return;
      }
      if (
        event.metaKey ||
        event.ctrlKey ||
        event.shiftKey ||
        event.altKey ||
        event.button !== 0
      ) {
        return;
      }
      const target = link.getAttribute("target");
      if (target === "_blank") {
        return;
      }
      if (
        href.startsWith("mailto:") ||
        href.startsWith("tel:") ||
        href.startsWith("javascript:")
      ) {
        return;
      }

      if (href.startsWith("#")) {
        return;
      }

      if (href.startsWith("/")) {
        event.preventDefault();
        router.push(href);
        return;
      }

      try {
        const url = new URL(href, window.location.origin);
        if (url.origin === window.location.origin) {
          event.preventDefault();
          router.push(url.pathname + url.search + url.hash);
          return;
        }
      } catch {
        return;
      }
    });
  },
});

app.mount("#app");
