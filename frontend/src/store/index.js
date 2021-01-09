import Vue from 'vue'
import Vuex from 'vuex'
import { notifications } from './notifications.module'
import { users } from './users.module'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        notifications,
        users
    }
})