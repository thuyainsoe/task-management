<template>
    <div class="main-section">
        <div class="main-section-wrapper">
            <div class="main-section-top">
                <img src="../assets/svg-icons/faList.svg" alt="">
                Adminstration
            </div>
            <div class="main-section-bar">
                <div class="main-section-buttons">
                    <!-- New Task -->
                    <div class="person-new-task-container">
                        <el-button type="primary" class="new-item" @click="clickNewTaskBtn">
                            <img src="../assets/svg-icons/elAdd.svg" alt="">
                            <span>&nbsp;New Task</span>
                        </el-button>
                    </div>
                    <!-- New Task End -->
                    <!-- Person Filter -->
                    <div class="person-filter-container">
                        <el-button type="primary" class="new-item" @click="showPersonFilter = !showPersonFilter">
                            <img src="../assets/svg-icons/elUser.svg" alt="">
                            <span>&nbsp;Person </span>
                        </el-button>
                        <div class="person-filter" v-if="showPersonFilter">
                            <h1 class="person-filter-title">Filter tasks by person</h1>
                            <div class="person-filter-single" v-for="(person, index) in persons" :key="index">
                                <img src="../assets/images/profile.jpg" alt="">
                                <div class="person-filter-single-detail">
                                    <span class="username">{{ person.name }}</span>
                                    <span class="position">{{ person.position }}</span>
                                </div>
                            </div>
                            <span class="arrow"></span>
                        </div>
                    </div>
                    <!-- Person Filter End -->
                    <!-- Simple Filter -->
                    <div class="person-simple-filter-container">
                        <el-button type="primary" class="new-item">
                            <img src="../assets/svg-icons/elFilter.svg" alt="">
                            <span>&nbsp;&nbsp;Filter </span>
                        </el-button>
                    </div>
                    <!-- Simple Filter End -->
                </div>
                <div class="main-section-search">
                    <input type="text" placeholder="Search" v-model="searchText">
                    <span class="search-icon">
                        <img src="../assets/svg-icons/faSearch.svg" alt="">
                    </span>
                </div>
            </div>
            <div class="main-section-task-table">
                <TaskTable />
            </div>
        </div>
    </div>
    <!-- Assigned By Dialog -->
    <el-dialog v-model="isNewTaskDialog" title="New Task" width="30%" align-center>
        <div class="newtask-form-wrapper">
            <form>
                <div class="newtask-form-item">
                    <input type="text" placeholder="Task" v-model="newTask.description">
                </div>
                <div class="newtask-form-calendar">
                    <el-date-picker class="calendar" v-model="newTask.deadlines" type="date" placeholder="Deadlines" />
                </div>
                <div class="newtask-form-selectors">
                    <el-select v-model="newTask.assigned_user_id" class="newtask-selector" placeholder="Person">
                        <el-option v-for="user in users" :key="user.id" :label="user.name" :value="user.id" />
                    </el-select>
                    <!-- <el-select v-model="newTask.status" class="newtask-selector" placeholder="Status">
                        <el-option v-for="item in statusOptions" :key="item.value" :label="item.label"
                            :value="item.value" />
                    </el-select> -->
                    <el-select v-model="newTask.priority" class="newtask-selector" placeholder="Prority">
                        <el-option v-for="item in prorityOptions" :key="item.value" :label="item.label"
                            :value="item.value" />
                    </el-select>
                </div>
                <div class="newtask-form-tags">
                    <el-select @change="changeTags" class="tag-input-dialog" popper-class="tags-dropdown" remote
                        value-key="id" filterable placement="bottom" placeholder="Tags">
                        <el-option v-for="tag in tagsOptions" :key="tag.id" :label="tag.value" :value="tag">
                        </el-option>
                    </el-select>
                    <div class="tags-container">
                        <span v-for="(tag, index) in newTask.tags" :key="index" class="single-tag"
                            @click="removeSingleTag(tag)">
                            <el-tag>{{ tag.value }}</el-tag>
                            <span class="cross-icon">
                                <img src="../assets/svg-icons/faCross.svg" alt="">
                            </span>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <template #footer>
            <span class="dialog-footer">
                <el-button @click="isNewTaskDialog = false">Cancle</el-button>
                <el-button type="primary" @click="addTaskHandler">Confirm</el-button>
            </span>
        </template>
    </el-dialog>
</template>

<script>
import TaskTable from './TaskTable.vue'
import tagsOptions from '../data/tagsOptions'
import { ElNotification } from 'element-plus'
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';


