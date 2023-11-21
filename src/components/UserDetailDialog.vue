<template>
    <el-dialog v-model="isUserDialog" title="User Detail" width="40%" align-center>
        <div class="user-detail-wrapper">
            <div class="user-detail-header">
                <img :src="userDetail.username" alt="">
                <p class="username">{{ userDetail.name }}</p>
                <p class="company-name">Yangon International School</p>
            </div>
            <div class="user-detail-item">
                <span class="user-detail-label">
                    <img src="../assets/svg-icons/faEmail.svg" alt="">
                    Email
                </span>
                : <span class="fixed-user-value">{{ userDetail.email }}</span>
            </div>
            <div class="user-detail-item">
                <span class="user-detail-label">
                    <img src="../assets/svg-icons/faDepartment.svg" alt="">
                    Department
                </span>
                : <el-select v-model="userDetail.department_id" class="department-selector"  @change="updateUser"
                    :disabled="userRole === 'guest'">
                    <el-option v-for="department in departments" :key="department.id" :label="department.name"
                        :value="department.id" />
                </el-select>
            </div>
            <div class="user-detail-item">
                <span class="user-detail-label">
                    <img src="../assets/svg-icons/faPosition.svg" alt="">
                    Position
                </span>
                : <input type="text" v-model="userDetail.position" @blur="updateUser">
            </div>
            <div class="user-detail-item">
                <span class="user-detail-label">
                    <img src="../assets/svg-icons/faRole.svg" alt="">
                    Role
                </span>
                : <span class="fixed-user-value">{{ userDetail.role }}</span>
            </div>
        </div>
        <template #footer>
            <span class="dialog-footer">
                <el-button @click="isUserDialog = false">Cancel</el-button>
            </span>
        </template>
    </el-dialog>
</template>

<script>
import { ElNotification } from 'element-plus'
import departments from '../data/departments';
export default {
    props: [
        "userDetail"
    ],
    data() {
        return {
            isUserDialog: false
        }
    },
    computed: {
        departments() {
            return departments
        },
        userRole() {
            return JSON.parse(localStorage.getItem('token')).authUser.role;
        },
    },
    methods: {
        showUserDetailDialog() {
            this.isUserDialog = !this.isUserDialog
        },
        async updateUser() {
            await this.$store.dispatch('users/updateUser',
                {
                    department_id: this.userDetail.department_id,
                    position: this.userDetail.position,
                    id: this.userDetail.id
                })
            await this.$store.dispatch('users/fetchUsers')
            ElNotification({
                title: 'Success',
                message: 'User is successfully updated.',
                type: 'success',
                duration: 2000
            })
        },
    },
}
</script>

<style lang="scss">
@import '../assets/main.scss';

.user-detail-wrapper {
    display: flex;
    flex-direction: column;
    gap: 5px;

    .user-detail-header {
        padding: 20px 10px;
        width: 100%;
        background-color: $red-color;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 10px;

        img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
        }

        .username {
            font-size: 20px;
            color: #fff;
        }

        .company-name {
            font-size: 14px;
            color: #d6d6d6;
        }
    }

    .user-detail-item {
        display: flex;
        align-items: center;
        padding: 10px 5px;
        gap: 10px;
        font-size: 13px;

        .user-detail-label {
            display: flex;
            align-items: center;
            gap: 5px;
            width: 120px;

            img {
                width: 15px;
            }
        }

        span.fixed-user-value {
            font-size: 14px;
            color: #000;
        }

        input {
            border: none;
            font-size: 13px;

            &:focus {
                outline: none;
            }
        }
    }
}
</style>