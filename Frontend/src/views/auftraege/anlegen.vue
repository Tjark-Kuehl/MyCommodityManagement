<template>
    <main>
        <ModalViewOrder />
    </main>
</template>

<script>
import ModalViewOrder from '@/components/ModalViewOrder.vue'
export default {
    metaInfo() {
        return {
            title: 'Kunden anlegen'
        }
    },
    components: {
        ModalViewOrder
    },
    data() {
        return {}
    }
}
</script>
