<template>
    <button :class="buttonStyle" v-bind="$attrs" @click="$emit('click')">{{ tag }}</button>
</template>

<script>
export default {
    props: {
        tag: {
            type: String,
            required: true
        },
        buttonStyle: {
            type: String,
            required: false,
            default: ''
        }
    }
}
</script>

<style lang="scss" src="@/components/Button.scss" scoped></style>
