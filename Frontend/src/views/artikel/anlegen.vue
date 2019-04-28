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
    computed: {
        items: {
            get() {
                return this.$store.state.artikel.items
            },
            set(value) {
                this.setArtikel(value)
            }
        }
    },
    data() {
        return {
            buttons: [
                { tag: 'Speichern', buttonStyle: 'button-global', action: 'save' },
                {
                    tag: 'Speichern & Schließen',
                    buttonStyle: 'button-global',
                    action: 'saveandclose'
                },
                {
                    tag: 'Schließen & Verwerfen',
                    buttonStyle: 'button-global button-close',
                    action: 'closeanddiscard'
                }
            ],
            header: { section: 'Artikel', action: 'Anlegen' }
        }
    }
}
</script>
