<template>
    <main>
        <ListRow
            v-if="artikelHeaders"
            :items="artikelHeaders"
            :order-by="orderBy"
            :order-direction="orderDirection"
            header
            @updateOrder="updateOrder"
        ></ListRow>
        <TheArticleList
            v-if="artikelListe && artikelListe.length"
            :items="artikelListe"
        ></TheArticleList>
        <NoItemFound v-else :item-definition="'Artikel'" :goto="'artikel-anlegen'"></NoItemFound>
    </main>
</template>

<script>
import { mapGetters } from 'vuex'
import ListRow from '@/components/ListRow.vue'
import TheArticleList from '@/views/artikel/components/TheArticleList.vue'
import NoItemFound from '@/components/NoItemFound.vue'
import orderMixin from '@/mixins/order'

export default {
    components: {
        ListRow,
        TheArticleList,
        NoItemFound
    },
    mixins: [orderMixin],
    computed: {
        ...mapGetters(['artikelListe', 'artikelHeaders']),
        orderBy: {
            get: function() {
                return this.$store.state.artikel.orderBy
            },
            set: function(val) {
                this.$store.commit('setArtikelOrderBy', val)
            }
        },
        orderDirection: {
            get: function() {
                return this.$store.state.artikel.orderDirection
            },
            set: function(val) {
                this.$store.commit('setArtikelOrderDirection', val)
            }
        }
    },
    async fetch({ store }) {
        store.dispatch('loadArtikel')
    },
    metaInfo() {
        return {
            title: 'Artikel'
        }
    }
}
</script>
