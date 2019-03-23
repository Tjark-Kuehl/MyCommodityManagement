<template>
    <main>
        <TheHeader></TheHeader>
        <TheSidebar></TheSidebar>
    </main>
</template>

<script>
import TheHeader from '@/components/TheHeader.vue'
import TheSidebar from '@/components/TheSidebar.vue'

export default {
    components: {
        TheHeader,
        TheSidebar
    },
    data() {
        return {}
    }
}
</script>
