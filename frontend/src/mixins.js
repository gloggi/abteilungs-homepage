import axios from 'axios'
import { mapKeys, isPlainObject, isArray, snakeCase, camelCase } from 'lodash'
import { format } from 'date-fns'
export const api = axios.create({
  baseURL: `${process.env.VUE_APP_BACKEND_URL}/api`,
  headers: {
    'Accept': 'application/json'
  },
  timeout: 1000
});
export const mixin = {
  computed: {
    backendURL() {
      return process.env.VUE_APP_BACKEND_URL
    }
  },
  methods: {
    formatDateTime(datetime) {
      return format(new Date(datetime), 'dd.MM.yyyy HH:mm')
    },
    async callApi(method, url, data) {
      try {
        const response = await api({ method, url, data: this.camelToSnakeObject(data) })
        this.$store.commit("message/clear")
        response.data = this.snakeToCamelObject(response.data)
        return response
      } catch (e) {
        console.log(e)
        this.$store.commit("message/setError", e)
        return JSON.stringify(e, Object.getOwnPropertyNames(e))
      }

    },
    notifyUser(message) {
      this.$store.dispatch("notification/notify", message);
    },
    snakeToCamelObject(obj) {
      if (isPlainObject(obj)) {
        const newObject = mapKeys(obj, (_, key) => camelCase(key));
        Object.keys(newObject).forEach(key => {
          newObject[key] = this.snakeToCamelObject(newObject[key]);
        });
        return newObject;
      } else if (Array.isArray(obj)) {
        return obj.map(element => this.snakeToCamelObject(element));
      }
      return obj;
    }
    ,
    camelToSnakeObject(obj) {
      if (isPlainObject(obj)) {
        const newObject = mapKeys(obj, (_, key) => snakeCase(key));
        Object.keys(newObject).forEach(key => {
          newObject[key] = this.camelToSnakeObject(newObject[key]);
        });
        return newObject;
      } else if (Array.isArray(obj)) {
        return obj.map(element => this.camelToSnakeObject(element));
      }
      return obj;
    }
  }
}