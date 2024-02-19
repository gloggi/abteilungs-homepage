import { api } from "../../mixins";
import { snakeToCamelObject } from "../../utils/caseConversionUtils";

export const sections = {
  namespaced: true,

  state: () => ({
    sections: [],
    loaded: false,
  }),

  mutations: {
    setSections(state, sections) {
      state.sections = sections;
      state.loaded = true;
    },
  },

  actions: {
    async fetchSections({ commit, state }) {
      if (!state.loaded) {
        try {
          const response = await api.get("sections");
          commit("setSections", snakeToCamelObject(response.data.data));
        } catch (error) {
          console.error("Error fetching sections:", error);
        }
      }
    },
  },

  getters: {
    allSections: (state) => state.sections,
    isLoaded: (state) => state.loaded,
  },
};
