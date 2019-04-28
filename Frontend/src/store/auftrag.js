export const state = () => ({
    items: [
        { name: 'Bezeichung', value: '' },
        { name: 'Kunde', value: '' },
        { name: 'Lieferdatum', value: '' }
    ]
})

export const getters = {}

export const mutations = {
    setAuftrag: function(state, payload) {
        state.items = payload
    }
}
