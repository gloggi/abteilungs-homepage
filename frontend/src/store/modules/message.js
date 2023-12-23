export const message = {
	namespaced: true,
	state() {
		return {
			error: undefined,
			success: undefined,
		};
	},
	mutations: {
		setError(state, error) {
			state.error = error;
		},
		setSuccess(state, success) {
			state.success = success;
		},
		clear(state) {
			state.error = undefined;
			state.success = undefined;
		},
	},
	actions: {},
	getters: {},
};
