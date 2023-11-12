<template>
    <div class="register-wrapper">
        <LogoHeader />
        <form>
            <div class="register-item">
                <input type="text" placeholder="Username" required>
            </div>
            <div class="register-item">
                <input type="text" placeholder="Email" required>
            </div>
            <div class="register-item">
                <input type="password" placeholder="Password" required>
            </div>
             <div class="register-item">
                <input type="password" placeholder="Reenter-Password" required>
            </div>
            <div class="register-button">
                <button>Sign Up</button>
            </div>
            <p class="register-or-not">
               Already have an account ? <span> Sign In</span>
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