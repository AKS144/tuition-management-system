import * as types from './mutation-types'

export const setSelectedBranch = ({ commit, dispatch, state }, data) => {
  commit(types.SET_SELECTED_BRANCH, data)
}
