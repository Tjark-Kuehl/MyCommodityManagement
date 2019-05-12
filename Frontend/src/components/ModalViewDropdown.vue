<template>
    <div class="modal-view-input">
        <title>{{ name }}</title>
        <select v-validate="validation" :name="name" @change="$emit('change', $event.target.value)">
            <option value="-1"></option>
            <option v-for="(i, idx) of items" :key="'items-option' + idx" :value="i.id">{{
                i.id + '. ' + getPropsAsString(i)
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
        },
        dropdownProps: {
            type: String,
            required: true
        }
    },
    computed: {
        items: function() {
            return this.$store.getters[this.getter]
        }
    },
    methods: {
        getPropsAsString: function(itm) {
            const props = this.dropdownProps.split(',')
            let str = ''
            for (const el of props) {
                str += itm[el] + ' '
            }
            return str
        }
    }
}
</script>

<style lang="scss" src="@/components/ModalViewInput.scss" scoped></style>