export default {
    components: { TaskTable },
    data() {
        return {
            isNewTaskDialog: false,
            showPersonFilter: false,
            searchText: '',
            debounceTimer: null,
            statusOptions: [
                {
                    value: 'in_progress',
                    label: 'In Progress'
                },
                {
                    value: 'done',
                    label: 'Done'
                },
                {
                    value: 'cancelled',
                    label: 'Camcelled'
                },
            ],
            newTask: {
                description: '',
                assigned_user_id: '',
                status: '',
                position: '',
                priority: '',
                department: '',
                deadlines: '',
                tags: [

                ],
                assigned_by: {
                    name: '',
                    position: '',
                    department: ''
                }
            },
            persons: [
                {
                    name: "Thu Yain Soe",
                    position: "Human Resource"
                },
                {
                    name: "Tin Myo Win",
                    position: "Frontend"
                },
                {
                    name: "Phone Aye Min",
                    position: "Backend"
                },
            ],
            prorityOptions: [
                {
                    value: 'high',
                    label: 'High'
                },
                {
                    value: 'low',
                    label: 'Low'
                },
                {
                    value: 'medium',
                    label: 'Medium'
                },
            ]
        }
    },
    computed: {
        tagsOptions() {
            return tagsOptions;
        },
        authUser() {
            return this.$store.getters['auth/user']
        },
        users() {
            return this.$store.getters['users/users']
        }
    },
    methods: {
        clickNewTaskBtn() {
            this.isNewTaskDialog = true
            this.$store.dispatch('users/fetchUsers')
        },
        changeTags(tag) {
            this.newTask.tags.push(tag)
        },
        removeSingleTag(tag) {
            this.newTask.tags = this.newTask.tags.filter((mainTag) => mainTag.id !== tag.id);
        },
        async addTaskHandler() {
            this.isNewTaskDialog = false
            let user = JSON.parse(localStorage.getItem('token')).authUser;
            let taskData = {
                // name: "Thu Yain Soe",
                description: this.newTask.description,
                priority: this.newTask.priority,
                due_date: this.changeDateFormat(this.newTask.deadlines),
                assigned_user_id: this.newTask.assigned_user_id
            }
            this.$store.dispatch('tasks/addTasks', taskData).then((res) => {
                if (res.status) {
                    ElNotification({
                        title: 'Success',
                        message: 'A new task is successfully created.',
                        type: 'success',
                        duration: 2000
                    })
                    this.$store.dispatch('tasks/fetchTasks')
                } else {
                    ElNotification({
                        title: 'Error',
                        message: 'Something went wrong.',
                        type: 'error',
                        duration: 2000
                    })
                }
            })
            this.newTask = { ...this.$options.data().newTask };
        },
        changeDateFormat(date) {
            let originalDate = new Date(date);

            let year = originalDate.getFullYear();
            let month = originalDate.getMonth() + 1;
            let day = originalDate.getDate();

            const formattedMonth = month < 10 ? `0${month}` : `${month}`;
            const formattedDay = day < 10 ? `0${day}` : `${day}`;
            const formattedDateString = `${year}-${formattedMonth}-${formattedDay}`;

            return formattedDateString
        }
    },
    mounted() {
        // window.Pusher = Pusher;

        // window.Echo = new Echo({
        //     broadcaster: 'pusher',
        //     key: '670e5acb7049ec790187',
        //     cluster: 'mt1',
        //     forceTLS: true
        // });

        // let user = JSON.parse(localStorage.getItem('token')).authUser;
        // window.Echo.channel(`task-assigned-${user.id}`)
        //     .listen('TaskAssigned', (data) => {
        //         console.log(data,"this is from MainSection");
        //     });
    },
    watch: {
        searchText: {
            handler(newText) {
                // Clear the previous timer if it exists
                if (this.debounceTimer) {
                    clearTimeout(this.debounceTimer)
                }

                // Set a new timer to execute the API call after 500ms (adjust as needed)
                this.debounceTimer = setTimeout(() => {
                    this.$store.dispatch('tasks/fetchTasks', newText)
                }, 500) // Change this delay to your desired milliseconds (e.g., 1000 for 1 second)
            },
            immediate: false
        }
    }
}
</script>

<style lang="scss">
@import '../assets/main.scss';

