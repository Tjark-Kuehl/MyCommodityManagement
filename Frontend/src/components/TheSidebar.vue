<template>
    <nav :class="navShown ? 'opened' : ''">
        <TheSidebarItem
            v-for="(item, i) of items"
            :key="'sidebarItem' + i"
            :name="item.name"
            :icon="item.icon"
            :dropdown="item.dropdown"
            :route="item.route"
            :showdropdown.sync="item.showDropdown"
            @click.native="toggleDropdown(i)"
        >
            <TheSidebarItem
                v-for="(item2, i2) of item.dropdown"
                :key="'sidebarItemDropdown' + i2"
                :name="item2.name"
                :icon="item2.icon"
                :route="item.route + '-' + item2.route"
                :highlighted="item2.highlighted"
                :level="2"
            ></TheSidebarItem>
        </TheSidebarItem>
    </nav>
</template>

<script>
import TheSidebarItem from '@/components/TheSidebarItem.vue'
//
import { replaceSpecialGermanChars } from '@/lib/utils'

export default {
    components: {
        TheSidebarItem
    },
    data() {
        return {
            items: [
                { name: 'Startseite', icon: 'home', route: 'home' },
                {
                    name: 'Kunden',
                    icon: 'user',
                    showDropdown: false,
                    route: 'kunden',
                    dropdown: [
                        { name: 'Anzeigen', icon: 'eye', route: 'anzeigen' },
                        { name: 'Anlegen', icon: 'plus', route: 'anlegen' },
                        { name: 'Löschen', icon: 'trash', route: 'loeschen' }
                    ]
                },
                {
                    name: 'Artikel',
                    icon: 'item',
                    showDropdown: false,
                    route: 'artikel',
                    dropdown: [
                        { name: 'Anzeigen', icon: 'eye', route: 'anzeigen' },
                        { name: 'Anlegen', icon: 'plus', route: 'anlegen' },
                        { name: 'Löschen', icon: 'trash', route: 'loeschen' }
                    ]
                },
                {
                    name: 'Lager',
                    icon: 'warehouse',
                    showDropdown: false,
                    route: 'lager',
                    dropdown: [
                        { name: 'Anzeigen', icon: 'eye', route: 'anzeigen' },
                        { name: 'Anlegen', icon: 'plus', route: 'anlegen' },
                        { name: 'Löschen', icon: 'trash', route: 'loeschen' }
                    ]
                },
                {
                    name: 'Aufträge',
                    icon: 'list',
                    showDropdown: false,
                    route: 'auftraege',
                    dropdown: [
                        { name: 'Anzeigen', icon: 'eye', route: 'anzeigen' },
                        { name: 'Anlegen', icon: 'plus', route: 'anlegen' },
                        { name: 'Löschen', icon: 'trash', route: 'loeschen' }
                    ]
                }
            ]
        }
    },
    computed: {
        navShown: function() {
            return this.$store.getters.isNavShown
        }
    },
    mounted() {
        let self = this

        /***
         * Nehme die route wie z.B. /kunden/anzeigen und
         * teile bei jedem / danach filtere alle leeren werte raus
         */
        const routes = this.$route.path.split('/').filter(el => !!el)

        /**
         * Gehe durch alle hauptelemente des menüs
         */
        for (let i = 0; i < this.items.length; i++) {
            let item = this.items[i]

            /***
             * Überprüfe ob die erste route mit der route x
             * auf level 1 übereinstimmt
             */
            if (item.route === routes[0]) {
                self.toggleDropdown(i)

                /***
                 * Wenn der Menüpunkt ein Dropdown hat
                 */
                if (typeof item.dropdown !== 'undefined') {
                    /**
                     * Wenn menüpunkt mit route auf level 2 übereinstimmt
                     * dann im Menü highlighten
                     */
                    for (let i2 in item.dropdown) {
                        console.log(item.dropdown[i2].route, routes[1])
                        if (item.dropdown[i2].route === routes[1]) {
                            self.$set(
                                item.dropdown[i2],
                                'highlighted',
                                !item.dropdown[i2].highlighted
                            )
                        }
                    }
                }
            }
        }
    },
    methods: {
        // getRoute: function(parentRoute, route = '') {
        //     return replaceSpecialGermanChars(`/`)
        // },
        toggleDropdown: function(idx) {
            if (this.items[idx] && typeof this.items[idx].showDropdown !== 'undefined') {
                /* Hide old */
                for (let item in this.items) {
                    if (item !== idx) {
                        this.$set(this.items[item], 'showDropdown', false)
                    }
                }
                /* Set new */
                this.$set(this.items[idx], 'showDropdown', !this.items[idx].showDropdown)
            }
        }
    }
}
</script>

<style lang="scss" src="@/components/TheSidebar.scss" scoped></style>
