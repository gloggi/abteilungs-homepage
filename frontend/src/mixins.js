import axios from 'axios'
export const api = axios.create({
    baseURL: 'http://localhost:8000/api',
    headers:{
        'Accept': 'application/json'
    },
    timeout: 1000
  });
export const mixin = {
    methods:{
        async callApi(method, url, data){
            try{
                const response = await api({method,url,data  })
                this.$store.commit("message/clear")
               
                return response
            }catch(e){
                console.log(e)
                this.$store.commit("message/setError", e)
                return JSON.stringify(e, Object.getOwnPropertyNames(e))
            }

        },
        notifyUser(message){
            this.$store.dispatch("notification/notify", message);
        }
    }
}