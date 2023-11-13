import { createStore } from 'vuex'
import AuthModule from './auth.module'
import TasksModule from './tasks.module'

export default createStore({
  modules: {
    auth: AuthModule,
    tasks: TasksModule
  }
})
