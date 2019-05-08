<template>
  <div class="list">
    <ListRow v-for="(itm, idx) of items" :key="'list-kunde' + idx" :items="itm"></ListRow>
  </div>
</template>

<script>
import ListRow from '@/components/ListRow.vue'

export default {
    components: {
        ListRow
    },
    props: {
        items: {
            type: Array,
            required: true
        }
    }
}
</script>

<style src="@/assets/scss/components/List.scss" lang="scss" scoped></style>
