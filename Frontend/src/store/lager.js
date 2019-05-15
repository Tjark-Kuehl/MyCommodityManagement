export const state = () => ({
    inputs: [
        { name: 'Bezeichnung', validation: 'required', value: '' },
        { name: 'Strasse', validation: 'required', value: '' },
        { name: 'Hausnummer', validation: 'required', value: '' },
        { name: 'Plz', validation: 'required', value: '' },
        { name: 'Ort', validation: 'required', value: '' }
    ],
    wareneingang_inputs: [
        {
            name: 'Lager',
            validation: 'required|numeric',
            dropdown: 'getLager',
            dropdownProps: 'bezeichnung',
            default: 1,
            value: 1
        },
        {
            name: 'Artikel',
            validation: 'required|numeric',
            dropdown: 'getArtikel',
            dropdownProps: 'bezeichnung',
            default: 1,
            value: 1
        },
        {
            name: 'Menge',
            validation: 'required|numeric',
            type: 'number',
            value: 1,
            default: 1
        }
    ],
    headers: [
        { key: 'id', width: '10', mobileWidth: '25', classes: '' },
        { key: 'bezeichnung', width: '20', mobileWidth: '75', classes: '' },
        { key: 'strasse', width: '30', classes: 'mobile-hidden' },
        { key: 'hausnummer', width: '20', classes: 'mobile-hidden' },
        { key: 'ort', width: '20', classes: 'mobile-hidden' }
    ],
    inventar_headers: [
        { key: 'id', width: '25', mobileWidth: '25', classes: '' },
        { key: 'bezeichnung', width: '50', mobileWidth: '50', classes: '' },
        { key: 'menge', width: '25', mobileWidth: '25', classes: '' }
    ],
    orderBy: 'id',
    orderDirection: 'desc',
    lager: [],
    inventar: []
})

export const getters = {
    getLager: state => state.lager,
    lagerHeaders: state => state.headers,
    lagerInventarHeaders: state => state.inventar_headers,
    lagerListe: state => {
        let newLager = []
        /**
         * Baut die Artikel Liste anhand des Headers als Vorlage
         */
        if (state.lager && state.lager.length)
            for (let a of state.lager) {
                const templateCopy = JSON.parse(JSON.stringify(state.headers))
                for (let itm of templateCopy) {
                    itm.key = a[itm.key]
                }
                newLager.push(templateCopy)
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
        newLager.sort((a, b) => {
            const sort = new Intl.Collator(undefined, {
                numeric: true,
                sensitivity: 'base'
            }).compare(a[idx].key, b[idx].key)
            return state.orderDirection === 'asc' ? sort * -1 : sort
        })

        return newLager
    },
    lagerInventarListe: state => {
        let newArtikel = []
        /**
         * Baut die Artikel Liste anhand des Headers als Vorlage
         */
        if (state.inventar && state.inventar.length)
            for (let a of state.inventar) {
                const templateCopy = JSON.parse(JSON.stringify(state.inventar_headers))
                for (let itm of templateCopy) {
                    itm.key = a[itm.key]
                }
                newArtikel.push(templateCopy)
            }

        /**
         * Holt sich den Index des sortier keys aus dem Header
         */
        let idx = 0
        for (let entry of state.inventar_headers) {
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
    async onHttpRequest({ dispatch }) {
        dispatch('loadLager')
    },
    async loadLager({ commit }) {
        const { data } = await this.$http.post('/index.php', {
            action: 'getLager'
        })
        commit('setLager', data.data)
    },
    async loadLagerInventar({ commit }, lager_id) {
        const { data } = await this.$http.post('/index.php', {
            action: 'getLagerArtikel',
            lager_id
        })
        commit('setLagerInventar', data.data)
    }
}

export const mutations = {
    setLager: (state, payload) => (state.lager = payload),
    setLagerInputs: (state, payload) => (state.items = payload),
    setLagerOrderBy: (state, payload) => (state.orderBy = payload),
    setLagerOrderDirection: (state, payload) => (state.orderDirection = payload),
    setLagerInventar: (state, payload) => (state.inventar = payload)
}
