<template>
    <main>
        <ModalViewWarehouse />
    </main>
</template>

<script>
import ModalViewWarehouse from '@/components/ModalViewWarehouse.vue'
export default {
    metaInfo() {
        return {
            title: 'Kunden anlegen'
        }
    },
    components: {
        ModalViewWarehouse
    },
    data() {
        return {}
    }
}
</script>
