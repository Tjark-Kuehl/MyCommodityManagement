export const state = () => ({
    inputs: [
        { name: 'Bezeichung', value: '' },
        { name: 'Strasse', value: '' },
        { name: 'Hausnummer', value: '' },
        { name: 'Plz', value: '' },
        { name: 'Ort', value: '' }
    ],
    lager: []
})

export const getters = {
    getLager: state => state.lager
}

export const actions = {
    async onHttpRequest({ commit }) {
        const { data } = await this.$http.post('/index.php', {
            action: 'getLager'
        })
        commit('setLager', data.data)
    }
}

export const mutations = {
    setLager: (state, payload) => (state.lager = payload),
    setLagerInputs: (state, payload) => (state.items = payload)
}
