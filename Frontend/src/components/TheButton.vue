<template>
    <button class="button-global">{{ tag }}</button>
</template>

<script>
export default {
    props: {
        tag: {
            type: String,
            required: true
        }
    },
    data() {
        return {}
    }
}
</script>

<style lang="scss" src="@/components/TheButton.scss" scoped></style>
