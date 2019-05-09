<template>
  <main>
    <ListRow
      :items="lagerHeaders"
      :order-by="orderBy"
      :order-direction="orderDirection"
      header
      @updateOrder="updateOrder"
    ></ListRow>
    <TheLagerList v-if="lagerListe" :items="lagerListe"></TheLagerList>
  </main>
</template>

<script>
import { mapGetters } from 'vuex'
import ListRow from '@/components/ListRow.vue'
import TheLagerList from '@/views/lager/components/TheLagerList.vue'
import orderMixin from '@/mixins/order'

export default {
    components: {
        ListRow,
        TheLagerList
    },
    mixins: [orderMixin],
    computed: {
        ...mapGetters(['lagerListe', 'lagerHeaders']),
        orderBy: {
            get: function() {
                return this.$store.state.lager.orderBy
            },
            set: function(val) {
                this.$store.commit('setLagerOrderBy', val)
            }
        },
        orderDirection: {
            get: function() {
                return this.$store.state.lager.orderDirection
            },
            set: function(val) {
                this.$store.commit('setLagerOrderDirection', val)
            }
        }
    },
    async fetch({ store, http }) {
        const { data } = await http.post('/index.php', {
            action: 'getLager'
        })
        store.commit('setLager', data.data)
    },
    metaInfo() {
        return {
            title: 'Lager'
        }
    }
}
</script>
