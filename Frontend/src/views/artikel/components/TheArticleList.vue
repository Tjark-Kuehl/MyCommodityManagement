<template>
  <div class="list">
    <ListRow v-for="itm of items" :items="itm"></ListRow>
  </div>
</template>

<script>
import ListRow from '@/components/ListRow.vue'

export default {
    props: {
        items: {
            type: Array,
            required: true
        }
    },
    components: {
        ListRow
    }
}
</script>

<style src="@/assets/scss/components/List.scss" lang="scss" scoped></style>
