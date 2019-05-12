<template>
    <div class="modal-view-input">
        <title>{{ name }}</title>
        <select v-validate="validation" :name="name" v-bind="$attrs">
            <option value="-1">Kein Eintrag</option>
            <option v-for="(i, idx) of items" :key="'items-option' + idx" :value="i.id">{{
                i.id + '. ' + i.bezeichnung
            }}</option>
        </select>
        <span class="error">{{ errors.first(name) }}</span>
    </div>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            required: true
        },
        validation: {
            type: String,
            default: ''
        },
        getter: {
            type: String,
            required: true
        }
    },
    computed: {
        items: function() {
            return this.$store.getters[this.getter]
        }
    }
}
</script>

<style lang="scss" src="@/components/ModalViewInput.scss" scoped></style>
