<template>
  <div class="list-row" :class="[header ? 'header' : '']">
    <div
      v-for="(entry, idx) of items"
      :key="'list-item' + idx"
      :style="{'width': entry.width + '%'}"
      class="list-item"
      :class="entry.classes"
    >
      <span v-if="header">{{entry.key | capitalize}}</span>
      <span v-else>{{entry.key}}</span>
    </div>
  </div>
</template>

<script>
export default {
    props: {
        items: {
            type: Array,
            required: true
        },
        header: {
            type: Boolean,
            default: false
        }
    }
}
</script>


<style lang="scss" src="@/components/ListRow.scss" scoped></style>