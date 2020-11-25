import * as types from './mutation-types'

export default {
  [types.SET_COMPANY] (state, data) {
    state.company = data.user
  },

  [types.UPDATE_COMPANY] (state, data) {
    state.company = data
  }
}
