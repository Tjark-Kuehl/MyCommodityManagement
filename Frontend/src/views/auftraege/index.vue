<template>
    <main>
        <span>Aufträge</span>
    </main>
</template>

<script>
export default {
    metaInfo() {
        return {
            title: 'Aufträge'
        }
    },
    async fetch({ store, http }) {
        const { data } = await http.post('/index.php', {
            action: 'getAuftraege'
        })

        store.commit('setAuftraege', data.data)
    }
}
</script>
