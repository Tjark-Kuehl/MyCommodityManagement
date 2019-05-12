<template>
    <main>
        <ListRow
            v-if="kundenHeaders"
            :items="kundenHeaders"
            :order-by="orderBy"
            :order-direction="orderDirection"
            header
            @updateOrder="updateOrder"
        ></ListRow>
        <TheKundenList
            v-if="kundenListe && kundenListe.length"
            :items="kundenListe"
        ></TheKundenList>
        <NoItemFound v-else :item-definition="'Kunde'" :goto="'kunden-anlegen'"></NoItemFound>
    </main>
</template>

<script>
import { mapGetters } from 'vuex'
import ListRow from '@/components/ListRow.vue'
import TheKundenList from '@/views/kunden/components/TheKundenList.vue'
import NoItemFound from '@/components/NoItemFound.vue'
import orderMixin from '@/mixins/order'

export default {
    components: {
        ListRow,
        TheKundenList,
        NoItemFound
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
    async fetch({ store }) {
        store.dispatch('loadKunden')
    },
    metaInfo() {
        return {
            title: 'Kunden'
        }
    }
}
</script>
