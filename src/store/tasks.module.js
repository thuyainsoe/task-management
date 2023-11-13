import axios from 'axios'

const state = {
  tasks: []
}

const mutations = {
  setTasks(state, tasks) {
    state.tasks = tasks
  }
}

const actions = {
  async fetchTasks({ commit }) {
    let token = JSON.parse(localStorage.getItem('token')).value
    try {
      const response = await axios.get('http://localhost:8000/api/tasks', {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      commit('setTasks', response.data)
    } catch (error) {
      console.error(error)
    }
  },
  async addTasks({ commit }, taskData) {
    let token = JSON.parse(localStorage.getItem('token')).value
    try {
      const response = await axios.post('http://localhost:8000/api/tasks', taskData, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      return response
    } catch (error) {
      return error
    }
  }
}

const getters = {
  tasks: (state) => state.tasks
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
