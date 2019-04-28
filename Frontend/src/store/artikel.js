export const state = () => ({
    items: [
        { name: 'Bezeichung', value: '' },
        { name: 'Eigenschaften', value: '' },
        { name: 'Preis', value: '' }
    ]
})

export const getters = {}

export const mutations = {
    setArtikel: function(state, payload) {
        state.items = payload
    }
}
