export const state = () => ({
    inputs: [
        { name: 'Bezeichung', value: '' },
        { name: 'Strasse', value: '' },
        { name: 'Hausnummer', value: '' },
        { name: 'Plz', value: '' },
        { name: 'Ort', value: '' }
    ],
    headers: [
        { key: 'id', width: '10', mobileWidth: '10', classes: '' },
        { key: 'bezeichung', width: '20', mobileWidth: '90', classes: '' },
        { key: 'strasse', width: '30', classes: 'mobile-hidden' },
        { key: 'hausnummer', width: '10', classes: 'mobile-hidden' },
        { key: 'plz', width: '10', classes: 'mobile-hidden' },
        { key: 'ort', width: '20', classes: 'mobile-hidden' }
    ],
    orderBy: 'id',
    orderDirection: 'desc',
    lager: []
})

export const getters = {
    lagerHeaders: state => state.headers,
    lagerListe: state => {
        let newLager = []
        /**
         * Baut die Artikel Liste anhand des Headers als Vorlage
         */
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
    }
}

export const actions = {
    async onHttpRequest({ commit }) {
        const { data } = await this.$http.post('/index.php', {
            action: 'getLager'
        })
        commit('setLager', data.data)
    }
}

export const mutations = {
    setLager: (state, payload) => (state.lager = payload),
    setLagerInputs: (state, payload) => (state.items = payload),
    setLagerOrderBy: (state, payload) => (state.orderBy = payload),
    setLagerOrderDirection: (state, payload) => (state.orderDirection = payload)
}
