import { createStore } from 'vuex'
import AuthModule from './auth.module'
import TasksModule from './tasks.module'
import NotificationModule from './notification.module'
import UsersModule from './users.module'

export default createStore({
  modules: {
    auth: AuthModule,
    tasks: TasksModule,
    notifications: NotificationModule,
    users: UsersModule
  }
})
