import axios from "axios";
import { format } from "date-fns";
import {
  snakeToCamelObject as sToCO,
  camelToSnakeObject as cToSO,
} from "./utils/caseConversionUtils";

export const api = axios.create({
  baseURL: `${import.meta.env.VITE_BACKEND_URL}/api`,
  headers: {
    Accept: "application/json",
  },
  timeout: 10000,
});
api.interceptors.request.use(
  function (config) {
    const token = localStorage.getItem("token");
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  function (error) {
    return Promise.reject(error);
  },
);
export const mixin = {
  computed: {
    backendURL() {
      return import.meta.env.VITE_BACKEND_URL;
    },
    settings() {
      return this.$store.state.settings.settings || {};
    },
    isAdmin() {
      return this.$store.state.user.isAdmin;
    },
    isUnitLeader() {
      return this.$store.state.user.isUnitLeader;
    },
    userGroups() {
      return this.isAdmin
        ? this.$store.state.groups.groups
        : this.$store.state.user.groups;
    },
  },
  methods: {
    getAsset(asset) {
      return new URL(`/src/assets/${asset}`, import.meta.url).href;
    },
    formatDateTime(datetime) {
      return format(new Date(datetime), "dd.MM.yyyy HH:mm");
    },
    async callApi(method, url, data, options) {
      try {
        const response = await api({
          method,
          url,
          data: this.camelToSnakeObject(data),
          ...this.camelToSnakeObject(options),
        });
        response.data = this.snakeToCamelObject(response.data);
        return response;
      } catch (error) {
        if (error.response) {
          error.response.data = this.snakeToCamelObject(error.response?.data);
        }
        throw error;
      }
    },
    notifyUser(message, error = false) {
      if (typeof message === "object") {
        this.$store.dispatch("notification/notify", message);
        return;
      }
      const title = error
        ? this.$t("dashboard.notifications.error")
        : this.$t("dashboard.notifications.success");
      const variant = error ? "destructive" : "success";
      this.$store.dispatch("notification/notify", {
        title,
        description: message,
        variant,
      });
    },
    notifyModel(model, action, error = false) {
      const actions = {
        create: { success: "created", error: "createError" },
        update: { success: "updated", error: "updateError" },
        delete: { success: "deleted", error: "deleteError" },
        duplicate: { success: "duplicated", error: "createError" },
        sync: { success: "synced", error: "syncError" },
        upload: { success: "uploaded", error: "uploadError" },
      };

      const actionKey = actions[action];
      if (!actionKey) {
        this.notifyUser(
          error
            ? this.$t("dashboard.notifications.generalError")
            : this.$t("dashboard.notifications.success"),
          error,
        );
        return;
      }

      const key = error ? actionKey.error : actionKey.success;
      const description = this.$t(`dashboard.notifications.${key}`, {
        name: model,
      });
      const title = error
        ? this.$t("dashboard.notifications.error")
        : this.$t("dashboard.notifications.success");
      const variant = error ? "destructive" : "success";

      this.$store.dispatch("notification/notify", {
        title,
        description,
        variant,
      });
    },
    snakeToCamelObject(obj) {
      return sToCO(obj);
    },
    camelToSnakeObject(obj) {
      return cToSO(obj);
    },
    createNewCssClass(className, styles) {
      const styleTag = document.createElement("style");
      document.head.appendChild(styleTag);
      const styleSheet = styleTag.sheet || styleTag.styleSheet;
      if (styleSheet.insertRule) {
        styleSheet.insertRule(
          `.${className} { ${styles} }`,
          styleSheet.cssRules.length,
        );
      } else if (styleSheet.addRule) {
        styleSheet.addRule(`.${className}`, styles);
      }
    },
    createNewCssVariable(variable, value) {
      document.documentElement.style.setProperty(variable, value);
    },
  },
};
