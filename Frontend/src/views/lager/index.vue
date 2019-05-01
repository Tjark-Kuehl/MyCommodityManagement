<template>
    <main>
        <span>Lager</span>
    </main>
</template>

<script>
export default {
    metaInfo() {
        return {
            title: 'Lager'
        }
    },
    async fetch({ store, http }) {
        const { data } = await http.post('/index.php', {
            action: 'getLager'
        })

        store.commit('setLager', data.data)
    }
}
</script>
