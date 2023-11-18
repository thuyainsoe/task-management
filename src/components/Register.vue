<template>
    <div class="register-wrapper">
        <LogoHeader />
        <form @submit.prevent="registerSubmit">
            <div class="register-item">
                <input type="text" placeholder="Username" required v-model="username" @focus="errMessage = null">
            </div>
            <div class="register-item">
                <input type="text" placeholder="Email" required v-model="email" @focus="errMessage = null">
            </div>
            <div class="register-item">
                <input type="password" placeholder="Password" required v-model="password" @focus="errMessage = null">
            </div>
            <div class="register-item">
                <input type="password" placeholder="Reenter-Password" required v-model="re_password"
                    @focus="errMessage = null">
            </div>
            <span v-if="errMessage" class="err-message">{{ errMessage }}</span>
            <div class="register-button">
                <button>Sign Up</button>
            </div>
            <p class="register-or-not">
                Already have an account ? <span><router-link to="/login">Sign In</router-link></span>
            </p>
        </form>
    </div>
</template>

<script>
import LogoHeader from './LogoHeader.vue';
import axios from 'axios';
import { ElNotification } from 'element-plus'

export default {
    components: { LogoHeader },
    data() {
        return {
            username: '',
            email: '',
            password: '',
            re_password: '',
            errMessage: null
        }
    },
    methods: {
        async registerSubmit() {
            let upperCaseName = this.username.toUpperCase();
            let avator = upperCaseName.replace(/\b(mg)\b/g, match =>
                match.replace(/(^|\s)([a-z])/g, subMatch => subMatch.toUpperCase())
            ).replace(/\s/g, "+");

            if (this.password !== this.re_password) {
                this.errMessage = 'Something went wrong!'
            } else {
                try {
                    const response = await axios.post(`http://localhost:8000/api/register`, {
                        name: this.username,
                        email: this.email,
                        password: this.password,
                        username: `https://ui-avatars.com/api/?name=${avator}`,
                        role: 'guest',
                        department_id: 1,
                        position: ''
                    });
                    ElNotification({
                        title: 'Success',
                        message: 'Registration Completed.',
                        type: 'success',
                        duration: 2000
                    })
                    this.$router.push('/login').catch(err => { console.log(err) });

                } catch (error) {
                    this.errMessage = error.response.data.message
                    console.error('Error:', error);
                }
            }
        }
    }
}
</script>

<style lang="scss">
.register-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    width: 100vw;
    position: relative;
    overflow: hidden;



    form {
        width: 400px;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 20px;

        .register-item {
            width: 100%;

            input {
                width: 100%;
                height: 40px;
                outline: none;
                border: none;
                border-bottom: 1px solid #000;
            }
        }

        .err-message {
            color: red;
            align-self: flex-start;
            font-size: 12px;
            padding: none;
        }

        .register-button {
            width: 100%;

            button {
                width: 100%;
                height: 40px;
                background-color: #0000ff;
                color: #fff;
                font-size: 14px;
                border: none;
            }
        }

        .register-or-not {
            width: 100%;
            text-align: center;

            span {
                color: #0000ff83;
                font-weight: bold;
                cursor: pointer;
            }
        }
    }
}
</style>