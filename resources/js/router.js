import Vue from 'vue'
import VueRouter from 'vue-router'

// Layout
import LayoutLogin from './views/layouts/LayoutLogin.vue'
import LayoutBasic from './views/layouts/LayoutBasic.vue'

// Auth
import Login from './views/auth/Login.vue'
import Register from './views/auth/Register.vue'
import ResetPassword from './views/auth/ResetPassword.vue'
import ForgotPassword from './views/auth/ForgotPassword.vue'

import NotFoundPage from './views/errors/404.vue'

// Dashbord
import Dashboard from './views/dashboard/Dashboard.vue'

// Students

// Users

// Tutor

// Subject

// Invoices

// Items

// Payments

// Expenses
import ExpensesIndex from './views/expenses/Index.vue'
import ExpenseCreate from './views/expenses/Create.vue'

// Report

// Settings

Vue.use(VueRouter)

const routes = [

    /*
    |--------------------------------------------------------------------------
    | Auth & Registration Routes
    |--------------------------------------------------------------------------|
    */
    {
        path: '/',
        component: LayoutLogin,
        // meta: { redirectIfAuthenticated: true },
        children: [
            {
                path: '/',
                component: Login,
                name: 'login'
            },
            {
                path: 'login',
                component: Login,
                name: 'login'
            },
            {
                path: '/forgot-password',
                component: ForgotPassword,
                name: 'forgot-password'
            },
            {
                path: '/reset-password/:token',
                component: ResetPassword,
                name: 'reset-password'
            },
            {
                path: 'register',
                component: Register,
                name: 'register'
            },
        ]
    },
    /*
    |--------------------------------------------------------------------------
    | Admin Backend Routes
    |--------------------------------------------------------------------------|
    */
    {
        path: '/admin',
        component: LayoutBasic, // Change the desired Layout here
        // meta: { requiresAuth: true },
        children: [
            // Dashbord
            {
                path: '/',
                component: Dashboard,
                name: 'dashboard'
            },
            {
                path: 'dashboard',
                component: Dashboard
            },
            // Expenses
            {
                path: 'expenses',
                component: ExpensesIndex
            },
            {
                path: 'expenses/create',
                name: 'expenses.create',
                component: ExpenseCreate
            },
            {
                path: 'expenses/:id/edit',
                name: 'expenses.edit',
                component: ExpenseCreate
            },
        ]
    },
    // Default Route
    { path: '*', component: NotFoundPage }
]

const router = new VueRouter({
    routes,
    mode: 'history',
    linkActiveClass: 'active'
})

// router.beforeEach((to, from, next) => {
//     // Redirect if not authenticateed on secured routes

// })

export default router