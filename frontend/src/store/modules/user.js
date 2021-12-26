import axios from 'axios'
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
        async storeUser(context, userIRI){
            try{
                const response = await axios({method: "get",url:"http://localhost"+userIRI })
                context.commit("setUser", response.data)
                localStorage.userIRI = userIRI
            }catch(e){
                console.log(e)
                localStorage.removeItem("userIRI")
                console.log("Couldn't store the user")
            }
            

        }
    },
    getters: {}
}