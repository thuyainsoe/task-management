<template>
    <div class="task-table-container">
        <el-table :data="duplicatedTableData" style="width: 100%; height: 100%" :border="true" :scrollbar-always-on="true"
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
                        <span class="in">{{ scope.row.status }}</span>
                    </div>
                    <div v-else-if="tableColumn.property === 'priority'" class="table-data-priority">
                        <span class="in">{{ scope.row.priority }}</span>
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
            ]
        }
    },
    computed: {
        duplicatedTableData() {
            return Array.from({ length: 20 }, (_, index) => {
                const newItem = { ...this.tableData[0] };
                newItem.id = index + 1;
                return newItem;
            });
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
            span {
                background: rgb(228, 228, 10);
                padding: 5px 10px;
                border-radius: 5px;
                color: #fff;
                // font-size: 12px;
                text-transform: capitalize;
            }
        }

        .table-data-priority {
            span {
                background: red;
                padding: 5px 10px;
                border-radius: 5px;
                color: #fff;
                text-transform: capitalize;
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

        .assigned-by-detail-position,.assigned-by-detail-department {
            font-size: 14px;
            font-weight: 600;
        } 
    }
}
</style>