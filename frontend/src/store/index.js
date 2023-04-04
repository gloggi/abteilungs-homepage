import { createStore } from 'vuex'
import { login } from './modules/login'
import { message } from './modules/message'
import { user } from './modules/user'
import { modal} from './modules/modal'
import { notification } from './modules/notification'
import {pageInEdit} from './modules/pageInEdit'

export default createStore({
  modules: {
    login,
    message,
    user,
    modal,
    notification,
    pageInEdit
  }
})
