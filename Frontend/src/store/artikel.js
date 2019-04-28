export const state = () => ({
    items: [
        { name: 'Bezeichung', validation: 'required', value: '' },
        { name: 'Eigenschaften', validation: 'required', value: '' },
        { name: 'Preis', validation: 'required', value: '' }
    ]
})

export const getters = {}

export const mutations = {
    setArtikel: function(state, payload) {
        state.items = payload
    }
}
