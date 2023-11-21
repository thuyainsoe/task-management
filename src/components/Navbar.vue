<template>
    <div class="navbar-container">
        <div class="navbar-left">
            <div class="navbar-logo">
                YIS<span>.</span>
            </div>
            <div class="navbar-roles">
                <img src="../assets/svg-icons/faUser.svg" alt="">
                <span>{{ userRole }}</span>
            </div>
        </div>
        <div class="navbar-right">
            <div class="navbar-noti" ref="navbarNoti">
                <img src="../assets/svg-icons/faBell.svg" alt="" @click="clickNoti">
                <span class="noti-count" v-if="notiCount !== 0">{{ notiCount }}</span>

                <!-- For Noti Dialog -->
                <div class="navbar-noti-dialog" v-if="showNotiDialog && notiCount !== 0">
                    <div v-for="noti in notifications" :key="noti.id" class="navbar-noti-item-container">
                        <!-- <img src="../assets/images/profile.jpg" alt="" class="navbar-noti-profile-img"> -->
                        <div class="navbar-noti-detail">
                            <!-- <span class="navbar-noti-user-email">thuyainsoe163361@gmail.com</span> -->
                            <span class="navbar-noti-content">{{ noti.message }}</span>
                            <span class="navbar-noti-date">{{ getTimeAgo(noti.created_at) }}</span>
                        </div>
                    </div>
                </div>
                <div class="navbar-noti-no-data" v-else-if="showNotiDialog && notiCount == 0">
                    There are no updates or notifications.
                </div>
            </div>
            <div class="navbar-user" ref="navbarUser">
                <img :src="userAvator" alt="" @click="showUserDetail = !showUserDetail">
                <div class="navbar-user-detail" v-if="showUserDetail">
                    <div class="navbar-user-logo">
                        YIS<span>.</span>
                    </div>
                    <div class="navbar-user-item" @click="clickMyProfile">
                        <img src="../assets/svg-icons/faUser.svg" alt="">
                        <span>My Profile</span>
                    </div>
                    <div class="navbar-user-item" @click="logoutHandler">
                        <img src="../assets/svg-icons/faLogout.svg" alt="">
                        <span>Logout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <UserDetailDialog :userDetail="authUser" ref="userDetailDialog"/>
</template>

<script>
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import moment from 'moment';
import UserDetailDialog from './UserDetailDialog.vue';
export default {
    data() {
        return {
            showUserDetail: false,
            showNotiDialog: false,
            isUserDialog: false,
        }
    },
    components: {
        UserDetailDialog
    },
    computed: {
        userAvator() {
            const authUser = JSON.parse(localStorage.getItem('token')).authUser;
            if (authUser) {
                return authUser.username; // Return the username
            }
            return '';
        },
        authUser() {
            return this.$store.getters['users/currentUser'];
        },
        notifications() {
            return this.$store.getters['notifications/notifications'];
        },
        departments() {
            return departments
        },
        notiCount() {
            return this.$store.getters['notifications/notiCount'];
        },
        userRole() {
            return JSON.parse(localStorage.getItem('token')).authUser.role;
        }
    },
    methods: {
        logoutHandler() {
            localStorage.removeItem('token');
            this.$router.push('/login').catch(err => { console.log(err) });
        },
        clickNoti() {
            this.showNotiDialog = !this.showNotiDialog
            this.$store.dispatch("notifications/fetchNotifications")
        },
        clickMyProfile() {
            this.showUserDetail = false
            this.$refs.userDetailDialog.showUserDetailDialog()
        },
        getTimeAgo(timestamp) {
            const now = moment();
            const targetTime = moment(timestamp);
            const diffMinutes = now.diff(targetTime, 'minutes');
            const diffHours = now.diff(targetTime, 'hours');
            const diffDays = now.diff(targetTime, 'days');
            const diffWeeks = now.diff(targetTime, 'weeks');

            if (diffMinutes < 60) {
                return `${diffMinutes} minutes ago`;
            } else if (diffHours < 24) {
                return `${diffHours} hours ago`;
            } else if (diffDays < 7) {
                return `${diffDays} days ago`;
            } else {
                return `${diffWeeks} weeks ago`;
            }
        },
    },
    mounted() {
        this.$store.dispatch("notifications/fetchNotifications")
        window.Pusher = Pusher;

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '670e5acb7049ec790187',
            cluster: 'mt1',
            forceTLS: true
        });


        let user = JSON.parse(localStorage.getItem('token')).authUser;
        window.Echo.channel('task-assigned-' + user.id)
            .listen('TaskAssigned', (data) => {
                this.$store.commit('notifications/setNotiCount', data.noti_count);
            });

        window.Echo.channel('task-updated')
            .listen('TaskUpdated', (data) => {
                let noti_count = this.notiCount + 1;
                this.$store.commit('notifications/setNotiCount', noti_count);
            });

        document.body.addEventListener('click', (event) => {
            if (this.$refs.navbarNoti && !this.$refs.navbarNoti.contains(event.target)) {
                this.showNotiDialog = false
            }
            if (this.$refs.navbarUser && !this.$refs.navbarUser.contains(event.target)) {
                this.showUserDetail = false
            }
        })
    }
}
</script>

