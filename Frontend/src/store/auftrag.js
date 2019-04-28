export const state = () => ({
    items: [
        { name: 'Bezeichung', value: '' },
        { name: 'Kunde', value: '' },
        { name: 'Lieferdatum', value: '' }
    ]
})

export const getters = {}

export const mutations = {
    setItems: function(state, payload) {
        state.items = payload
    }
}
