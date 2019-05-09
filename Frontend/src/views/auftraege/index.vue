<template>
  <main>
    <ListRow
      :items="auftragHeaders"
      :order-by="orderBy"
      :order-direction="orderDirection"
      header
      @updateOrder="updateOrder"
    ></ListRow>
    <TheAuftragList v-if="auftragListe" :items="auftragListe"></TheAuftragList>
  </main>
</template>

<script>
import { mapGetters } from 'vuex'
import ListRow from '@/components/ListRow.vue'
import TheAuftragList from '@/views/auftraege/components/TheAuftragList.vue'
import orderMixin from '@/mixins/order'

export default {
    components: {
        ListRow,
        TheAuftragList
    },
    mixins: [orderMixin],
    computed: {
        ...mapGetters(['auftragListe', 'auftragHeaders']),
        orderBy: {
            get: function() {
                return this.$store.state.auftrag.orderBy
            },
            set: function(val) {
                this.$store.commit('setAuftragOrderBy', val)
            }
        },
        orderDirection: {
            get: function() {
                return this.$store.state.auftrag.orderDirection
            },
            set: function(val) {
                this.$store.commit('setAuftragOrderDirection', val)
            }
        }
    },
    async fetch({ store, http }) {
        const { data } = await http.post('/index.php', {
            action: 'getAuftrag'
        })
        store.commit('setAuftraege', data.data)
    },
    metaInfo() {
        return {
            title: 'Auftrag'
        }
    }
}
</script>