import axios from 'axios'
const api = axios.create({
    baseURL: 'http://localhost',
    headers:{
        'Accept': 'application/ld+json'
    },
    timeout: 1000
  });
export const mixin = {
    methods:{
        async callApi(method, url, data){
            try{
                const response = await api({method,url,data  })
                this.$store.commit("message/clear")
                console.log(response)
                return response
            }catch(e){
                console.log(e)
                this.$store.commit("message/setError", e)
                return JSON.stringify(e, Object.getOwnPropertyNames(e))
            }

        }
    }
}