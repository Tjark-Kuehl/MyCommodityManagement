<template>
  <div class="modal-view-input-wrapper">
    <input
      class="modal-view-input"
      type="text"
      v-bind="$attrs"
      @input="$emit('input', $event.target.value)"
    >
    <span class="modal-view-input-text">{{ name }}</span>
  </div>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            required: true
        }
    },
    data() {
        return {}
    }
}
</script>

<style lang="scss" src="@/components/ModalViewInput.scss" scoped></style>
