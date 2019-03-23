<template>
    <div class="sidebar-item">
        <!-- Choose icon -->
        <WarehouseIcon v-if="icon === 'warehouse'"></WarehouseIcon>
        <ListIcon v-if="icon === 'list'"></ListIcon>
        <ItemIcon v-if="icon === 'item'"></ItemIcon>
        <EyeIcon v-if="icon === 'eye'"></EyeIcon>
        <UserIcon v-if="icon === 'user'"></UserIcon>
        <TrashIcon v-if="icon === 'trash'"></TrashIcon>
        <HomeIcon v-if="icon === 'home'"></HomeIcon>
        <!-- Name -->
        <span>{{ name }}</span>
        <!-- Dropdown -->
        <DropdownIcon v-if="dropdown"></DropdownIcon>
    </div>
</template>

<script>
import WarehouseIcon from '@/assets/icons/warehouse.svg'
import ListIcon from '@/assets/icons/list.svg'
import ItemIcon from '@/assets/icons/item.svg'
import EyeIcon from '@/assets/icons/eye.svg'
import UserIcon from '@/assets/icons/user.svg'
import TrashIcon from '@/assets/icons/trash.svg'
import HomeIcon from '@/assets/icons/home.svg'
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
        DropdownIcon
    },
    props: {
        name: {
            type: String,
            required: true
        },
        icon: {
            type: String,
            required: true
        },
        dropdown: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style lang="scss" src="@/components/TheSidebarItem.scss" scoped></style>
