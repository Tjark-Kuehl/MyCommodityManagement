export const state = () => ({
    inputs: [
        { name: 'Name', validation: 'required', value: '' },
        { name: 'Vorname', validation: 'required', value: '' },
        { name: 'Strasse', validation: 'required', value: '' },
        { name: 'Hausnummer', validation: 'required', value: '' },
        { name: 'Plz', validation: 'required', value: '' },
        { name: 'Ort', validation: 'required', value: '' },
        { name: 'Telefon', validation: 'required', value: '' },
        { name: 'Email', validation: 'required', value: '' }
    ],
    headers: [
        { key: 'id', width: '10', mobileWidth: '20', classes: '' },
        { key: 'name', width: '15', mobileWidth: '40', classes: '' },
        { key: 'vorname', width: '15', mobileWidth: '40', classes: '' },
        { key: 'strasse', width: '20', classes: 'mobile-hidden' },
        { key: 'hausnummer', width: '20', classes: 'mobile-hidden' },
        { key: 'ort', width: '20', classes: 'mobile-hidden' }
    ],
    orderBy: 'id',
    orderDirection: 'desc',
    kunden: []
})

export const getters = {
    getKunden: state => state.kunden,
    kundenHeaders: state => state.headers,
    kundenListe: state => {
        let newKunde = []
        /**
         * Baut die Artikel Liste anhand des Headers als Vorlage
         */
        if (state.kunden && state.kunden.length)
            for (let a of state.kunden) {
                const templateCopy = JSON.parse(JSON.stringify(state.headers))
                for (let itm of templateCopy) {
                    itm.key = a[itm.key]
                }
                newKunde.push(templateCopy)
            }

        /**
         * Holt sich den Index des sortier keys aus dem Header
         */
        let idx = 0
        for (let entry of state.headers) {
            if (entry.key === state.orderBy) {
                break
            }
            idx++
        }

        /**
         * Filter
         */
        newKunde.sort((a, b) => {
            const sort = new Intl.Collator(undefined, {
                numeric: true,
                sensitivity: 'base'
            }).compare(a[idx].key, b[idx].key)
            return state.orderDirection === 'asc' ? sort * -1 : sort
        })

        return newKunde
    }
}

export const actions = {
    async onHttpRequest({ dispatch }) {
        dispatch('loadKunden')
    },
    async loadKunden({ commit }) {
        const { data } = await this.$http.post('/index.php', {
            action: 'getKunden'
        })
        commit('setKunden', data.data)
    }
}

export const mutations = {
    setKunden: (state, payload) => (state.kunden = payload),
    setKundeInputs: (state, payload) => (state.items = payload),
    setKundenOrderBy: (state, payload) => (state.orderBy = payload),
    setKundenOrderDirection: (state, payload) => (state.orderDirection = payload)
}
