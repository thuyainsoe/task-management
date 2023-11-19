<template>
    <div class="task-table-container">
        <el-table :data="tasks" style="width: 100%; height: 100%" :border="true" :scrollbar-always-on="true"
            class="data-table" v-loading="tasksLoading">
            <!-- <el-table-column type='selection' width='40'></el-table-column>s -->
            <el-table-column v-for="(tableColumn, index) in tableColumns" :key="index" :fixed="tableColumn.fixed"
                :label="tableColumn.label" :width="tableColumn.width">
                <template v-slot="scope">
                    <div v-if="tableColumn.property === 'task_name'"><span>{{ scope.row.name }}</span></div>
                    <div v-if="tableColumn.property === 'task_description'"><span>{{ scope.row.description }}</span></div>
                    <div v-else-if="tableColumn.property === 'person'" class="table-data-person">
                        <img :src="scope.row.assignment.assigned_user.username" alt="">
                        <div class="person-detail">
                            <span class="person-name">{{ scope.row.assignment ? scope.row.assignment.assigned_user.name :
                                '-' }}</span>
                            <span class="person-position">{{ scope.row.assignment.assigned_user.position ?
                                scope.row.assignment.assigned_user.position : '-' }}</span>
                        </div>
                    </div>
                    <div v-else-if="tableColumn.property === 'department'" class="table-data-department">
                        <span>{{ scope.row.assignment.assigned_user.department ?
                            scope.row.assignment.assigned_user.department.name : '-' }}</span>
                    </div>
                    <div v-else-if="tableColumn.property === 'status'" class="table-data-status">
                        <el-select v-model="scope.row.status" :class="getStatusClass(scope.row.status)"
                            class="m-2 status-selector" placeholder="Select" @change="updateTask(scope.row)"
                            :disabled="!isSelfTask(scope.row) && !isAdmin">
                            <el-option v-for="item in statusOptions" :key="item.value" :value="item.value"
                                :label="item.label" :class="item.class" />
                        </el-select>
                        <div class="label-show">
                            <span v-if="scope.row.status === 'in_progress'" class="in-progress">{{
                                formattedStatus(scope.row.status)
                            }}</span>
                            <span v-else-if="scope.row.status === 'cancelled'" class="cancelled">{{ scope.row.status
                            }}</span>
                            <span v-else-if="scope.row.status === 'done'" class="done">{{ scope.row.status
                            }}</span>
                        </div>
                    </div>
                    <div v-else-if="tableColumn.property === 'priority'" class="table-data-priority">
                        <el-select v-model="scope.row.priority" :class="getStatusClass(scope.row.status)"
                            class="m-2 status-selector" placeholder="Select" @change="updateTask(scope.row)"
                            :disabled="!isSelfTask(scope.row) && !isAdmin">
                            <el-option v-for="item in priorityOptions" :key="item.value" :value="item.value"
                                :label="item.label" :class="item.class" />
                        </el-select>
                        <div class="label-show">
                            <span v-if="scope.row.priority === 'high'" class="high">{{ scope.row.priority }}</span>
                            <span v-else-if="scope.row.priority === 'low'" class="low">{{ scope.row.priority }}</span>
                            <span v-else-if="scope.row.priority === 'medium'" class="medium">{{ scope.row.priority }}</span>
                        </div>
                    </div>
                    <div v-else-if="tableColumn.property === 'deadlines'" class="table-data-deadlines">
                        <el-date-picker class="deadlines-calendar" v-model="scope.row.due_date" type="date"
                            placeholder="Pick a day" @change="updateTask(scope.row)" :disabled="!isAdmin" />
                    </div>
                    <div v-else-if="tableColumn.property === 'tags'" class="table-data-tags" @click="tagsClick(scope.row)">
                        <span v-for="(tag, index) in scope.row.tags" :key="index">
                            <el-tag size="small">{{ tag.name }}</el-tag>
                        </span>
                    </div>
                    <div v-else-if="tableColumn.property === 'assigned_by'" class="table-data-assigned-by"
                        @click="assignedByClick(scope.row)">
                        <img :src="scope.row.assignment.assigned_by.username" alt="">
                        <div class="person-detail">
                            <span class="person-name">{{ scope.row.assignment.assigned_by.name ?
                                scope.row.assignment.assigned_by.name : '-' }}</span>
                            <span class="person-position">{{ scope.row.assignment.assigned_by.position ?
                                scope.row.assignment.assigned_by.position : '-'
                            }}</span>
                        </div>
                    </div>
                    <div v-else-if="tableColumn.property === 'remark'" class="table-data-remark"
                        @click="remarkClick(scope.row)">
                        <img src="../assets/svg-icons/faMessage.svg" alt="">
                    </div>
                </template>
            </el-table-column>
        </el-table>

        <!-- Assigned By Dialog -->
        <el-dialog v-model="isAssignedByDialog" title="Assigned By" width="20%" align-center>
            <div class="assigned-by-detail">
                <div class="assigned-by-detail-header">
                    <img :src="cloneData.assignment.assigned_by.username" alt="">
                    <span class="assigned-by-detail-name">{{ cloneData.assignment.assigned_by ?
                        cloneData.assignment.assigned_by.name : '' }}</span>
                </div>
                <span class="assigned-by-detail-position">
                    <span>
                        Position
                    </span>
                    : {{ cloneData.assignment.assigned_by ?
                        cloneData.assignment.assigned_by.position : '' }}
                </span>
                <span class="assigned-by-detail-department">
                    <span>
                        Department
                    </span>
                    : {{ cloneData.assignment.assigned_by ?
                        cloneData.assignment.assigned_by.department.name : '' }}
                    Department
                </span>
            </div>
            <template #footer>
                <span class="dialog-footer">
                    <el-button @click="isAssignedByDialog = false">Cancle</el-button>
                </span>
            </template>
        </el-dialog>

        <!-- Tags Dialog -->
        <el-dialog v-model="isTagsDialog" title="Tags" width="30%" align-center v-if="isAdmin">
            <div class="tag-detail">
                <div class="tag-detail-current-user">
                    <img :src="cloneData.assignment.assigned_user.username" alt="">
                    <div class="user-content">
                        <span class="username">{{ cloneData.assignment.assigned_user.name ?
                            cloneData.assignment.assigned_user.name : '-' }}</span>
                        <span class="position">{{ cloneData.assignment.assigned_user.position ?
                            cloneData.assignment.assigned_user.position : '-' }}</span>
                    </div>
                </div>
                <el-select value="" @change="changeTags" class="tag-input-dialog" popper-class="tags-dropdown" remote
                    value-key="id" filterable placement="bottom">
                    <el-option v-for="tag in tagsOptions" :key="tag.id" :label="tag.value" :value="tag">
                    </el-option>
                </el-select>
                <div class="tags-container">
                    <span v-for="(tag, index) in cloneData.tags" :key="index" class="single-tag">
                        <el-tag>{{ tag.name ? tag.name : tag.value }}</el-tag>
                        <span class="cross-icon" @click="deleteSingleTag(tag)">
                            <img src="../assets/svg-icons/faCross.svg" alt="">
                        </span>
                    </span>
                </div>
            </div>
            <template #footer>
                <span class="dialog-footer">
                    <el-button type="primary"
                        @click="updateTask(cloneData), isTagsDialog = !isTagsDialog">Confirm</el-button>
                    <el-button @click="isTagsDialog = false">Cancle</el-button>
                </span>
            </template>
        </el-dialog>

        <!-- Remark Drawer -->
        <!-- :title="cloneData.description" -->
        <el-drawer v-model="remarkDrawer" :title="cloneData ? cloneData.description : ''" direction="rtl">
            <div class="remark-wrapper">
                <div class="remark-person-detail">
                    <img :src="cloneData.assignment.assigned_user.username" alt="">
                    <p>{{ cloneData.assignment.assigned_user.name }}</p>
                </div>
                <div class="remark-detail-show-container">
                    <div v-if="responseFiles.length < 1 && responseComments.length < 1" class="no-file-desc">
                        There are no comments as of now.
                    </div>
                    <div v-for="file in responseFiles" :key="file.id" class="file-link">
                        <img src="../assets/svg-icons/faTextfile.svg" alt="" @click="downloadFile(file)">
                        {{ file.file_name }}
                    </div>
                    <div v-for="comment in responseComments" :key="comment.id" class="comment-text">
                        <img src="../assets/svg-icons/faMessageBlack.svg" alt="">
                        {{ comment.description }}
                    </div>
                </div>
                <div class="remark-input-field-container">
                    <div class="remark-text-input">
                        <input type="text" placeholder="Write an update" v-model="updateText">
                    </div>
                    <div class="remark-buttons">
                        <div class="file-upload">
                            <input type="file" ref="fileInput" @change="handleFileUpload" />
                            <span class="upload-container">
                                <img src="../assets/svg-icons/faFileupload.svg" alt="" @click="uploadIconClick">
                                <div v-if="uploadStatus" class="upload-status">{{ uploadStatus }}</div>
                            </span>
                            <button class="remark-file-button" @click="fileUploadClick">
                                Upload
                            </button>
                        </div>
                        <button class="remark-update-button" @click="clickUpdateText">
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </el-drawer>
    </div>
