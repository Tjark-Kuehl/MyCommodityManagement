<template>
    <header>
        <a class="menu" @click="navShown = !navShown">
            <MenuIcon></MenuIcon>
        </a>
        <RouterLink :to="{ name: 'home' }" tag="a" aria-label="Startseite">
            <Logo></Logo>
        </RouterLink>
        <a class="menu hidden">
            <MenuIcon></MenuIcon>
        </a>
    </header>
</template>

<script>
import Logo from '@/assets/icons/logo.svg'
import MenuIcon from '@/assets/icons/menu.svg'

export default {
    components: {
        Logo,
        MenuIcon
    },
    data() {
        return {}
    },
    computed: {
        navShown: {
            get: function() {
                return this.$store.getters.isNavShown
            },
            set: function(val) {
                this.$store.commit('setNavShown', val)
            }
        }
    },
    methods: {
        toggleNav: function() {
            this.toggleNav2 = !this.toggleNav2
        }
    }
}
</script>

<style lang="scss" src="@/components/TheHeader.scss" scoped></style>
