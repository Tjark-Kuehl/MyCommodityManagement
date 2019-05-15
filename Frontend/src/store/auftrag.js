function getCurrentDate() {
    const date = new Date()
    console.log(
        date.toLocaleDateString('de-DE', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        })
    )
    return date.toLocaleDateString('de-DE', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    })
}

export const state = () => ({
    inputs: [
        { name: 'Bezeichung', validation: 'required', value: '' },
        {
            name: 'Kunde',
            validation: 'required',
            dropdown: 'getKunden',
            dropdownProps: 'vorname,name',
            default: '-1',
            value: '-1'
        },
        {
            name: 'Lieferdatum',
            validation: 'required',
            datepicker: true,
            value: getCurrentDate(),
            default: getCurrentDate()
        }
    ],
    headers: [
        { key: 'id', width: '10', mobileWidth: '25', classes: '' },
        { key: 'bezeichnung', width: '50', mobileWidth: '75', classes: '' },
        { key: 'kunde', width: '20', classes: 'mobile-hidden' }
    ],
    orderBy: 'id',
    orderDirection: 'desc',
    auftraege: []
})

export const getters = {
    auftragHeaders: state => state.headers,
    auftragListe: state => {
        let newAuftrag = []
        /**
         * Baut die Artikel Liste anhand des Headers als Vorlage
         */
        if (state.auftraege && state.auftraege.length)
            for (let a of state.auftraege) {
                const templateCopy = JSON.parse(JSON.stringify(state.headers))
                for (let itm of templateCopy) {
                    itm.key = a[itm.key]
                }
                newAuftrag.push(templateCopy)
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
        newAuftrag.sort((a, b) => {
            const sort = new Intl.Collator(undefined, {
                numeric: true,
                sensitivity: 'base'
            }).compare(a[idx].key, b[idx].key)
            return state.orderDirection === 'asc' ? sort * -1 : sort
        })

        return newAuftrag
    }
}

export const actions = {
    async onHttpRequest({ dispatch }) {
        await dispatch('loadAuftraege')
    },
    async loadAuftraege({ commit }) {
        const { data } = await this.$http.post('/index.php', {
            action: 'getAuftrag'
        })
        commit('setAuftraege', data.data)
    }
}

export const mutations = {
    setAuftraege: (state, payload) => (state.auftraege = payload),
    setAuftragInputs: (state, payload) => (state.items = payload),
    setAuftragOrderBy: (state, payload) => (state.orderBy = payload),
    setAuftragOrderDirection: (state, payload) => (state.orderDirection = payload)
}
