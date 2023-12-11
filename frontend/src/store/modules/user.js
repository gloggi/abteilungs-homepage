export const user = {
    namespaced: true,
    state() {
        return {
            user: undefined,
        }
    },
    mutations: {
        setUser(state, user){
            state.user = user
        },
        clear(state){
            state.user = undefined
        },
    },
    actions: {
        async storeUser(context, user){
            try{
                
                context.commit("setUser", user)
                localStorage.user = user
            }catch(e){
                console.log(e)
                localStorage.removeItem("user")
            }
            

        }
    },
    getters: {}
}