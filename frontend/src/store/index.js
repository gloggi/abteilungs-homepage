import { createStore } from 'vuex'
import { login } from './modules/login'
import { message } from './modules/message'
import { user } from './modules/user'

export default createStore({
  modules: {
    login,
    message,
    user
  }
})
