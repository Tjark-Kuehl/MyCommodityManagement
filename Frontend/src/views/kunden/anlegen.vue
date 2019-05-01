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
        inputs: {
            get() {
                return this.$store.state.kunde.inputs
            },
            set(value) {
                this.setKunde(value)
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
            header: { section: 'Kunde', action: 'Anlegen' }
        }
    }
}
</script>
