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
            delete-button-shown
        ></TheArticleList>
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
    async fetch({ store }) {
        await store.dispatch('loadArtikel')
    },
    metaInfo() {
        return {
            title: 'Artikel löschen'
        }
    }
}
</script>
