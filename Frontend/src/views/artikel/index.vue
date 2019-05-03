<template>
    <main>
        <ListRow
            :items="artikelHeaders"
            :order-by="orderBy"
            :order-direction="orderDirection"
            header
            @updateOrder="updateOrder"
        ></ListRow>
        <TheArticleList :items="artikelListe"></TheArticleList>
    </main>
</template>

<script>
import { mapGetters } from 'vuex'
import ListRow from '@/components/ListRow.vue'
import TheArticleList from '@/views/artikel/components/TheArticleList.vue'
import orderMixin from '@/mixins/order'

export default {
    components: {
        ListRow,
        TheArticleList
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
    async fetch({ store, http }) {
        const { data } = await http.post('/index.php', {
            action: 'getArtikel'
        })
        store.commit('setArtikel', data.data)
    },
    metaInfo() {
        return {
            title: 'Artikel'
        }
    }
}
</script>
