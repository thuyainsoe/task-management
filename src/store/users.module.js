import axios from 'axios'

const state = {
  users: []
}

const mutations = {
  setUsers(state, users) {
    state.users = users
  }
}

const actions = {
  // Fetch User
  async fetchUsers({ commit }) {
    let token = JSON.parse(localStorage.getItem('token')).value
    try {
      const response = await axios.get('http://localhost:8000/api/users', {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      commit('setUsers', response.data)
    } catch (error) {
      console.log(error)
    }
  }
}

const getters = {
  users: (state) => state.users
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
