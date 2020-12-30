<template>
    <div class="navbar">
        <div style="float: left">
            Welcome
            <span class="username">{{user.username}}</span>

            <div class="profile">
                <img @click="handleFile" alt="myavatar"  :src="this.user.avatarUrl">
                <input style="display: none" @change="submitFile" id="avatar" name="avatar" ref="file" type="file">
            </div>

        </div>
        <a @click="logout">Logout</a>
        <!--        <div class="file-upload">-->
        <!--            <input @change="handleFile" id="avatar" name="avatar" ref="file" type="file">-->
        <!--            <button @click="submitFile">Submit</button>-->
        <!--        </div>-->
    </div>
</template>

<script>
    import authService from "../service/auth.service";
    import httpClient from "../service/http.service";

    export default {
        name: "Navbar",
        props: {
            user: {},
        },
        data() {
            return {
                file: '',
                loader: false
            }
        },
        methods: {
            logout() {
                authService.logout()
            },

            submitFile() {
                this.loader = true
                this.file = this.$refs.file.files[0]
                /*
                        Initialize the form data
                    */
                let formData = new FormData();

                /*
                    Add the form data we need to submit
                */
                formData.append('file', this.file);
                formData.append('access_token', authService.getToken());

                /*
                  Make the request to the POST /single-file URL
                */
                httpClient.post('/user/upload-avatar', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((response) => {
                    this.user.avatarUrl = response.data.avatarUrl
                    console.log(response.data.message)
                }).catch(function () {
                    console.log('FAILURE!!');
                });
            },

            handleFile() {
                this.$refs.file.click()
            }
        },


    }
</script>

<style lang="scss" scoped>
    .navbar {

        .username {
            text-transform: uppercase;
        }

        height: 50px;
        position: fixed;
        left: 0;
        top: 0;
        right: 0;
        line-height: 50px;
        background-color: #1f5d6b;
        color: #FFF;
        padding: 0 15px;
        text-align: right;
        transition: font-weight 0.3s;
        box-shadow: 6px 3px 6px #0f304d;

        a {
            color: #FFF;
            padding-left: 10px;
            cursor: pointer;
            text-decoration: underline;
        }

        .profile {
            display: contents;

            img {
                width: 45px;
                vertical-align: middle;
                margin-left: 10px;
                border-radius: 50%;
                cursor: pointer;
            }
        }

    }
</style>