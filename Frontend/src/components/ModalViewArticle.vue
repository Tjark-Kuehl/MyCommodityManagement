<template>
  <section>
    <div class="modal-view-background">
      <div class="modal-view">
        <div class="modal-view-header"></div>
        <div class="modal-view-content">
          <ModalViewInput v-for="(item, i) of items" :key="'ModalViewItem' +i" :name="item.name"></ModalViewInput>
          <TheButton v-for="(button, i) of buttons" :key="'Button' +i" :tag="button.tag"></TheButton>
        </div>
        <div class="modal-view-footer"></div>
      </div>
    </div>
  </section>
</template>

<script>
import ModalViewInput from '@/components/ModalViewInput.vue'
import TheButton from '@/components/TheButton.vue'
9
export default {
    components: {
        ModalViewInput,
        TheButton
    },
    data() {
        return {
            items: [{ name: 'Bezeichung' }, { name: 'Eigenschaften' }, { name: 'Preis' }],
            buttons: [
                { tag: 'Speichern' },
                { tag: 'Speichern & Schließen' },
                { tag: 'Schließen & Verwerfen' }
            ]
        }
    }
}
</script>

<style lang="scss" src="@/components/ModalView.scss" scoped></style>
