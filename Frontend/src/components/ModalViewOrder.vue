<template>
    <section>
        <div class="modal-view-background">
            <div class="modal-view">
                <ModalViewHeader
                    :section="header.section"
                    :action="header.action"
                ></ModalViewHeader>
                <div class="modal-view-content">
                    <ModalViewInput
                        v-for="(item, i) of items"
                        :key="'ModalViewItem' + i"
                        :name="item.name"
                    ></ModalViewInput>
                </div>
                <div class="modal-view-footer">
                    <TheButton
                        v-for="(button, i) of buttons"
                        :key="'Button' + i"
                        :button-style="button.buttonStyle"
                        :tag="button.tag"
                    ></TheButton>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import ModalViewInput from '@/components/ModalViewInput.vue'
import ModalViewHeader from '@/components/ModalViewHeader.vue'
import TheButton from '@/components/TheButton.vue'

export default {
    components: {
        ModalViewInput,
        ModalViewHeader,
        TheButton
    },
    data() {
        return {
            items: [{ name: 'ArtikelNr' }, { name: 'Anzahl' }, { name: 'Bemerkungen' }],
            buttons: [
                { tag: 'Speichern', buttonStyle: 'button-global' },
                { tag: 'Speichern & Schließen', buttonStyle: 'button-global' },
                { tag: 'Schließen & Verwerfen', buttonStyle: 'button-global button-close' }
            ],
            header: { section: 'Auftrag', action: 'Anlegen' }
        }
    }
}
</script>

<style lang="scss" src="@/components/ModalView.scss" scoped></style>
