<template>
    <div class="task-table-container">
        <el-table :data="duplicatedTableData" style="width: 100%; height: 100%" :border="true" :scrollbar-always-on="true"
            class="data-table">
            <el-table-column type='selection' width='40'></el-table-column>
            <el-table-column v-for="(tableColumn, index) in tableColumns" :key="index" :fixed="tableColumn.fixed"
                :label="tableColumn.label" :width="tableColumn.width">
                <template v-slot="scope">
                    <div v-if="tableColumn.property === 'item'"><span>{{ scope.row.content }}</span></div>
                    <div v-else-if="tableColumn.property === 'person'" class="table-data-person">
                        <img src="../assets/images/profile.jpg" alt="">
                        <span>{{ scope.row.name }}</span>
                    </div>
                    <div v-else-if="tableColumn.property === 'status'" class="table-data-status">
                        <span class="in">{{ scope.row.status }}</span>
                    </div>
                    <div v-else-if="tableColumn.property === 'priority'" class="table-data-priority">
                        <span class="in">{{ scope.row.priority }}</span>
                    </div>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tableData: [
                {
                    content: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque, molestias.',
                    name: 'Aung Aung',
                    status: 'in progress',
                    priority: 'high'
                },
            ],
            tableColumns: [
                {
                    label: 'Item',
                    property: 'item',
                    width: 500,
                    fixed: true
                },
                {
                    label: 'Person',
                    property: 'person',
                    width: 200
                },
                {
                    label: 'Status',
                    property: 'status',
                    width: 200
                },
                {
                    label: 'Deadlines',
                    property: 'deadlines',
                    width: 200
                },
                {
                    label: 'Priority',
                    property: 'priority',
                    width: 200
                },
                {
                    label: 'Date',
                    property: 'date',
                    width: 200
                },
                {
                    label: 'Tags',
                    property: 'tags',
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
    }
}
</script>

<style lang="scss">
.task-table-container {
    height: 100%;
    padding: 0 10px;

    .data-table.el-table--fit.el-table {
        font-size: 14px;

        .table-data-person {
            display: flex;
            align-items: center;
            gap: 5px;

            span {
                font-weight: bold;
                font-size: 12px;
            }

            img {
                width: 30px;
                height: 30px;
                border-radius: 50%;
            }
        }

        .table-data-status {
            span {
                background: orangered;
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
    }
}
</style>