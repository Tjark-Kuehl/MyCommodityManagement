<template>
  <main>
    <ModalView :items="items" :buttons="buttons" :header="header"/>
  </main>
</template>

<script>
import ModalView from '@/components/ModalView.vue'
//
export default {
    metaInfo() {
        return {
            title: 'Artikel anlegen'
        }
    },
    components: {
        ModalView
    },
    data() {
        return {
            items: [{ name: 'Bezeichung' }, { name: 'Eigenschaften' }, { name: 'Preis' }],
            buttons: [
                { tag: 'Speichern', buttonStyle: 'button-global' },
                { tag: 'Speichern & Schließen', buttonStyle: 'button-global' },
                { tag: 'Schließen & Verwerfen', buttonStyle: 'button-global button-close' }
            ],
            header: { section: 'Artikel', action: 'Anlegen' }
        }
    }
}
</script>
