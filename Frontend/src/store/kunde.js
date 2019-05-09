export const state = () => ({
    inputs: [
        { name: 'Name', value: '' },
        { name: 'Vorname', value: '' },
        { name: 'Strasse', value: '' },
        { name: 'Hausnummer', value: '' },
        { name: 'Plz', value: '' },
        { name: 'Ort', value: '' },
        { name: 'Telefon', value: '' },
        { name: 'Email', value: '' }
    ],
    headers: [
        { key: 'id', width: '10', mobileWidth: '10', classes: '' },
        { key: 'name', width: '20', mobileWidth: '90', classes: '' },
        { key: 'strasse', width: '3 0', classes: 'mobile-hidden' },
        { key: 'hausnummer', width: '10', classes: 'mobile-hidden' },
        { key: 'plz', width: '10', classes: 'mobile-hidden' },
        { key: 'ort', width: '20', classes: 'mobile-hidden' }
    ],
    orderBy: 'id',
    orderDirection: 'desc',
    kunden: []
})

export const getters = {
    kundenHeaders: state => state.headers,
    kundenListe: state => {
        let newKunde = []
        /**
         * Baut die Artikel Liste anhand des Headers als Vorlage
         */
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
    async onHttpRequest({ commit }) {
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
