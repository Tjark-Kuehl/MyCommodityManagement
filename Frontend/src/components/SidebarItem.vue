<template>
    <RouterLink
        :to="{ name: route, params: params }"
        tag="div"
        class="sidebar-item"
        :class="[showdropdown || highlighted ? 'toggled' : '', 'level-' + level]"
    >
        <div class="wrapper">
            <div>
                <!-- Choose icon -->
                <WarehouseIcon v-if="icon === 'warehouse'"></WarehouseIcon>
                <ListIcon v-if="icon === 'list'"></ListIcon>
                <ItemIcon v-if="icon === 'item'"></ItemIcon>
                <EyeIcon v-if="icon === 'eye'"></EyeIcon>
                <UserIcon v-if="icon === 'user'"></UserIcon>
                <TrashIcon v-if="icon === 'trash'"></TrashIcon>
                <HomeIcon v-if="icon === 'home'"></HomeIcon>
                <CrossIcon v-if="icon === 'plus'" style="transform: rotate(45deg)"></CrossIcon>
                <InIcon v-if="icon === 'in'"></InIcon>
                <!-- Name -->
                <span>{{ name }}</span>
            </div>
            <!-- Dropdown -->
            <DropdownIcon v-if="dropdown && dropdown.length" class="dropdown"></DropdownIcon>
        </div>
        <div v-if="showdropdown" class="dropdown">
            <slot></slot>
        </div>
    </RouterLink>
</template>

<script>
import WarehouseIcon from '@/assets/icons/warehouse.svg'
import ListIcon from '@/assets/icons/list.svg'
import ItemIcon from '@/assets/icons/item.svg'
import EyeIcon from '@/assets/icons/eye.svg'
import UserIcon from '@/assets/icons/user.svg'
import TrashIcon from '@/assets/icons/trash.svg'
import HomeIcon from '@/assets/icons/home.svg'
import CrossIcon from '@/assets/icons/cross.svg'
import InIcon from '@/assets/icons/in.svg'
//
import DropdownIcon from '@/assets/icons/dropdown.svg'

export default {
    components: {
        WarehouseIcon,
        ListIcon,
        ItemIcon,
        EyeIcon,
        UserIcon,
        TrashIcon,
        HomeIcon,
        DropdownIcon,
        CrossIcon,
        InIcon
    },
    props: {
        name: {
            type: String,
            required: true
        },
        route: {
            type: String,
            required: false,
            default: 'home'
        },
        icon: {
            type: String,
            required: true
        },
        dropdown: {
            type: Array,
            default: () => []
        },
        level: {
            type: Number,
            default: 1
        },
        showdropdown: {
            type: Boolean,
            default: false
        },
        highlighted: {
            type: Boolean,
            default: false
        },
        params: {
            type: Object,
            default: () => {}
        }
    }
}
</script>

<style lang="scss" src="@/components/SidebarItem.scss" scoped></style>
