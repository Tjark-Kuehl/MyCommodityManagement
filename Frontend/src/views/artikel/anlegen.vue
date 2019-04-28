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
            title: 'Artikel anlegen'
        }
    },
    components: {
        ModalView
    },
    computed: {
        ...mapState({
            items: state => state.artikel.items
        })
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