</template>

<script>
import tagsOptions from '../data/tagsOptions';
import { ElNotification } from 'element-plus'
import axios from 'axios'

export default {
    data() {
        return {
            isAssignedByDialog: false,
            isTagsDialog: false,
            cloneData: null,
            tagInput: '',
            updateText: '',
            remarkDrawer: false,
            uploadStatus: 'Choose File',
            file: null,
            responseFiles: [],
            responseComments: [],
            tableColumns: [
                {
                    label: 'Task Name',
                    property: 'task_name',
                    width: 200,
                    fixed: true
                },
                {
                    label: 'Task Description',
                    property: 'task_description',
                    width: 500,
                    fixed: true
                },
                {
                    label: 'Person',
                    property: 'person',
                    width: 200
                },
                {
                    label: 'Department',
                    property: 'department',
                    width: 200
                },
                {
                    label: 'Status',
                    property: 'status',
                    width: 200
                },
                {
                    label: 'Priority',
                    property: 'priority',
                    width: 200
                },
                {
                    label: 'Deadlines',
                    property: 'deadlines',
                    width: 200
                },
                {
                    label: 'Tags',
                    property: 'tags',
                    width: 400,
                },
                {
                    label: 'Assigned By',
                    property: 'assigned_by',
                    width: 200,
                },
                {
                    label: 'Remark',
                    property: 'remark',
                    width: 100
                }
            ],
            statusOptions: [
                {
                    label: 'In Progress',
                    value: 'in_progress',
                    class: 'in_progress'
                },
                {
                    label: 'Cancelled',
                    value: 'cancelled',
                    class: 'cancelled'
                },
                {
                    label: 'Done',
                    value: 'done',
                    class: 'done'
                },
            ],
            priorityOptions: [
                {
                    label: 'High',
                    value: 'high',
                    class: 'high'
                },
                {
                    label: 'Low',
                    value: 'low',
                    class: 'low'
                },
                {
                    label: 'Medium',
                    value: 'medium',
                    class: 'medium'
                },
            ],
        }
    },
    computed: {
        getStatusClass() {
            return (status) => {
                if (status === 'in_progress') {
                    return 'in-progress';
                } else if (status === 'done') {
                    return 'done';
                } else if (status === 'cancelled') {
                    return 'cancelled';
                }
                return '';
            };
        },
        tagsOptions() {
            return tagsOptions;
        },
        tasks() {
            return this.$store.getters['tasks/tasks']
        },
        isAdmin() {
            return JSON.parse(localStorage.getItem('token')).authUser.role === 'admin';
        },
        tasksLoading() {
            return this.$store.getters['tasks/tasksLoading']
        }
    },
    methods: {
        assignedByClick(data) {
            this.cloneData = data
            this.isAssignedByDialog = true
        },
        tagsClick(data) {
            this.cloneData = data
            this.isTagsDialog = true
        },
        changeTags(tag) {
            this.cloneData.tags.push(tag)
        },
        deleteSingleTag(tag) {
            this.cloneData.tags = this.cloneData.tags.filter((cloneTag) => cloneTag.id !== tag.id)
        },
        updateTask(data) {
            let dueDate = this.changeDateFormat(data.due_date)
            let tagsArray = this.cloneData ? this.cloneData.tags.map((cloneTag) => cloneTag.id) : []
            let variable = {
                id: data.id,
                status: data.status,
                priority: data.priority,
                due_date: dueDate,
                tags: tagsArray
            }
            this.$store.dispatch('tasks/updateTask', variable).then((res) => {
                if (res.status) {
                    ElNotification({
                        title: 'Success',
                        message: 'Task is successfully updated.',
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
        },
        async remarkClick(data) {
            this.remarkDrawer = !this.remarkDrawer
            this.cloneData = data
            await this.fetchFiles()
            await this.fetchComments()
        },
        async fetchFiles() {
            try {
                let token = JSON.parse(localStorage.getItem('token')).value
                const response = await axios.get(`http://localhost:8000/api/tasks/${this.cloneData.id}/files`, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                })
                this.responseFiles = response.data
            } catch (error) {
                console.error(error)
            }
        },
        async fetchComments() {
            try {
                let token = JSON.parse(localStorage.getItem('token')).value
                const response = await axios.get(`http://localhost:8000/api/tasks/${this.cloneData.id}/comments`, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                })
                console.log(response)
                this.responseComments = response.data
            } catch (error) {
                console.error(error)
            }
        },
        isSelfTask(data) {
            let currentUserId = JSON.parse(localStorage.getItem('token')).authUser.id;
            return data.assignment.assigned_user.id === currentUserId
        },
        formattedStatus(data) {
            return data.replace(/_/g, ' ').replace(/\b\w/g, function (char) {
                return char.toUpperCase();
            });;
        },
        uploadIconClick() {
            this.$nextTick(() => {
                this.$refs.fileInput.click()
            })
        },
        fileUploadClick() {
            if (!this.file) {
                this.uploadStatus = 'Please select a file.';
                return;
            }
            let formData = new FormData();
            formData.append('file', this.file);
            formData.append('task_id', this.cloneData.id)
            let token = JSON.parse(localStorage.getItem('token')).value
            axios.post('http://localhost:8000/api/files', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    Authorization: `Bearer ${token}`
                }
            }).then(async (res) => {
                this.uploadStatus = 'File uploaded successfully'
                this.file = null
                await this.fetchFiles()
                await this.fetchComments()
            }).catch((error) => {
                console.log(error)
                this.uploadStatus = 'Error uploading file'
            })
        },
        handleFileUpload(event) {
            this.file = event.target.files[0]
            this.uploadStatus = event.target.files[0].name
        },
        async clickUpdateText() {
            await this.$store.dispatch('tasks/updateComment', { comment: this.updateText, id: this.cloneData.id })
            await this.fetchFiles()
            await this.fetchComments()
            this.updateText = ''
        },
        async downloadFile(file) {
            console.log(file)
            try {
                let token = JSON.parse(localStorage.getItem('token')).value
                const response = await axios.get(`http://localhost:8000/api/files/${file.id}/download`, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                })
                console.log(response,"this is response")
            } catch (error) {
                console.error(error)
            }
        }
    },
    async mounted() {
        this.$store.dispatch('tasks/fetchTasks')
    },
}
</script>

