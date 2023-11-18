import axios from 'axios'

const state = {
  users: [],
  currentUser: null
}

const mutations = {
  setUsers(state, users) {
    state.users = users
  },
  setCurrentUser(state, users) {
    let currentUserID = JSON.parse(localStorage.getItem('token')).authUser.id;
    let currentUser = users.find((user) => user.id === currentUserID)
    state.currentUser = currentUser
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
      commit('setUsers', response.data),
      commit('setCurrentUser', response.data)
    } catch (error) {
      console.log(error)
    }
  },
  async updateUser({ commit }, payload) {
    let token = JSON.parse(localStorage.getItem('token')).value
    try {
      const response = await axios.put(
        `http://localhost:8000/api/users/${payload.id}`,
        {
          position: payload.position,
          department_id: payload.department_id
        },
        {
          headers: {
            Authorization: `Bearer ${token}`
          }
        }
      )

      return response
    } catch (error) {
      return error
    }
  }
}

const getters = {
  users: (state) => state.users,
  currentUser: (state) => state.currentUser
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
