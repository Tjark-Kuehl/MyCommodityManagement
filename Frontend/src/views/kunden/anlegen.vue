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
            title: 'Kunden anlegen'
        }
    },
    components: {
        ModalView
    },
    computed: {
        items: {
            get() {
                return this.$store.state.kunde.items
            },
            set(value) {
                this.setKunde(value)
            }
        }
    },
    data() {
        return {
            buttons: [
                { tag: 'Speichern', buttonStyle: 'button-global' },
                { tag: 'Speichern & Schließen', buttonStyle: 'button-global' },
                { tag: 'Schließen & Verwerfen', buttonStyle: 'button-global button-close' }
            ],
            header: { section: 'Kunde', action: 'Anlegen' }
        }
    }
}
</script>
