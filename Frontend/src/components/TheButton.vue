<template>
    <button :class="buttonStyle">{{ tag }}</button>
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
            required: false
        }
    },
    data() {
        return {}
    }
}
</script>

<style lang="scss" src="@/components/TheButton.scss" scoped></style>
