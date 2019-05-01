<template>
  <main>
    <span>Kunden</span>
  </main>
</template>

<script>
export default {
    metaInfo() {
        return {
            title: 'Kunden'
        }
    },
    async fetch({ store, http }) {
        const { data } = await http.post('/index.php', {
            action: 'getKunden'
        })

        store.commit('setKunden', data.data)
    }
}
</script>
