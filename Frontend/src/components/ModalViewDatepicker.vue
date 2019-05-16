<template>
    <div class="modal-view-input">
        <title>{{ name }}</title>
        <flat-pickr
            v-model="val"
            v-validate="validation"
            :name="name"
            :config="dateConfig"
        ></flat-pickr>
        <span class="error">{{ errors.first(name) }}</span>
    </div>
</template>

<script>
import { German } from 'flatpickr/dist/l10n/de.js'

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
        value: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            val: '',
            dateConfig: {
                locale: German,
                mode: 'single',
                allowInput: false,
                // altInput: false,
                dateFormat: 'd.m.Y'
            }
        }
    },
    watch: {
        val: function() {
            this.$emit('change', this.val)
        }
    },
    mounted() {
        this.val = this.value
    }
}
</script>

<style lang="scss" src="@/components/ModalViewInput.scss" scoped></style>
