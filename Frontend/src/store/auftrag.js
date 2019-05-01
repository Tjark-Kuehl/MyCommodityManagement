export const state = () => ({
    inputs: [
        { name: 'Bezeichung', value: '' },
        { name: 'Kunde', value: '' },
        { name: 'Lieferdatum', value: '' }
    ],
    auftraege: []
})

export const mutations = {
    setAuftraege: function(state, payload) {
        state.auftraege = payload
    },
    setAuftragInputs: function(state, payload) {
        state.items = payload
    }
}
