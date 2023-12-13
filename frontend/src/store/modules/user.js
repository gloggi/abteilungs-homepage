import { api } from '../../mixins';
import { snakeToCamelObject } from '../../utils/caseConversionUtils';
export const user = {
    namespaced: true,
    state() {
        return {
            user: undefined,
            token: undefined
        }
    },
    mutations: {
        setUser(state, user){
            state.user = user
        },
        setToken(state, token){
            state.token = token
        },
        clear(state){
            state.user = undefined
        },
    },
    actions: {
            async getUser({ commit }) {
              try {
                const response = await api.get('user/info');
                commit('setUser', snakeToCamelObject(response.data));
              } catch (error) {
                console.error( error);
              }
          }
    },
    getters: {}
}