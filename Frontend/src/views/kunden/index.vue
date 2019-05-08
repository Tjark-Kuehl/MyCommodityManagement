<template>
  <main>
    <ListRow
      :items="kundenHeaders"
      :order-by="orderBy"
      :order-direction="orderDirection"
      header
      @updateOrder="updateOrder"
    ></ListRow>
    <TheKundenList :items="artikelListe"></TheKundenList>
  </main>
</template>

<script>
import { mapGetters } from 'vuex'
import ListRow from '@/components/ListRow.vue'
import TheKundenList from '@/views/kunden/components/TheKundenList.vue'
import orderMixin from '@/mixins/order'

export default {
    components: {
        ListRow,
        TheKundenList
    },
    mixins: [orderMixin],
    computed: {
        ...mapGetters(['kundenListe', 'kundenHeaders']),
        orderBy: {
            get: function() {
                return this.$store.state.kunde.orderBy
            },
            set: function(val) {
                this.$store.commit('setKundenOrderBy', val)
            }
        },
        orderDirection: {
            get: function() {
                return this.$store.state.kunde.orderDirection
            },
            set: function(val) {
                this.$store.commit('setKundenOrderDirection', val)
            }
        }
    },
    async fetch({ store, http }) {
        const { data } = await http.post('/index.php', {
            action: 'getKunden'
        })
        store.commit('setKunden', data.data)
    },
    metaInfo() {
        return {
            title: 'Kunden'
        }
    }
}
</script>
