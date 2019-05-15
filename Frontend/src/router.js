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
            },
            /* #region Artikel */
            {
                path: '/artikel/anzeigen',
                name: 'artikel',
                components: {
                    default: () => import(/* webpackChunkName: "artikel" */ '@/views/artikel/'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            },
            {
                path: '/artikel/anzeigen',
                name: 'artikel-anzeigen',
                components: {
                    default: () => import(/* webpackChunkName: "artikel" */ '@/views/artikel/'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            },
            {
                path: '/artikel/anlegen',
                name: 'artikel-anlegen',
                components: {
                    default: () =>
                        import(/* webpackChunkName: "artikel" */ '@/views/artikel/anlegen'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            },
            {
                path: '/artikel/loeschen',
                name: 'artikel-loeschen',
                components: {
                    default: () =>
                        import(/* webpackChunkName: "artikel" */ '@/views/artikel/loeschen'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            },
            /* #endregion */
            /* #region Aufträge */
            {
                path: '/auftraege/anzeigen',
                name: 'auftraege',
                components: {
                    default: () => import(/* webpackChunkName: "auftraege" */ '@/views/auftraege/'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            },
            {
                path: '/auftraege/anzeigen',
                name: 'auftraege-anzeigen',
                components: {
                    default: () => import(/* webpackChunkName: "auftraege" */ '@/views/auftraege/'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            },
            {
                path: '/auftraege/anlegen',
                name: 'auftraege-anlegen',
                components: {
                    default: () =>
                        import(/* webpackChunkName: "auftraege" */ '@/views/auftraege/anlegen'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            },
            {
                path: '/auftraege/loeschen',
                name: 'auftraege-loeschen',
                components: {
                    default: () =>
                        import(/* webpackChunkName: "auftraege" */ '@/views/auftraege/loeschen'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            },
            /* #endregion */
            /* #region Kunden */
            {
                path: '/kunden/anzeigen',
                name: 'kunden',
                components: {
                    default: () => import(/* webpackChunkName: "kunden" */ '@/views/kunden/'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            },
            {
                path: '/kunden/anzeigen',
                name: 'kunden-anzeigen',
                components: {
                    default: () => import(/* webpackChunkName: "kunden" */ '@/views/kunden/'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            },
            {
                path: '/kunden/anlegen',
                name: 'kunden-anlegen',
                components: {
                    default: () =>
                        import(/* webpackChunkName: "kunden" */ '@/views/kunden/anlegen'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            },
            {
                path: '/kunden/loeschen',
                name: 'kunden-loeschen',
                components: {
                    default: () =>
                        import(/* webpackChunkName: "kunden" */ '@/views/kunden/loeschen'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            },
            /* #endregion */
            /* #region lager */
            {
                path: '/lager/anzeigen',
                name: 'lager',
                components: {
                    default: () => import(/* webpackChunkName: "lager" */ '@/views/lager/'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            },
            {
                path: '/lager/anzeigen',
                name: 'lager-anzeigen',
                components: {
                    default: () => import(/* webpackChunkName: "lager" */ '@/views/lager/'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            },
            {
                path: '/lager/anlegen',
                name: 'lager-anlegen',
                components: {
                    default: () => import(/* webpackChunkName: "lager" */ '@/views/lager/anlegen'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            },
            {
                path: '/lager/loeschen',
                name: 'lager-loeschen',
                components: {
                    default: () => import(/* webpackChunkName: "lager" */ '@/views/lager/loeschen'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            },
            {
                path: '/lager/wareneingang',
                name: 'lager-wareneingang',
                components: {
                    default: () =>
                        import(/* webpackChunkName: "lager" */ '@/views/lager/wareneingang'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            },
            {
                path: '/lager/inventar',
                name: 'lager-inventar',
                components: {
                    default: () => import(/* webpackChunkName: "lager" */ '@/views/lager/inventar'),
                    header: TheHeader,
                    sidebar: TheSidebar
                }
            }
            /* #endregion */
        ]
    })
}
