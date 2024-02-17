export const modal = {
  namespaced: true,
  state() {
    return {
      open: false,
    };
  },
  mutations: {
    openModal(state) {
      state.open = true;
    },
    closeModal(state) {
      state.open = false;
    },
  },
  actions: {},
  getters: {},
};
