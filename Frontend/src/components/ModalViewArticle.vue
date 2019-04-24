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
            items: [{ name: 'Bezeichung' }, { name: 'Eigenschaften' }, { name: 'Preis' }],
            buttons: [
                { tag: 'Speichern' },
                { tag: 'Speichern & Schließen' },
                { tag: 'Schließen & Verwerfen' }
            ],
            header: { section: 'Artikel', action: 'Anlegen' }
        }
    }
}
</script>

<style lang="scss" src="@/components/ModalView.scss" scoped></style>
