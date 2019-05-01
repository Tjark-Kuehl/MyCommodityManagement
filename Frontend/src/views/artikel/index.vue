<template>
  <main>
    <ListRow :items="headers" header></ListRow>
    <TheArticleList :items="artikelListe"></TheArticleList>
  </main>
</template>

<script>
import ListRow from '@/components/ListRow.vue'
import TheArticleList from '@/views/artikel/components/TheArticleList.vue'

export default {
    data() {
        return {
            headers: [
                { key: 'id', width: '10', mobileWidth: '10', classes: '' },
                { key: 'bezeichnung', width: '50', mobileWidth: '90', classes: '' },
                { key: 'ean', width: '20', classes: 'mobile-hidden' },
                { key: 'preis', width: '20', classes: 'mobile-hidden' }
            ]
        }
    },
    metaInfo() {
        return {
            title: 'Artikel'
        }
    },
    components: {
        ListRow,
        TheArticleList
    },
    computed: {
        artikelListe: function() {
            let newArtikel = []
            const artikel = this.$store.state.artikel.artikel
            for (let a of artikel) {
                const templateCopy = JSON.parse(JSON.stringify(this.headers))
                for (let itm of templateCopy) {
                    itm.key = a[itm.key]
                }
                newArtikel.push(templateCopy)
            }
            return newArtikel
        }
    },
    async fetch({ store, http }) {
        const { data } = await http.post('/index.php', {
            action: 'getArtikel'
        })

        store.commit('setArtikel', data.data)
    }
}
</script>
