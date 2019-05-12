<template>
    <main>
        <ListRow
            v-if="lagerHeaders"
            :items="lagerHeaders"
            :order-by="orderBy"
            :order-direction="orderDirection"
            header
            @updateOrder="updateOrder"
        ></ListRow>
        <TheLagerList v-if="lagerListe && lagerListe.length" :items="lagerListe"></TheLagerList>
        <NoItemFound v-else :item-definition="'Lager'" :goto="'lager-anlegen'"></NoItemFound>
    </main>
</template>

<script>
import { mapGetters } from 'vuex'
import ListRow from '@/components/ListRow.vue'
import TheLagerList from '@/views/lager/components/TheLagerList.vue'
import NoItemFound from '@/components/NoItemFound.vue'
import orderMixin from '@/mixins/order'

export default {
    components: {
        ListRow,
        TheLagerList,
        NoItemFound
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
    async fetch({ store }) {
        store.dispatch('loadLager')
    },
    metaInfo() {
        return {
            title: 'Lager'
        }
    }
}
</script>
