export const notification = {
    namespaced: true,
    state() {
        return {
            show: false,
            message: undefined
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
        }
    },
    actions: {
        notify(context, message){
            context.commit("setMessage", message)
            context.commit("show")
            setTimeout(()=>{context.commit("hide")}, 3000)
        }
    },
    getters: {}
}