import axios from 'axios'

const state = {
  tasks: [],
  departmentIndex: null,
  tasksLoading: false
}

const mutations = {
  setTasks(state, tasks) {
    state.tasks = tasks
  },
  setDepartmentIndex(state, index) {
    state.departmentIndex = index
  },
  setTasksLoading(state, value) {
    state.tasksLoading = value
  }
}

const actions = {
  // Fetch Task
  async fetchTasks({ commit }, payload) {
    let token = JSON.parse(localStorage.getItem('token')).value
    let departmentIndex = state.departmentIndex
    try {
      commit('setTasksLoading', true)
      const response = await axios.get('http://localhost:8000/api/tasks', {
        headers: {
          Authorization: `Bearer ${token}`
        },
        params: {
          search: payload ? payload.searchText : '',
          user_id: payload ? payload.user_id : '',
          status: payload ? payload.status : '',
          priority: payload ? payload.priority : '',
          department_id: departmentIndex ? departmentIndex : ''
        }
      })
      commit('setTasks', response.data)
      setTimeout(() => {
        commit('setTasksLoading', false)
      }, 500)
    } catch (error) {
      console.error(error)
    }
  },
  // Add Task
  async addTasks({ commit }, taskData) {
    let token = JSON.parse(localStorage.getItem('token')).value
    try {
      commit('setTasksLoading', true)
      const response = await axios.post('http://localhost:8000/api/tasks', taskData, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      })
      setTimeout(() => {
        commit('setTasksLoading', false)
      }, 500)
      return response
    } catch (error) {
      return error
    }
  },
  // Update Task
  async updateTask({ commit }, taskData) {
    let token = JSON.parse(localStorage.getItem('token')).value
    try {
      commit('setTasksLoading', true)
      const response = await axios.put(
        `http://localhost:8000/api/tasks/${taskData.id}`,
        {
          id: taskData.id,
          status: taskData.status,
          priority: taskData.priority,
          due_date: taskData.due_date,
          tags: taskData.tags
        },
        {
          headers: {
            Authorization: `Bearer ${token}`
          }
        }
      )
      setTimeout(() => {
        commit('setTasksLoading', false)
      }, 500)
      return response
    } catch (error) {
      return error
    }
  },

  async updateComment({ commit }, payload) {
    let token = JSON.parse(localStorage.getItem('token')).value
    try {
      const response = await axios.put(
        `http://localhost:8000/api/tasks/${payload.id}`,
        {
          comment: payload.comment
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
  tasks: (state) => state.tasks,
  departmentIndex: (state) => state.departmentIndex,
  tasksLoading: (state) => state.tasksLoading
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}
