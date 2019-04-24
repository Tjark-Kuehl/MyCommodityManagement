<template>
    <div class="modal-view-header">
        <span class="modal-view-text">{{ section }}</span>
        -
        <span class="modal-view-text">{{ action }}</span>
    </div>
</template>

<script>
export default {
    props: {
        section: {
            type: String,
            required: true
        },
        action: {
            type: String,
            required: true
        }
    },
    data() {
        return {}
    }
}
</script>

<style lang="scss" src="@/components/ModalViewHeader.scss" scoped></style>
