export const state = () => ({
    items: [
        { name: 'Bezeichung', value: '' },
        { name: 'Strasse', value: '' },
        { name: 'Hausnummer', value: '' },
        { name: 'Plz', value: '' },
        { name: 'Ort', value: '' }
    ]
})

export const getters = {}

export const mutations = {
    setItems: function(state, payload) {
        state.items = payload
    }
}
