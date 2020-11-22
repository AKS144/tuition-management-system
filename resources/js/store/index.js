import Vue from 'vue'
import Vuex from 'vuex'

import * as getters from './getters'
import mutations from './mutations'
import actions from './actions'

import auth from './modules/auth'
import dashboard from './modules/dashboard'
import expense from './modules/expense'
import payment from './modules/payment'
import branch from './modules/branch'
import category from './modules/category'
import currency from './modules/currency'
import modal from './modules/modal'
import taxType from './modules/tax-type'
import student from './modules/student'
import user from './modules/user'
import companyInfo from './modules/settings/company-info'
import userProfile from './modules/settings/user-profile'
import preferences from './modules/settings/preferences'
import general from './modules/settings/general'
import item from './modules/item'
import classroom from './modules/class'

Vue.use(Vuex)

const initialState = {
    isAppLoaded: false
}

export default new Vuex.Store({
    strict: true,
    state: initialState,
    getters,
    mutations,
    actions,

    modules: {  
        auth,
        expense,
        dashboard,
        payment,
        branch,
        category,
        currency,
        modal,
        taxType,
        student,
        user,
        companyInfo,
        userProfile,
        preferences,
        general,
        item,
        classroom
    }
})