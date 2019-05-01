/**
 * This plugin create an axios HTTP client to do request.
 * It handles tokens too to acess to private routes on API.
 */

import Vue from 'vue'
import axios from 'axios'

export default {
    beforeCreate(context, inject) {
        // Create axios client
        const http = axios.create({
            baseURL: process.env.VUE_APP_API_URL
        })

        // Install a shortcut to http client in context
        context.http = http

        // With this we can call http client everywhere in components or Vuex actions
        Vue.use({
            install(Vue) {
                Vue.http = Vue.prototype.$http = http
            }
        })

        // Inject http eveywhere
        inject('http', http)
    }
}
