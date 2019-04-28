import Vue from 'vue'
import App from './App.vue'
import createRouter from './router'
import createStore from './store/'
import VueMeta from 'vue-meta'
import VueSweetalert2 from 'vue-sweetalert2'
import Vuelidate from 'vuelidate'
//
import 'normalize.css'

Vue.use(VueMeta)
Vue.use(VueSweetalert2)
Vue.use(Vuelidate)

Vue.config.productionTip = false

export default () => {
    const store = createStore()
    const router = createRouter()
    return new Vue({
        router,
        store,
        render: h => h(App)
    })
}
