<template>
    <div class="modal-view-input">
        <title>{{ name }}</title>
        <select
            v-validate="validation"
            :name="name"
            v-bind="$attrs"
            @input="$emit('input', $event.target.value)"
        >
            <option value="-1">Kein Lager</option>
            <option v-for="(l, idx) of lager" :key="'lager-option' + idx" :value="l.id">{{
                l.id + '. ' + l.bezeichnung
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
        lager: function() {
            return this.$store.getters[this.getter]
        }
    }
}
</script>

<style lang="scss" src="@/components/ModalViewInput.scss" scoped></style>
