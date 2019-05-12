export const state = () => ({
    navShown: false
})

export const getters = {
    isNavShown: state => state.navShown
}

export const mutations = {
    setNavShown: (state, payload) => (state.navShown = payload)
}
