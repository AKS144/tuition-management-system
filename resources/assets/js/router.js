import Vue from 'vue'
import VueRouter from 'vue-router'

// Layout

// Auth

// Dashboard

// Students

// Users

// Tutor

// Subject

// Invoices

// Items

// Payments

// Estimates

// Expenses

// Report

// Settings

Vue.use(VueRouter)

const routes = [

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