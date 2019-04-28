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
        ...mapState({
            items: state => {
                console.log(state)
                return state.lager.items
            }
        })
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
