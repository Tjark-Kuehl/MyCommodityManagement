<template>
    <header>
        <RouterLink :to="{ name: 'home' }" tag="a">
            <Logo></Logo>
        </RouterLink>
    </header>
</template>

<script>
import Logo from '@/assets/icons/logo.svg'

export default {
    components: {
        Logo
    },
    data() {
        return {}
    }
}
</script>

<style lang="scss" src="@/components/TheHeader.scss" scoped></style>
