import * as types from './mutation-types'
import * as currencyTypes from './modules/currency/mutation-types'
import * as userTypes from './modules/user/mutation-types'
import * as branchTypes from './modules/branch/mutation-types'
import * as preferencesTypes from './modules/settings/preferences/mutation-types'
import * as taxTypeTypes from './modules/tax-type/mutation-types'
import * as itemTypes from './modules/item/mutation-types'
import * as paymentModes from './modules/payment/mutation-types'

export default {
    bootstrap ({ commit, dispatch, state }) {
        return new Promise((resolve, reject) => {
          window.axios.get('/api/v1/bootstrap').then((response) => {
            console.log(response);
            commit('branch/' + branchTypes.BOOTSTRAP_BRANCHES, response.data.branches)
            commit('branch/' + branchTypes.SET_SELECTED_BRANCH, response.data.branch)
            commit('currency/' + currencyTypes.BOOTSTRAP_CURRENCIES, response.data)
            commit('currency/' + currencyTypes.SET_DEFAULT_CURRENCY, response.data)
            commit('user/' + userTypes.BOOTSTRAP_CURRENT_USER, response.data.user)
            commit('taxType/' + taxTypeTypes.BOOTSTRAP_TAX_TYPES, response.data.taxTypes)
            commit('preferences/' + preferencesTypes.SET_MOMENT_DATE_FORMAT, response.data.moment_date_format)
            commit('preferences/' + preferencesTypes.SET_LANGUAGE_FORMAT, response.data.default_language)
            commit('item/' + itemTypes.SET_ITEM_UNITS, response.data.units)
            commit('payment/' + paymentModes.SET_PAYMENT_MODES, response.data.paymentMethods)
            commit('user/' + userTypes.SET_STUDENT_STATUS, response.data.status)
            commit(types.UPDATE_APP_LOADING_STATUS, true)
            resolve(response)
          }).catch((err) => {
            reject(err)
          })
        })
      }
}