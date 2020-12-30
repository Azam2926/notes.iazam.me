<template>
    <div class="form-wrapper">
        <h3>Login to create notes</h3>
        <form @submit.prevent="login" action="">
            <span v-if="loading" class="loader"><loader /></span>
            <div v-else-if="errors" class="errors">
                <p v-for="(error, field) in errors" :key="field">
                    {{error[0]}}
                </p>
            </div>
            <input type="text" v-model="form.username" placeholder="Your username"><br>
            <input type="password" v-model="form.password" placeholder="Your password"><br>
            <button :disabled="loading" class="btn-login">
                <span v-if="loading">Loading ...</span>
                <span v-else>Login</span>
            </button>
            <router-link to="/register" class="link">Click here to register</router-link>
        </form>
    </div>
</template>

<script>
    import authService from "../service/auth.service";
    import {Jumper as Loader} from 'vue-loading-spinner'

    export default {
        name: "Login",
        components: {
            Loader
        },
        data() {
            return {
                form: {
                    username: '',
                    password: ''
                },
                errors: null,
                loading: false
            }
        },
        methods: {
            async login() {
                this.setLoading(true)

                const {success, errors} = await authService.login(this.form)
                if (success)
                    this.$router.push({name: 'home'})
                else
                    this.errors = errors

                this.setLoading(false)
            },

            setLoading(bool) {
                this.loading = bool
            }
        }
    }
</script>