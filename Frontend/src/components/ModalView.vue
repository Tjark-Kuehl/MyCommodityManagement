<template>
  <section>
    <div class="modal-view-background">
      <div class="modal-view">
        <ModalViewHeader :section="header.section" :action="header.action"></ModalViewHeader>
        <div class="modal-view-content">
          <ModalViewInput
            v-for="(input, i) of inputs"
            :key="'ModalViewItem' + i"
            :name="input.name"
            :validation="input.validation"
            v-model="input.value"
          ></ModalViewInput>
        </div>
        <div class="modal-view-footer">
          <TheButton
            v-for="(button, i) of buttons"
            :key="'Button' + i"
            :button-style="button.buttonStyle"
            :tag="button.tag"
            @click="$emit(button.action)"
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
    props: {
        inputs: {
            type: Array,
            required: true
        },
        buttons: {
            type: Array,
            required: true
        },
        header: {
            type: Object,
            required: true
        }
    }
}
</script>

<style lang="scss" src="@/components/ModalView.scss" scoped></style>
