const state = {
  token: null,
  user: null
}

const mutations = {
  setUser(state, authUser) {
    state.user = authUser
  }
}

const actions = {
  async setUser({commit}, authUser) {
    commit('setUser', authUser)
  }
}

const getters = {
  user: (state) => state.user
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
