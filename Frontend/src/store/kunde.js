export const state = () => ({
    inputs: [
        { name: 'Name', value: '' },
        { name: 'Vorname', value: '' },
        { name: 'Strasse', value: '' },
        { name: 'Hausnummer', value: '' },
        { name: 'Plz', value: '' },
        { name: 'Ort', value: '' },
        { name: 'Telefon', value: '' },
        { name: 'Email', value: '' }
    ],
    kunden: []
})

export const actions = {
    async onHttpRequest({ commit }) {
        const { data } = await this.$http.post('/index.php', {
            action: 'getKunden'
        })
        commit('setKunden', data.data)
    }
}

export const mutations = {
    setKunden: (state, payload) => (state.kunden = payload),
    setKundeInputs: (state, payload) => (state.items = payload)
}
