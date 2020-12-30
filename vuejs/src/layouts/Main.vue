<template>
    <div id="main-layout">
        <navbar :user="user"/>
        <router-view />
    </div>
</template>

<script>
    import Navbar from "./Navbar";
    import authService from "../service/auth.service";
    export default {
        name: "Main",
        components: {Navbar},
        data() {
            return {
                user: Object
            }
        },
        async mounted() {
            this.user = await authService.getUser()
        }
    }
</script>

<style lang="scss" scoped>
    #main-layout {
        padding-top: 50px;
    }
</style>