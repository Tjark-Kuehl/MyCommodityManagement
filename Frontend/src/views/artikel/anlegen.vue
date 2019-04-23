<template>
  <main>
    <ModalViewArticle/>
  </main>
</template>

<script>
import ModalViewArticle from '@/components/ModalViewArticle.vue'
export default {
    metaInfo() {
        return {
            title: 'Artikel anlegen'
        }
    },
    components: {
        ModalViewArticle
    },
    data() {
        return {}
    }
}
</script>
