import * as types from './mutation-types'

export default {
  [types.RESET_CURRENT_USER] (state, user) {
    state.currentUser = null
  },
  [types.BOOTSTRAP_CURRENT_USER] (state, user) {
    state.currentUser = user
  },
  [types.UPDATE_CURRENT_USER] (state, user) {
    state.currentUser = user
  },
  [types.SET_STUDENT_STATUS] (state, user) {
    state.status = user
  }
}
