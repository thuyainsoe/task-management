<template>
    <div class="main-section">
        <div class="main-section-wrapper">
            <div class="main-section-top">
                <img src="../assets/svg-icons/faList.svg" alt="">
                Adminstration
            </div>
            <div class="main-section-bar">
                <div class="main-section-buttons">
                    <el-button type="primary" class="new-item">
                        <img src="../assets/svg-icons/elAdd.svg" alt="">
                        <span>&nbsp;New Task</span>
                    </el-button>

                    <el-button type="primary" class="new-item">
                        <img src="../assets/svg-icons/elUser.svg" alt="">
                        <span>&nbsp;Person </span>
                    </el-button>

                    <el-button type="primary" class="new-item">
                        <img src="../assets/svg-icons/elFilter.svg" alt="">
                        <span>&nbsp;&nbsp;Filter </span>
                    </el-button>
                </div>
                <div class="main-section-search">
                    <input type="text" placeholder="Search">
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
</template>

<script>
import TaskTable from './TaskTable.vue'
export default {
    components: { TaskTable },

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

                .el-button.new-item {
                    display: flex;
                    gap: 8px;
                    background-color: $yellow-color;
                    border: none;

                    img {
                        width: 14px;
                        height: 14px;
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
</style>