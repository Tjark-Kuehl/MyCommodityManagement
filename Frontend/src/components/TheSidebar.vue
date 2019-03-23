<template>
    <nav>
        <TheSidebarItem
            v-for="(item, i) of items"
            :key="'sidebarItem' + i"
            :name="item.name"
            :icon="item.icon"
            :dropdown="item.dropdown"
        ></TheSidebarItem>
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
            items: [{ name: 'Home', icon: 'home', dropdown: true }]
        }
    }
}
</script>

<style lang="scss" src="@/components/TheSidebar.scss" scoped></style>
