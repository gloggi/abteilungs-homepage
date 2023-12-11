export const notification = {
    namespaced: true,
    state() {
        return {
            show: false,
            message: undefined,
            error: false
        }
    },
    mutations: {
        show(state){
            state.show = true
        },
        hide(state){
            state.show = false
        },
        setMessage(state, message){
            state.message = message
        },
        setError(state, error){
            state.error = error
        }
    },
    actions: {
        notify(context, {message, error}){
            context.commit("setMessage", message)
            context.commit("setError", error)
            context.commit("show")
            setTimeout(()=>{context.commit("hide")}, 3000)
        }
    },
    getters: {}
}