<template>
    <header>
        <a class="menu">
            <MenuIcon></MenuIcon>
        </a>
        <RouterLink :to="{ name: 'home' }" tag="a">
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
    }
}
</script>

<style lang="scss" src="@/components/TheHeader.scss" scoped></style>
