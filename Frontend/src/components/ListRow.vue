<template>
    <div class="list-row" :class="[header ? 'header' : '']">
        <div
            v-for="(entry, idx) of items"
            :key="'list-item' + idx"
            :style="{ width: getWidth(entry) + '%' }"
            class="list-item"
            :class="entry.classes"
        >
            <template v-if="header">
                <OrderButton
                    :order-key="entry.key"
                    :order-direction="orderDirection"
                    :order-by="orderBy"
                    @clicked="updateOrder"
                    ><span>{{ entry.key | capitalize }}</span></OrderButton
                >
            </template>
            <span v-else>{{ entry.key }}</span>
        </div>
        <slot></slot>
    </div>
</template>

<script>
/* Components */
import OrderButton from '@/components/OrderButton.vue'

export default {
    components: {
        OrderButton
    },
    props: {
        items: {
            type: Array,
            required: true
        },
        header: {
            type: Boolean,
            default: false
        },
        orderBy: {
            type: String,
            required: false,
            default: 'id'
        },
        orderDirection: {
            type: String,
            required: false,
            default: 'desc'
        }
    },
    computed: {
        hasDefaultSlot() {
            return !!this.$slots.default
        }
    },
    methods: {
        updateOrder: function(orderKey) {
            this.$emit('updateOrder', orderKey)
        },
        getWidth: function(element) {
            const breakPoint = 600
            if (typeof window != 'undefined' && window.innerWidth <= breakPoint) {
                return element.mobileWidth
            }
            return element.width
        }
    }
}
</script>

<style lang="scss" src="@/components/ListRow.scss" scoped></style>
