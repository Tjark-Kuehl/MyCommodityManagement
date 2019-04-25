<template>
    <main>
        <ModalView />
    </main>
</template>

<script>
import ModalView from '@/components/ModalView.vue'
export default {
    metaInfo() {
        return {
            title: 'Kunden anlegen'
        }
    },
    components: {
        ModalView
    },
    data() {
        return {}
    }
}
</script>
