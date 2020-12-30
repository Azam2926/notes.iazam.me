import Vue from 'vue'
import VueRouter from 'vue-router'
import Main from "../layouts/Main";
import Auth from "../layouts/Auth";
import Home from "../views/Home";
import Login from "../views/Login";
import Registration from "../views/Registration";
import authService from "../service/auth.service";

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'main',
        redirect: '/home',
        component: Main,
        children: [
            {
                path: 'home',
                name: 'home',
                component: Home
            }
        ]
    },
    {
        path: '/auth',
        name: 'Auth',
        component: Auth,
        children: [
            {
                path: 'login',
                name: 'login',
                component: Login
            },
            {
                path: 'register',
                name: 'register',
                component: Registration
            }
        ]
    },
    {
        path: '/login',
        redirect: '/auth/login'
    },
    {
        path: '/register',
        redirect: '/auth/register'
    },
    {
        path: '/main',
        redirect: '/'
    }
]


const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

router.beforeEach((to, from, next) => {
    if (to.name === 'home' && authService.isGuest()) {
        next({name: 'login'})
    } else if (!authService.isGuest() && to.name !== 'home'){
        next({name: 'home'})
    } else {
        next();
    }
})

router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {

        if (localStorage.getItem('jwt') == null) {
            next({
                path: '/login',
                params: { nextUrl: to.fullPath }
            })
        } else {
            let user = JSON.parse(localStorage.getItem('user'))
            if(to.matched.some(record => record.meta.is_admin)) {
                if(user.is_admin == 1){
                    next()
                }
                else{
                    next({ name: 'userboard'})
                }
            }else {
                next()
            }
        }


    } else if(to.matched.some(record => record.meta.guest)) {

        if(localStorage.getItem('jwt') == null){
            next()
        }
        else{
            next({ name: 'userboard'})
        }
        
    }else {
        next()
    }
})

export default router

export default router
