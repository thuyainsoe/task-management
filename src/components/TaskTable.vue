<template>
    <div class="task-table-container">
        <el-table :data="tableData" style="width: 100%; height: 100%" :border="true" :scrollbar-always-on="true"
            class="data-table">
            <el-table-column type='selection' width='40'></el-table-column>
            <el-table-column v-for="(tableColumn, index) in tableColumns" :key="index" :fixed="tableColumn.fixed"
                :label="tableColumn.label" :width="tableColumn.width">
                <template v-slot="scope">
                    <div v-if="tableColumn.property === 'task'"><span>{{ scope.row.content }}</span></div>
                    <div v-else-if="tableColumn.property === 'person'" class="table-data-person">
                        <img src="../assets/images/profile.jpg" alt="">
                        <div class="person-detail">
                            <span class="person-name">{{ scope.row.name }}</span>
                            <span class="person-position">{{ scope.row.position }}</span>
                        </div>
                    </div>
                    <div v-else-if="tableColumn.property === 'department'" class="table-data-department">
                        <span>{{ scope.row.department }}</span>
                    </div>
                    <div v-else-if="tableColumn.property === 'status'" class="table-data-status">
                        <el-select v-model="scope.row.status" :class="getStatusClass(scope.row.status)"
                            class="m-2 status-selector" placeholder="Select">
                            <el-option v-for="item in statusOptions" :key="item.value" :value="item.value"
                                :label="item.label" :class="item.class" />
                        </el-select>
                        <div class="label-show">
                            <span v-if="scope.row.status === 'in progress'" class="in-progress">{{ scope.row.status
                            }}</span>
                            <span v-else-if="scope.row.status === 'started'" class="started">{{ scope.row.status }}</span>
                            <span v-else-if="scope.row.status === 'completed'" class="completed">{{ scope.row.status
                            }}</span>
                        </div>
                    </div>
                    <div v-else-if="tableColumn.property === 'priority'" class="table-data-priority">
                        <el-select v-model="scope.row.priority" :class="getStatusClass(scope.row.status)"
                            class="m-2 status-selector" placeholder="Select">
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
                        <el-date-picker class="deadlines-calendar" v-model="scope.row.deadlines" type="date"
                            placeholder="Pick a day" />
                    </div>
                    <div v-else-if="tableColumn.property === 'tags'" class="table-data-deadlines">
                        <span v-for="(tag, index) in scope.row.tags" :key="index">
                            <el-tag size="small">{{ tag }}</el-tag>
                        </span>
                    </div>
                    <div v-else-if="tableColumn.property === 'assigned_by'" class="table-data-assigned-by"
                        @click="assignedByClick(scope.row.assigned_by)">
                        <img src="../assets/images/profile.jpg" alt="">
                        <div class="person-detail">
                            <span class="person-name">{{ scope.row.assigned_by.name }}</span>
                            <span class="person-position">{{ scope.row.assigned_by.position }}</span>
                        </div>
                    </div>
                </template>
            </el-table-column>
        </el-table>

        <el-dialog v-model="isAssignedByDialog" title="Assigned By" width="20%" align-center>
            <div class="assigned-by-detail">
                <img src="../assets/images/profile.jpg" alt="">
                <span class="assigned-by-detail-name">{{ cloneAssignedBy.name }}</span>
                <span class="assigned-by-detail-position">{{ cloneAssignedBy.position }}</span>
                <span class="assigned-by-detail-department">{{ cloneAssignedBy.department }} Department</span>
            </div>
            <template #footer>
                <span class="dialog-footer">
                    <el-button @click="isAssignedByDialog = false">Cancle</el-button>
                </span>
            </template>
        </el-dialog>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isAssignedByDialog: false,
            cloneAssignedBy: null,
            tableData: [
                {
                    content: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque, molestias.',
                    name: 'Aung Aung',
                    status: 'in progress',
                    position: 'Customer Support',
                    priority: 'high',
                    department: 'Adminstration',
                    deadlines: '2023-2-20',
                    tags: ['Meetings', 'Interviews', 'Social Media'],
                    assigned_by: {
                        name: 'Thu Yain Soe',
                        position: 'Human Resource',
                        department: 'Adminstration'
                    }
                },
                {
                    content: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque, molestias.',
                    name: 'Kyaw Myo Htun',
                    status: 'completed',
                    position: 'Frontend Developer',
                    priority: 'low',
                    department: 'IT',
                    deadlines: '2023-2-10',
                    tags: ['Meetings', 'Interviews', 'Club'],
                    assigned_by: {
                        name: 'Kyaw Min Tun',
                        position: 'Human Resource',
                        department: 'Adminstration'
                    }
                },
            ],
            tableColumns: [
                {
                    label: 'Task',
                    property: 'task',
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
            ],
            statusOptions: [
                {
                    label: 'In Progress',
                    value: 'in progress',
                    class: 'in_progress'
                },
                {
                    label: 'Started',
                    value: 'started',
                    class: 'started'
                },
                {
                    label: 'Completed',
                    value: 'completed',
                    class: 'completed'
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
                } else if (status === 'completed') {
                    return 'completed';
                } else if (status === 'started') {
                    return 'started';
                }
                return '';
            };
        },
    },
    methods: {
        assignedByClick(data) {
            this.cloneAssignedBy = data
            this.isAssignedByDialog = true
        }
    }
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

                .started {
                    background-color: red;
                }

                .completed {
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

        .table-data-deadlines {
            display: flex;
            gap: 5px;
        }
    }

    .assigned-by-detail {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 20px;

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

        .assigned-by-detail-position,
        .assigned-by-detail-department {
            font-size: 14px;
            font-weight: 500;
        }
    }
}
</style>