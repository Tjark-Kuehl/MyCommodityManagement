import Vue from 'vue'
import Vuex from 'vuex'

// Modules
import * as menu from '@/store/menu'

Vue.use(Vuex)

export default () => {
    return new Vuex.Store({
        modules: {
            menu
        }
    })
}
