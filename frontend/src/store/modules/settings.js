import { api } from '../../mixins';
import { snakeToCamelObject } from '../../utils/caseConversionUtils';

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
            commit('setSettings', snakeToCamelObject(response.data));
          } catch (error) {
            console.error( error);
          }
        }
      }

}