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
  // Fetch Task
  async fetchTasks({ commit }, searchText) {
    let token = JSON.parse(localStorage.getItem('token')).value
    try {
      const response = await axios.get('http://localhost:8000/api/tasks', {
        headers: {
          Authorization: `Bearer ${token}`
        },
        params: {
          search: searchText ? searchText : ''
        }
      })
      commit('setTasks', response.data)
    } catch (error) {
      console.error(error)
    }
  },
  // Add Task
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
  },
  // Update Task
  async updateTask({ commit }, taskData) {
    let token = JSON.parse(localStorage.getItem('token')).value
    try {
      const response = await axios.put(
        `http://localhost:8000/api/tasks/${taskData.id}`,
        {
          id: taskData.id,
          status: taskData.status,
          priority: taskData.priority,
          due_date: taskData.due_date,
          comment: '',
          tags: taskData.tagsArray
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
  tasks: (state) => state.tasks
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
