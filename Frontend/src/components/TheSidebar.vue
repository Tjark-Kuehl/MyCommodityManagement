<template>
    <nav>
        <TheSidebarItem
            v-for="(item, i) of items"
            :key="'sidebarItem' + i"
            :name="item.name"
            :icon="item.icon"
            :dropdown="item.dropdown"
            :showdropdown.sync="item.showDropdown"
            @click.native="toggleDropdown(i)"
        >
            <TheSidebarItem
                v-for="(item2, i2) of item.dropdown"
                :key="'sidebarItemDropdown' + i2"
                :name="item2.name"
                :icon="item2.icon"
                :level="2"
            ></TheSidebarItem>
        </TheSidebarItem>
    </nav>
</template>

<script>
import TheSidebarItem from '@/components/TheSidebarItem.vue'

export default {
    components: {
        TheSidebarItem
    },
    data() {
        return {
            items: [
                { name: 'Startseite', icon: 'home', link: 'home' },
                {
                    name: 'Kunden',
                    icon: 'user',
                    showDropdown: false,
                    dropdown: [
                        { name: 'Anzeigen', icon: 'eye' },
                        { name: 'Anlegen', icon: 'plus' },
                        { name: 'Löschen', icon: 'trash' }
                    ]
                },
                {
                    name: 'Artikel',
                    icon: 'item',
                    showDropdown: false,
                    dropdown: [
                        { name: 'Anzeigen', icon: 'eye' },
                        { name: 'Anlegen', icon: 'plus' },
                        { name: 'Löschen', icon: 'trash' }
                    ]
                },
                {
                    name: 'Lager',
                    icon: 'warehouse',
                    showDropdown: false,
                    dropdown: [
                        { name: 'Anzeigen', icon: 'eye' },
                        { name: 'Anlegen', icon: 'plus' },
                        { name: 'Löschen', icon: 'trash' }
                    ]
                },
                {
                    name: 'Aufträge',
                    icon: 'list',
                    showDropdown: false,
                    dropdown: [
                        { name: 'Anzeigen', icon: 'eye' },
                        { name: 'Anlegen', icon: 'plus' },
                        { name: 'Löschen', icon: 'trash' }
                    ]
                }
            ]
        }
    },
    methods: {
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