<style lang="scss">
@import '../assets/main.scss';
@import '../assets/scss/status.scss';
@import '../assets/scss/priority.scss';

.task-table-container {
    height: 100%;
    padding: 0 10px;

    .data-table.el-table--fit.el-table {
        font-size: 14px;

        .table-data-person,
        .table-data-assigned-by {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;

            .person-detail {
                display: flex;
                flex-direction: column;
                justify-content: space-between;

                .person-name {
                    font-weight: bold;
                    font-size: 13px;
                }

                .person-position {
                    font-size: 11px;
                    font-weight: bold;
                    color: $gray-color;
                    margin-top: -5px;
                }
            }

            img {
                width: 30px;
                height: 30px;
                border-radius: 50%;
            }
        }

        .table-data-status {
            position: relative;

            .label-show {
                span {
                    position: absolute;
                    top: 5px;
                    left: 10px;
                    width: 100px;
                    height: 25px;
                    color: #fff;
                    text-transform: capitalize;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 5px;
                    z-index: 800;
                    padding: 3px 7px;
                }

                .in-progress {
                    background-color: #faa919;
                }

                .cancelled {
                    background-color: red;
                }

                .done {
                    background-color: green;
                }
            }

            .el-select.status-selector {
                width: 140px;

                .select-trigger.el-tooltip__trigger {
                    .el-input.el-input--suffix {
                        box-shadow: none;

                        .el-input__wrapper {
                            box-shadow: none;
                            background-color: transparent;

                            input.el-input__inner {
                                text-align: center;
                                text-transform: capitalize;
                                color: #fff;
                                border-radius: 5px;
                                font-size: 12px;
                            }
                        }

                        .el-input__wrapper.is-focus {
                            box-shadow: none !important;
                            background-color: transparent !important;
                        }
                    }
                }
            }
        }

        .table-data-priority {
            position: relative;

            .label-show {
                span {
                    position: absolute;
                    top: 5px;
                    left: 10px;
                    width: 70px;
                    height: 25px;
                    color: #fff;
                    text-transform: capitalize;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 5px;
                    z-index: 800;
                    padding: 3px 7px;
                }

                .high {
                    background-color: red;
                }

                .low {
                    background-color: #faa919;
                }

                .medium {
                    background-color: green;
                }
            }

            .el-select.status-selector {
                width: 140px;

                .select-trigger.el-tooltip__trigger {
                    .el-input.el-input--suffix {
                        box-shadow: none;

                        .el-input__wrapper {
                            box-shadow: none;
                            background-color: transparent;

                            input.el-input__inner {
                                text-align: center;
                                text-transform: capitalize;
                                color: #fff;
                                border-radius: 5px;
                                font-size: 12px;
                            }
                        }

                        .el-input__wrapper.is-focus {
                            box-shadow: none !important;
                            background-color: transparent !important;
                        }
                    }
                }
            }
        }

        .table-data-deadlines {
            .el-date-editor--date.deadlines-calendar {
                width: 100%;
                outline: none;
                border: none;

                .el-input__wrapper {
                    box-shadow: none;
                }
            }
        }

        .table-data-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            cursor: pointer;
        }

        .table-data-remark {
            cursor: pointer;
        }
    }

    .assigned-by-detail {
        display: flex;
        flex-direction: column;
        justify-content: center;
        // align-items: center;
        gap: 20px;

        .assigned-by-detail-header {
            display: flex;
            align-items: center;
            gap: 10px;

            img {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                border: 4px solid $blue-color;
            }

            .assigned-by-detail-name {
                font-weight: bold;
                font-size: 18px;
            }
        }

        .assigned-by-detail-position,
        .assigned-by-detail-department {
            font-size: 14px;
            font-weight: 500;

            span {
                width: 80px;
                display: inline-block;
                font-weight: 700;
            }
        }
    }

    .tag-detail {
        display: flex;
        flex-direction: column;
        gap: 15px;

        .tag-detail-current-user {
            width: 100%;
            gap: 13px;
            display: flex;
            align-items: center;

            img {
                width: 60px;
                height: 60px;
                border-radius: 50%;
            }

            .user-content {
                display: flex;
                flex-direction: column;
                gap: 5px;

                .username {
                    font-size: 18px;
                    font-weight: bold;
                }

                .position {
                    font-size: 15px;
                }
            }
        }

        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;

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

    .remark-wrapper {
        display: flex;
        flex-direction: column;
        gap: 10px;

        .remark-person-detail {
            display: flex;
            align-items: center;
            gap: 6px;
            padding-left: 5px;
            border-left: 2px solid $red-color;
            margin-bottom: 20px;

            img {
                border-radius: 50%;
                width: 40px;
                height: 40px;
            }

            p {
                font-size: 14px;
            }
        }

        .remark-detail-show-container {
            width: 100%;
            min-height: 100px;
            display: flex;
            padding: 15px;
            gap: 10px;
            border: 1px solid #000;
            border-radius: 5px;
            font-size: 14px;
            flex-direction: column;
            position: relative;

            .no-file-desc {
                align-self: center;
                top: 50%;
                transform: translateY(-50%);
                position: absolute;
            }

            .file-link,
            .comment-text {
                display: flex;
                align-items: center;
                color: $blue-color;
                gap: 8px;
                cursor: pointer;
            }

            .comment-text {
                color: #000;
                cursor: initial;
            }
        }

        .remark-input-field-container {
            display: flex;
            flex-direction: column;
            gap: 5px;

            .remark-text-input {
                input {
                    width: 100%;
                    height: 50px;
                    border-radius: 5px;
                    padding-left: 10px;
                    border: 1px solid #000;

                    &:focus {
                        outline: none;
                    }
                }
            }

            .remark-buttons {
                margin-top: 10px;
                display: flex;
                align-items: flex-end;
                justify-content: space-between;

                .file-upload {
                    display: flex;
                    flex-direction: column;
                    gap: 8px;

                    .upload-container {
                        display: flex;
                        gap: 10px;
                        align-items: center;

                        img {
                            width: 24px;
                            cursor: pointer;
                        }

                        .upload-status {
                            font-size: 13px;
                        }
                    }


                    input {
                        display: none;
                    }
                }

                .remark-update-button,
                .remark-file-button {
                    width: max-content;
                    padding: 8px 14px;
                    border-radius: 3px;
                    border: none;
                    background-color: $blue-color;
                    color: #fff;
                    cursor: pointer;
                }
            }


        }
    }
}

.tags-dropdown[data-popper-placement="right"] {
    display: none;
}
</style>