export const state = () => ({
    inputs: [
        { name: 'EAN', validation: 'required', value: '' },
        { name: 'Bezeichung', validation: 'required', value: '' },
        // { name: 'Lager', validation: 'required', dropdown: 'getLager', default: '-1', value: '-1' },
        { name: 'Kurztext', validation: 'required', value: '' },
        { name: 'Preis', validation: 'required', value: '' }
    ],
    artikel: []
})

export const actions = {
    async onHttpRequest({ commit }) {
        const { data } = await this.$http.post('/index.php', {
            action: 'getArtikel'
        })
        commit('setArtikel', data.data)
    }
}

export const mutations = {
    setArtikel: function(state, payload) {
        state.artikel = payload
    },
    setArtikelInputs: function(state, payload) {
        state.inputs = payload
    }
}
