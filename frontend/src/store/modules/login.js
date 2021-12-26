export const login = {
    namespaced: true,
    state() {
        return {
            username: undefined,
            password: undefined
        }
    },
    mutations: {
        setUsername(state, username){
            state.username = username
        },
        setPassword(state, password){
            state.password = password
        },
    },
    actions: {},
    getters: {}
}