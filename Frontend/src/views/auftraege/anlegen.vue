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
            title: 'Auftrag anlegen'
        }
    },
    components: {
        ModalView
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
            header: { section: 'Auftrag', action: 'Anlegen' }
        }
    },
    computed: {
        inputs: {
            get() {
                return this.$store.state.auftrag.inputs
            },
            set(value) {
                this.setAuftrag(value)
            }
        }
    }
}
</script>
