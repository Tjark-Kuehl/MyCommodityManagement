<template>
    <main>
        <span>Artikel</span>
    </main>
</template>

<script>
export default {
    metaInfo() {
        return {
            title: 'Artikel'
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
