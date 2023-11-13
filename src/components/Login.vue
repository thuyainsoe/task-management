<template>
    <div class="login-wrapper">
        <LogoHeader />
        <form @submit.prevent="loginSubmit">
            <div class="login-item">
                <input type="text" placeholder="Email" v-model="email" required @focus="errMessage = null">
            </div>
            <div class="login-item">
                <input type="password" placeholder="Password" v-model="password" required @focus="errMessage = null">
            </div>
            <span v-if="errMessage" class="err-message">{{ errMessage }}</span>
            <div class="login-button">
                <button>Sign In</button>
            </div>
            <p class="register-or-not">
                Don't have an account yet ? <span> Sign Up</span>
            </p>
        </form>
    </div>
</template>

<script>
import LogoHeader from './LogoHeader.vue';
import axios from 'axios';

export default {
    components: { LogoHeader },
    data() {
        return {
            email: '',
            password: '',
            errMessage: null
        }
    },
    methods: {
        async loginSubmit() {
            try {
                const response = await axios.post(`http://localhost:8000/api/login`, {
                    email: this.email,
                    password: this.password
                });
                const expirationTime = new Date().getTime() + 60 * 60 * 1000;
                const tokenItem = {
                    value: response.data.token,
                    expiration: expirationTime,
                };
                localStorage.setItem('token', JSON.stringify(tokenItem));

                this.$router.push('/').catch(err => { console.log(err) });

            } catch (error) {
                this.errMessage = error.response.data.message
                console.error('Error:', error);
            }
        }

    }
}
</script>

<style lang="scss">
.login-wrapper {
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

        .login-item {
            width: 100%;

            input {
                width: 100%;
                height: 40px;
                outline: none;
                border: none;
                border-bottom: 1px solid #000;
            }
        }

        .login-button {
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

        .err-message {
            color: red;
            align-self: flex-start;
            font-size: 12px;
            padding: none;
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