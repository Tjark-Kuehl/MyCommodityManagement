export const state = () => ({
    items: [
        { name: 'Name', value: '' },
        { name: 'Vorname', value: '' },
        { name: 'Strasse', value: '' },
        { name: 'Hausnummer', value: '' },
        { name: 'Plz', value: '' },
        { name: 'Ort', value: '' },
        { name: 'Telefon', value: '' },
        { name: 'Email', value: '' }
    ]
})

export const getters = {}

export const mutations = {
    setKunde: function(state, payload) {
        state.items = payload
    }
}
