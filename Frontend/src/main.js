import Vue from 'vue'
import App from './App.vue'
import createRouter from './router'
import createStore from './store'
import VueMeta from 'vue-meta'
//
import 'normalize.css'

Vue.use(VueMeta)

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
