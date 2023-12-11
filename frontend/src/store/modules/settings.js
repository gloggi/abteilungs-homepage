import { api } from '../../mixins';

export const settings = {
    namespaced: true,
    state() {
        return {
            settings: undefined,
        }
    },
    mutations:{
        setSettings(state, settings) {
          state.settings = settings;
        }
      },
      actions:{
        async getSettings({ commit }) {
          try {
            const response = await api.get('settings');
            commit('setSettings', response.data);
          } catch (error) {
            console.error( error);
          }
        }
      }

}