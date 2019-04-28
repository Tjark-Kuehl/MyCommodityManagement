export const state = () => ({
    items: [
        { name: 'Bezeichung', value: '' },
        { name: 'Eigenschaften', value: '' },
        { name: 'Preis', value: '' }
    ]
})

export const getters = {}

export const mutations = {
    setItems: function(state, payload) {
        state.items = payload
    }
}
