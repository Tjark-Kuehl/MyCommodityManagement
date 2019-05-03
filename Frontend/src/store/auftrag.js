export const state = () => ({
    inputs: [
        { name: 'Bezeichung', value: '' },
        { name: 'Kunde', value: '' },
        { name: 'Lieferdatum', value: '' }
    ],
    auftraege: []
})

export const mutations = {
    setAuftraege: (state, payload) => (state.auftraege = payload),
    setAuftragInputs: (state, payload) => (state.items = payload)
}
