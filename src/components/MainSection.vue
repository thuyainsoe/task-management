<template>
    <div class="main-section">
        <div class="main-section-wrapper">
            <div class="main-section-top">
                <img src="../assets/svg-icons/faList.svg" alt="">
                Adminstration
            </div>
            <div class="main-section-bar">
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
            padding: 20px;
            height: 70px;
            display: flex;
            align-items: center;
            color: #000;
            display: flex;
            gap: 7px;
            font-size: 18px;
            box-shadow: 0px 5px 13px -2px rgba(214, 214, 214, 0.44);
            -webkit-box-shadow: 0px 5px 13px -2px rgba(214, 214, 214, 0.44);
            -moz-box-shadow: 0px 5px 13px -2px rgba(214, 214, 214, 0.44);
        }
        
        .main-section-bar {
            height: 50px;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            
            .new-item {
                display: flex;
                gap: 8px;
                img {
                    width: 17px;
                    height: 17px;
                }
            }
        }
        
        .main-section-task-table {
            width: 100%;
            top: 120px;
            height: calc(100% - 120px);
            position: absolute;
        }
    }
}
</style>