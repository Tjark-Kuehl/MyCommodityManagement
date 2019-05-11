export const state = () => ({
    inputs: [
        { name: 'EAN', validation: 'required', value: '' },
        { name: 'Bezeichung', validation: 'required', value: '' },
        // { name: 'Lager', validation: 'required', dropdown: 'getLager', default: '-1', value: '-1' },
        { name: 'Kurztext', validation: 'required', value: '' },
        { name: 'Preis', validation: 'required', value: '' }
    ],
    headers: [
        { key: 'id', width: '10', mobileWidth: '10', classes: '' },
        { key: 'bezeichnung', width: '50', mobileWidth: '90', classes: '' },
        { key: 'ean', width: '20', classes: 'mobile-hidden' },
        { key: 'preis', width: '20', classes: 'mobile-hidden' }
    ],
    orderBy: 'id',
    orderDirection: 'desc',
    artikel: []
})

export const getters = {
    artikelHeaders: state => state.headers,
    artikelListe: state => {
        let newArtikel = []
        /**
         * Baut die Artikel Liste anhand des Headers als Vorlage
         */
        if (state.artikel && state.artikel.length)
            for (let a of state.artikel) {
                const templateCopy = JSON.parse(JSON.stringify(state.headers))
                for (let itm of templateCopy) {
                    itm.key = a[itm.key]
                }
                newArtikel.push(templateCopy)
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
        newArtikel.sort((a, b) => {
            const sort = new Intl.Collator(undefined, {
                numeric: true,
                sensitivity: 'base'
            }).compare(a[idx].key, b[idx].key)
            return state.orderDirection === 'asc' ? sort * -1 : sort
        })

        return newArtikel
    }
}

export const actions = {
    async onHttpRequest({ commit }) {
        const { data } = await this.$http.post('/index.php', {
            action: 'getArtikel'
        })
        commit('setArtikel', data.data)
    }
}

export const mutations = {
    setArtikel: (state, payload) => (state.artikel = payload),
    setArtikelInputs: (state, payload) => (state.inputs = payload),
    setArtikelOrderBy: (state, payload) => (state.orderBy = payload),
    setArtikelOrderDirection: (state, payload) => (state.orderDirection = payload)
}
