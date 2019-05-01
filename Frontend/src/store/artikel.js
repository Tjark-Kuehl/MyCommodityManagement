//     ean: '4 013162 000012',
//     bezeichnung: 'Cooler Artikel',
//     kurztext: '.',
//     preis: 42,
//     bild: 'img/test.png',
//     inaktiv: 0

export const state = () => ({
    inputs: [
        { name: 'EAN', validation: 'required', value: '' },
        { name: 'Bezeichung', validation: 'required', value: '' },
        { name: 'Kurztext', validation: 'required', value: '' },
        { name: 'Preis', validation: 'required', value: '' }
    ]
})

export const getters = {}

export const mutations = {
    setInputs: function(state, payload) {
        state.inputs = payload
    }
}
