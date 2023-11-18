import axios from 'axios'
const state = {
  notifications: [],
  notiCount: 0
}

const mutations = {
  setNotifications(state, notifications) {
    state.notifications = notifications
  },
  setNotiCount(state, count) {
    state.notiCount = count
  }
}

const actions = {
  async fetchNotifications({ commit }, payload) {
    try {
      let token = JSON.parse(localStorage.getItem('token')).value
      const response = await axios.get('http://localhost:8000/api/notifications', {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      console.log(response)
      commit('setNotifications', response.data)
      commit('setNotiCount', response.data.length)
    } catch (error) {
      console.log(error)
    }
  }
}

const getters = {
  notifications: (state) => state.notifications,
  notiCount: (state) => state.notiCount
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
