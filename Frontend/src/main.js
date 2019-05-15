import Vue from 'vue'
import App from './App.vue'
import createRouter from './router'
import createStore from './store/'
import VueMeta from 'vue-meta'
import VueSweetalert2 from 'vue-sweetalert2'
import VeeValidate, { Validator } from 'vee-validate'
import de from 'vee-validate/dist/locale/de'
//
import 'normalize.css'
//
Vue.use(VueMeta)
Vue.use(VueSweetalert2, {
    confirmButtonColor: '#39a2ff',
    cancelButtonColor: '#bdbdbd',
    cancelButtonText: 'Abbrechen'
})

Validator.localize({ de })
Vue.use(VeeValidate, {
    locale: 'de'
})

Vue.config.productionTip = false

/* Filters */
Vue.filter('capitalize', function(value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
})

export default () => {
    const store = createStore()
    const router = createRouter()
    return new Vue({
        router,
        store,
        render: h => h(App)
    })
}
