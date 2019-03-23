import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

/* Components */
import TheHeader from '@/components/TheHeader.vue'
import TheSidebar from '@/components/TheSidebar.vue'

export default () => {
    return new Router({
        mode: 'history',
        base: process.env.BASE_URL,
        routes: [
            {
                path: '/',
                name: 'home',
                components: {
                    default: () => import(/* webpackChunkName: "home" */ '@/views/home/'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            }
        ]
    })
}
