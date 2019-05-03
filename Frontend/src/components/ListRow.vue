<template>
    <div class="list-row" :class="[header ? 'header' : '']">
        <div
            v-for="(entry, idx) of items"
            :key="'list-item' + idx"
            :style="{ width: entry.width + '%' }"
            class="list-item"
            :class="entry.classes"
        >
            <span v-if="header">{{ entry.key | capitalize }}</span>
            <span v-else>{{ entry.key }}</span>
            <OrderButton
                v-if="header"
                :order-key="entry.key"
                :order-direction="orderDirection"
                :order-by="orderBy"
                @clicked="updateOrder"
            ></OrderButton>
        </div>
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
    methods: {
        updateOrder: function(orderKey) {
            this.$emit('updateOrder', orderKey)
        }
    }
}
</script>

<style lang="scss" src="@/components/ListRow.scss" scoped></style>
