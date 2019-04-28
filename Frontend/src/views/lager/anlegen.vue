<template>
  <main>
    <ModalView :items="items" :buttons="buttons" :header="header"/>
  </main>
</template>

<script>
import { mapState } from 'vuex'
import ModalView from '@/components/ModalView.vue'
//
export default {
    metaInfo() {
        return {
            title: 'Lager anlegen'
        }
    },
    components: {
        ModalView
    },
    computed: {
        items: {
            get() {
                return this.$store.state.lager.items
            },
            set(value) {
                this.setLager(value)
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
            header: { section: 'Lager', action: 'Anlegen' }
        }
    }
}
</script>
