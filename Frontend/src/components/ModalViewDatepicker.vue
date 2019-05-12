<template>
    <div class="modal-view-input">
        <title>{{ name }}</title>
        <flat-pickr v-validate="validation" :config="dateConfig"></flat-pickr>
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
        }
    },
    data() {
        return {
            dateConfig: {
                locale: German,
                altInput: false,
                dateFormat: 'd.m.Y'
            }
        }
    }
}
</script>

<style lang="scss" src="@/components/ModalViewInput.scss" scoped></style>