.main-section {
    flex: 6;
    height: calc(100vh - 50px);
    width: 100%;

    .main-section-wrapper {
        width: 99%;
        margin: 5px;
        border-radius: 10px;
        height: calc(100vh - 60px);
        -webkit-box-shadow: 0px 1px 15px 1px #e6e6e6;
        box-shadow: 0px 1px 15px 1px #e6e6e6;
        position: relative;

        .main-section-top {
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
            background-color: $blue-color;
            color: #fff;
            padding: 20px;
            height: 70px;
            display: flex;
            align-items: center;
            display: flex;
            gap: 7px;
            font-size: 18px;
            font-weight: 700;
            box-shadow: 0px 5px 13px -2px rgba(214, 214, 214, 0.44);
            -webkit-box-shadow: 0px 5px 13px -2px rgba(214, 214, 214, 0.44);
            -moz-box-shadow: 0px 5px 13px -2px rgba(214, 214, 214, 0.44);
        }

        .main-section-bar {
            height: 70px;
            display: flex;
            align-items: center;
            padding: 13px 20px;
            justify-content: space-between;

            .main-section-buttons {
                display: flex;
                align-items: center;
                gap: 10px;


                div {
                    .el-button.new-item {
                        display: flex;
                        gap: 8px;
                        background-color: $blue-color;
                        border: none;

                        img {
                            width: 14px;
                            height: 14px;
                        }
                    }
                }

                div.person-filter-container {
                    position: relative;

                    .person-filter {
                        padding: 10px;
                        position: absolute;
                        top: 45px;
                        left: -100px;
                        width: 300px;
                        height: auto;
                        background: #fff;
                        -webkit-box-shadow: 0px 1px 15px 1px #C2C2C2;
                        border-radius: 5px;
                        box-shadow: 0px 1px 15px 1px #C2C2C2;
                        z-index: 500;
                        display: flex;
                        flex-wrap: wrap;
                        justify-content: space-between;
                        gap: 10px;

                        .person-filter-title {
                            padding: 3px 0 3px 7px;
                            font-size: 14px;
                            width: 100%;
                            border-left: 3px solid $blue-color;
                        }

                        .person-filter-single {
                            width: 48.2%;
                            cursor: pointer;
                            box-shadow: 0px 0px 1px 1px $blue-color;
                            display: flex;
                            align-items: center;
                            padding: 7px 0px 7px 5px;
                            gap: 10px;

                            img {
                                width: 25px;
                                height: 25px;
                                border-radius: 50%;
                            }

                            .person-filter-single-detail {
                                display: flex;
                                flex-direction: column;

                                .username {
                                    font-size: 12px;
                                }

                                .position {
                                    font-size: 10px;
                                    color: #a0a0a0;
                                }
                            }
                        }

                        .arrow {
                            width: 12px;
                            height: 12px;
                            background-color: #fff;
                            position: absolute;
                            left: 140px;
                            top: -6px;
                            // border-left: 1px solid #000;
                            // border-top: 1px solid #000;
                            transform: rotate(45deg);
                        }
                    }
                }
            }

            .main-section-search {
                display: flex;
                align-items: center;
                padding: 0 5px;
                border: 1px solid #000;
                border-radius: 5px;
                width: 300px;

                .search-icon {
                    display: flex;
                    align-items: center;

                    img {
                        width: 14px;
                    }
                }

                input {
                    width: 95%;
                    padding: 10px 5px;
                    border: none;
                    outline: none;

                    &:focus {
                        outline: none;
                    }
                }
            }
        }

        .main-section-task-table {
            width: 100%;
            top: 140px;
            height: calc(100% - 140px);
            position: absolute;
        }
    }
}

.newtask-form-wrapper {
    form {
        display: flex;
        flex-direction: column;
        gap: 10px;

        .newtask-form-item {
            input {
                width: 100%;
                height: 35px;
                padding-left: 10px;
                border-radius: 5px;
                outline: none;
                border: none;
                box-shadow: 0 0 0 1px #dcdfe6;
                color: #000000;
                font-size: 14px;

                &:focus {
                    outline: none;
                }
            }
        }

        .newtask-form-calendar {
            .el-input.el-input--prefix.el-date-editor.calendar {
                width: 100%;
            }
        }

        .newtask-form-selectors {
            display: flex;
            justify-content: space-between;

            .newtask-selector {
                width: 49.6%;
            }
        }

        .newtask-form-tags {
            .tag-input-dialog {
                width: 100%;
            }

            .tags-container {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 15px;

                .single-tag {
                    position: relative;
                    cursor: pointer;

                    .cross-icon {
                        position: absolute;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        padding: 2px;
                        width: 11px;
                        height: 11px;
                        border-radius: 50%;
                        top: -5px;
                        right: -5px;
                        background-color: #fff;
                        border: 1px solid #000;

                        img {
                            width: 5px;
                        }
                    }
                }
            }
        }
    }
}
</style>