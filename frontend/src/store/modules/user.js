import { api } from "../../mixins";
import { snakeToCamelObject } from "../../utils/caseConversionUtils";
export const user = {
  namespaced: true,
  state() {
    return {
      user: undefined,
      token: undefined,
      isAdmin: false,
      isUnitLeader: false,
      groups: [],
    };
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
    setToken(state, token) {
      state.token = token;
    },
    clear(state) {
      state.user = undefined;
    },
    setAdmin(state, isAdmin) {
      state.isAdmin = isAdmin;
    },
    setUnitLeader(state, isUnitLeader) {
      state.isUnitLeader = isUnitLeader;
    },
    setGroups(state, groups) {
      state.groups = groups;
    },
  },
  actions: {
    async getUser({ commit }) {
      try {
        const response = await api.get("user/info");
        const user = snakeToCamelObject(response.data);
        const isAdmin =
          user.roles.findIndex((role) => role.name === "admin") >= 0;
        const isUnitLeader =
          user.roles.findIndex((role) => role.name === "unitleader") >= 0;
        commit("setUser", user);
        commit("setToken", user.token);
        commit("setAdmin", isAdmin);
        commit("setUnitLeader", isUnitLeader || isAdmin);
        commit("setGroups", user.groups);
      } catch (error) {
        console.log("User not logged in");
      }
    },
  },
  getters: {},
};
