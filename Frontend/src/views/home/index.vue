<template>
    <main>
        <section class="wrapper">
            <h2>
                Wilkommen im
                <b>Wawi</b>
            </h2>
            <div class="buttonbar">
                <RouterLink :to="{ name: 'kunden' }" tag="button">
                    <UserIcon></UserIcon>
                </RouterLink>
                <RouterLink :to="{ name: 'artikel' }" tag="button">
                    <ItemIcon></ItemIcon>
                </RouterLink>
                <RouterLink :to="{ name: 'lager' }" tag="button">
                    <WarehouseIcon></WarehouseIcon>
                </RouterLink>
                <RouterLink :to="{ name: 'auftraege' }" tag="button">
                    <ListIcon></ListIcon>
                </RouterLink>
            </div>
        </section>
    </main>
</template>

<script>
import WarehouseIcon from '@/assets/icons/warehouse.svg'
import ListIcon from '@/assets/icons/list.svg'
import ItemIcon from '@/assets/icons/item.svg'
import UserIcon from '@/assets/icons/user.svg'

export default {
    components: {
        WarehouseIcon,
        ListIcon,
        ItemIcon,
        UserIcon
    },
    metaInfo() {
        return {
            title: 'Startseite'
        }
    },
    data() {
        return {}
    }
}
</script>

<style src="@/views/home/index.scss" lang="scss" scoped></style>
