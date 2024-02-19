import { api } from "../../mixins";
import { snakeToCamelObject } from "../../utils/caseConversionUtils";

export const groups = {
  namespaced: true,

  state: () => ({
    groups: [],
    loaded: false,
  }),

  mutations: {
    setGroups(state, groups) {
      state.groups = groups;
      state.loaded = true;
    },
  },

  actions: {
    async fetchGroups({ commit, state }) {
      if (!state.loaded) {
        try {
          const response = await api.get("groups");
          commit("setGroups", snakeToCamelObject(response.data.data));
        } catch (error) {
          console.error("Error fetching groups:", error);
        }
      }
    },
  },

  getters: {
    allGroups: (state) => state.groups,
    isLoaded: (state) => state.loaded,
  },
};
