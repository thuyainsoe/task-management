<template>
    <section>
        <Navbar />
        <div class="home-section">
            <SideBar />
            <MainSection />
        </div>
    </section>
</template>

<script>
import Navbar from '../components/Navbar.vue';
import MainSection from '../components/MainSection.vue';
import SideBar from '../components/SideBar.vue';
export default {
    components: {
        Navbar,
        MainSection,
        SideBar
    }
}
</script>

<style lang="scss">
.home-section {
    display: flex;
}
</style>