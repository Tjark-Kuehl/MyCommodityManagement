<template>
  <main>
    <ModalView
      :items="items"
      :buttons="buttons"
      :header="header"
      @save="save()"
      @discard="discard()"
    />
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
        inputs: {
            get() {
                return this.$store.state.lager.inputs
            },
            set(value) {
                this.setLager(value)
            }
        }
    },
    data() {
        return {
            buttons: [
                { tag: 'Speichern', buttonStyle: 'button-global', action: 'save' },
                {
                    tag: 'Verwerfen',
                    buttonStyle: 'button-global button-close',
                    action: 'discard'
                }
            ],
            header: { section: 'Lager', action: 'Anlegen' }
        }
    }
}
</script>
