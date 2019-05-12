<template>
    <section>
        <div class="modal-view-background">
            <div class="modal-view">
                <ModalViewHeader
                    :section="header.section"
                    :action="header.action"
                ></ModalViewHeader>
                <div class="modal-view-content">
                    <template v-for="(input, i) of inputs">
                        <ModalViewInput
                            v-if="!input.dropdown && !input.datepicker"
                            :key="'ModalViewItem' + i"
                            v-model="input.value"
                            :name="input.name"
                            :validation="input.validation"
                        ></ModalViewInput>
                        <ModalViewDropdown
                            v-else-if="input.dropdown"
                            :key="'ModalViewItem' + i"
                            :name="input.name"
                            :validation="input.validation"
                            :getter="input.dropdown"
                            :dropdown-props="input.dropdownProps"
                            @change="input.value = $event"
                        ></ModalViewDropdown>
                        <ModalViewDatepicker
                            v-else-if="input.datepicker"
                            :key="'ModalViewItem' + i"
                            :name="input.name"
                            :validation="input.validation"
                            :value="input.value"
                            @change="input.value = $event"
                        ></ModalViewDatepicker>
                    </template>
                </div>
                <div class="modal-view-footer">
                    <Button
                        v-for="(button, i) of buttons"
                        :key="'Button' + i"
                        :button-style="button.buttonStyle"
                        :tag="button.tag"
                        @click="$emit(button.action)"
                    ></Button>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import ModalViewInput from '@/components/ModalViewInput.vue'
import ModalViewDropdown from '@/components/ModalViewDropdown.vue'
import ModalViewDatepicker from '@/components/ModalViewDatepicker.vue'
import ModalViewHeader from '@/components/ModalViewHeader.vue'
import Button from '@/components/Button.vue'

export default {
    components: {
        ModalViewInput,
        ModalViewDropdown,
        ModalViewDatepicker,
        ModalViewHeader,
        Button
    },
    props: {
        inputs: {
            type: Array,
            required: true
        },
        buttons: {
            type: Array,
            required: true
        },
        header: {
            type: Object,
            required: true
        }
    }
}
</script>

<style lang="scss" src="@/components/ModalView.scss" scoped></style>
