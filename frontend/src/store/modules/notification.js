export const notification = {
  namespaced: true,
  state() {
    return {
      notifications: [],
    };
  },
  mutations: {
    add(state, notification) {
      state.notifications.push(notification);
    },
    remove(state, id) {
      state.notifications = state.notifications.filter((n) => n.id !== id);
    },
  },
  actions: {
    notify(context, payload) {
      const id = Date.now() + Math.random();
      let notification = {
        id,
        title: "",
        description: "",
        variant: "default",
        duration: 3000,
      };

      if (payload.message && typeof payload.message === "string") {
        notification.title = payload.error ? "Fehler" : "Erfolg";
        notification.description = payload.message;
        notification.variant = payload.error ? "destructive" : "success";
      } else {
        notification = { ...notification, ...payload, id };
      }

      context.commit("add", notification);

      if (notification.duration > 0) {
        setTimeout(() => {
          context.commit("remove", id);
        }, notification.duration);
      }
    },
  },
  getters: {},
};
