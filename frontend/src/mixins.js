import axios from 'axios'
import {camelCase, snakeCase} from 'change-case'
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
                const response = await api({method,url,data: this.camelToSnakeObject(data)  })
                this.$store.commit("message/clear")
                response.data = this.snakeToCamelObject(response.data)
                return response
            }catch(e){
                console.log(e)
                this.$store.commit("message/setError", e)
                return JSON.stringify(e, Object.getOwnPropertyNames(e))
            }

        },
        notifyUser(message){
            this.$store.dispatch("notification/notify", message);
        },
        snakeToCamelObject(obj) {
            if (!obj||obj instanceof FormData) {
              return obj;
            }
          
            if (Array.isArray(obj)) {
              return obj.map((element) => {
                if (typeof element === 'object' && element !== null) {
                  return this.snakeToCamelObject(element);
                }
                return this.camelCase(element); 
              });
            }
          
            const result = {};
            for (const [key, value] of Object.entries(obj)) {
              if (typeof value == "function") {
                continue;
              }
              const camelCaseKey = camelCase(key);
              result[camelCaseKey] = typeof value === "object" ? this.snakeToCamelObject(value) : value;
            }
            return result;
          }
          ,
          camelToSnakeObject(obj) {
            if (!obj||obj instanceof FormData) {
              return obj;
            }

            if (Array.isArray(obj)) {
              return obj.map((element) => {
                if (typeof element === 'object' && element !== null) {
                  return this.camelToSnakeObject(element);
                }
                return this.snakeCase(element); 
              });
            }
            const result = {};
            for (const [key, value] of Object.entries(obj)) {
                if(typeof value == "function"){
                    continue
                }
              const camelCaseKey = snakeCase(key);
              result[camelCaseKey] = typeof value === 'object' ? this.camelToSnakeObject(value) : value;
            }
            return result;
          }
    }
}