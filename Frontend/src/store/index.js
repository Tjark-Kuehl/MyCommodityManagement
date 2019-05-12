import Vue from 'vue'
import Vuex from 'vuex'

// Modules
import * as menu from '@/store/menu'
import * as artikel from '@/store/artikel'
import * as lager from '@/store/lager'
import * as kunde from '@/store/kunde'
import * as auftrag from '@/store/auftrag'

Vue.use(Vuex)

export default () => {
    return new Vuex.Store({
        modules: {
            artikel,
            menu,
            lager,
            kunde,
            auftrag
        }
    })
}
