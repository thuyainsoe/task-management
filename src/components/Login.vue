<template>
    <div class="login-wrapper">
        <LogoHeader />
        <form>
            <div class="login-item">
                <input type="text" placeholder="Email" required>
            </div>
            <div class="login-item">
                <input type="password" placeholder="Password" required>
            </div>
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

export default {
    components: { LogoHeader }
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