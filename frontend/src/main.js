import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import { mixin } from "./mixins.js";
import "./assets/tailwind.css";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

router.beforeEach((to, from, next) => {
	let splitPath = to.path.split("/");
	let isDashboard = splitPath[1] === "dashboard";
	if (isDashboard && !localStorage.token) {
		next({ name: "Login" });
	} else {
		next();
	}
});

const app = createApp(App)
	.use(store)
	.use(router)
	.mixin(mixin)
	.component("font-awesome-icon", FontAwesomeIcon);
app.directive("router-link", {
	mounted(el) {
		el.addEventListener("click", (event) => {
			event.preventDefault();
			const path = event.target.getAttribute("href");
			if (path.startsWith("/")) {
				router.push(path);
			} else {
				window.location.href = path;
			}
		});
	},
});

app.mount("#app");