<style lang="scss">
@import '../assets/main.scss';


.navbar-container {
    background-color: $gray-color;
    height: 50px;
    display: flex;
    align-items: center;
    padding: 0px 30px;
    width: 100vw;

    .navbar-left {
        display: flex;
        align-items: center;
        flex: 1;
        gap: 30px;

        .navbar-logo {
            font-size: 25px;
            font-weight: bold;
            display: flex;
            align-items: center;

            span {
                font-size: 35px;
                color: $blue-color;
            }
        }

        .navbar-roles {
            display: flex;
            gap: 5px;
            font-size: 12px;
            border-radius: 3px;
            border: 1px solid #000;
            padding: 5px 10px;
            align-items: center;

            span {
                color: #000;
                text-transform: capitalize;
            }
        }
    }

    .navbar-right {
        flex: 1;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 30px;

        .navbar-noti {
            position: relative;
            cursor: pointer;

            .noti-count {
                position: absolute;
                background: red;
                width: 11px;
                height: 11px;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 10px;
                font-weight: bold;
                color: #fff;
                top: -10px;
                right: -10px;
                padding: 8px;
                border-radius: 50%;
            }

            .navbar-noti-no-data {
                z-index: 100;
                position: absolute;
                background-color: #fff;
                top: 39px;
                right: 0;
                width: 300px;
                height: 100px;
                border: 1px solid #eee;
                border-radius: 5px;
                -webkit-box-shadow: 0px 1px 15px 1px #C2C2C2;
                box-shadow: 0px 1px 15px 1px #C2C2C2;
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 2px;
                font-size: 13px;
            }

            .navbar-noti-dialog {
                z-index: 100;
                position: absolute;
                background-color: #fff;
                top: 39px;
                right: 0;
                width: 300px;
                max-height: 300px;
                overflow-y: scroll;
                border: 1px solid #eee;
                border-radius: 5px;
                -webkit-box-shadow: 0px 1px 15px 1px #C2C2C2;
                box-shadow: 0px 1px 15px 1px #C2C2C2;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                gap: 2px;

                .navbar-noti-item-container {
                    width: 100%;
                    display: flex;
                    align-items: center;
                    padding: 10px;
                    gap: 10px;

                    .navbar-noti-profile-img {
                        width: 40px;
                        height: 40px;
                        border-radius: 50%;
                    }

                    .navbar-noti-detail {
                        display: flex;
                        flex-direction: column;
                        height: max-content;

                        .navbar-noti-user-email {
                            font-size: 13px;
                            font-weight: 600;
                        }

                        .navbar-noti-content {

                            font-size: 13px;
                            overflow: hidden;
                            white-space: wrap;
                        }

                        .navbar-noti-date {
                            color: #464646;
                            font-size: 12px;
                        }
                    }

                    &:nth-child(even) {
                        background-color: #ececec;
                    }
                }

                &::-webkit-scrollbar {
                    width: 5px;
                }

                &::-webkit-scrollbar-track {
                    background: #f1f1f1;
                }

                &::-webkit-scrollbar-thumb {
                    background: #c9c9c9;
                }

                &::-webkit-scrollbar-thumb:hover {
                    background: #555;
                }
            }
        }

        .navbar-user {
            position: relative;

            img {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                cursor: pointer;
            }

            .navbar-user-detail {
                position: absolute;
                z-index: 100;
                width: 200px;
                height: 130px;
                background-color: #fff;
                top: 50px;
                border-radius: 5px;
                right: 0;
                border: 1px solid #eee;
                -webkit-box-shadow: 0px 1px 15px 1px #C2C2C2;
                box-shadow: 0px 1px 15px 1px #C2C2C2;
                padding: 10px;
                display: flex;
                flex-direction: column;
                gap: 20px;

                .navbar-user-logo {
                    display: flex;
                    align-items: center;
                    font-size: 15px;
                    font-weight: bold;
                    height: 30px;
                    padding: 5px 0;
                    border-bottom: 1px solid #000;

                    span {
                        color: #0000ff;
                        font-size: 25px;
                    }
                }

                .navbar-user-item {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    cursor: pointer;

                    img {
                        width: 15px;
                        height: 15px;
                    }

                    span {
                        font-size: 12px;
                    }
                }
            }
        }
    }
}


</style>