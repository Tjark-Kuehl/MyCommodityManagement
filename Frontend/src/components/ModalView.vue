<template>
  <section>
    <div class="modal-view-background">
      <div class="modal-view">
        <ModalViewHeader :section="header.section" :action="header.action"></ModalViewHeader>
        <div class="modal-view-content">
          <template v-for="(input, i) of inputs">
            <ModalViewInput
              v-if="!input.dropdown"
              :key="'ModalViewItem' + i"
              :name="input.name"
              :validation="input.validation"
              v-model="input.value"
            ></ModalViewInput>
            <ModalViewDropdown
              v-else
              :key="'ModalViewItem' + i"
              :name="input.name"
              :validation="input.validation"
              :getter="input.dropdown"
              v-model="input.value"
            ></ModalViewDropdown>
          </template>
        </div>
        <div class="modal-view-footer">
          <Button
            v-for="(button, i) of buttons"
            :key="'Button' + i"
            :button-style="button.buttonStyle"
            :tag="button.tag"
            @click="$emit(button.action)"
          ></Button>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import ModalViewInput from '@/components/ModalViewInput.vue'
import ModalViewDropdown from '@/components/ModalViewDropdown.vue'
import ModalViewHeader from '@/components/ModalViewHeader.vue'
import Button from '@/components/Button.vue'

export default {
    components: {
        ModalViewInput,
        ModalViewDropdown,
        ModalViewHeader,
        Button
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
