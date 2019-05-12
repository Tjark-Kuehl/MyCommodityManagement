<template>
    <div @click="$emit('clicked', orderKey)">
        <slot></slot>
        <DropdownIcon
            class="dropdown"
            :class="[
                orderKey === orderBy
                    ? orderDirection === 'asc'
                        ? 'active ascending'
                        : 'active'
                    : ''
            ]"
        ></DropdownIcon>
    </div>
</template>

<script>
/* SVG */
import DropdownIcon from '@/assets/icons/dropdown.svg'

export default {
    components: {
        DropdownIcon
    },
    props: {
        orderKey: {
            type: String,
            required: true
        },
        orderBy: {
            type: String,
            required: true
        },
        orderDirection: {
            type: String,
            required: true
        }
    }
}
</script>

<style lang="scss" src="@/components/OrderButton.scss" scoped></style>
