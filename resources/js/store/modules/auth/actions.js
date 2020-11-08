import Ls from '../../../services/ls'
import * as types from './mutation-types'
import * as userTypes from '../user/mutation-types'
import * as rootTypes from '../../mutation-types'
import router from '../../../router.js'

export const login = ({ commit, dispatch, state }, data) => {
    let loginData = {
        email: data.email,
        password: data.password
    }
    return new Promise((resolve, reject) => {
        axios.post('/api/v1/login', loginData).then((response) => {
            let token = response.data.access_token
            Ls.set('auth.token', token)
    
            commit('user/' + userTypes.RESET_CURRENT_USER, null, { root: true })
            commit(rootTypes.UPDATE_APP_LOADING_STATUS, false, { root: true })
    
            commit(types.AUTH_SUCCESS, token)
            window.toastr['success']('Login Successful')
            resolve(response)
        }).catch(err => {
            commit(types.AUTH_ERROR, err.response)
            Ls.remove('auth.token')
            reject(err)
        })
    })
}

export const logout = ({ commit, dispatch, state }, noRequest = false) => {
    if (noRequest) {
        commit(types.AUTH_LOGOUT)
        Ls.remove('auth.token')
        router.push('/login')
  
        return true
    }
  
    return new Promise((resolve, reject) => {
        axios.get('/api/v1/logout').then((response) => {
            commit(types.AUTH_LOGOUT)
            Ls.remove('auth.token')
            router.push('/login')
            window.toastr['success']('Logged out!', 'Success')
        }).catch(err => {
            reject(err)
            commit(types.AUTH_LOGOUT)
            Ls.remove('auth.token')
            router.push('/login')
        })
    })
}