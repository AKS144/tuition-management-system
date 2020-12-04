import * as types from './mutation-types'

export default {
  [types.SET_PACKAGES] (state, data) {
    state.packages = data.packages
  },

  [types.ADD_PACKAGE] (state, data) {
    state.packages.push(data.package)
  },

  [types.UPDATE_PACKAGE] (state, data) {
    console.log('update-package', data);
    let pos = state.packages.findIndex(packages => packages.id === data.packages.id)
    Object.assign(state.packages[pos], {...data.packages})
  },

  [types.DELETE_PACKAGE] (state, id) {
    let pos = state.packages.findIndex(packages => packages.id === id)
    state.packages.splice(pos, 1)
  }
}
