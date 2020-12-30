import axios from "axios";
import router from "../router";
import httpClient from "./http.service";

const authService = {

    user: null,
    async login(formData) {
        try {
            const {status, data} = await httpClient.post('user/login', formData)
            console.log(status, data)
            if (status === 200) {
                this.setUser(data)
                return {success: true}
            }
        } catch (e) {
            return {
                success: false,
                errors: e.response.data.errors
            }
        }
    },
    async register(formData) {
        try {
            const {status, data} = await httpClient.post('user/register', formData)
            console.log(status, data)
            if (status === 200) {
                this.setUser(data)
                return {success: true}
            }
        } catch (e) {
            return {
                success: false,
                errors: e.response.data.errors
            }
        }
    },

    logout: () => {
        localStorage.removeItem('ACCESS_TOKEN')
        router.push({name: 'login'})
    },


    setUser(user) {
        this.user = user
        localStorage.setItem('ACCESS_TOKEN', this.user.access_token)
    },

    isGuest: () => !localStorage.getItem('ACCESS_TOKEN'),

    getToken: () => localStorage.getItem('ACCESS_TOKEN'),


    async getUser() {
        try {
            if (!this.user) {
                const {status, data} = await httpClient.get('/user/data');
                if (status === 200) {
                    this.user = data;
                }
            }

        } catch (e) {
            console.log(e.response)
            return null;
        }

        return this.user;
    }

}


export default authService