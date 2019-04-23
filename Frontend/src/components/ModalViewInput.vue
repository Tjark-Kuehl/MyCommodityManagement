<template>
  <div>
    <input class="modal-view-input" type="text">
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
