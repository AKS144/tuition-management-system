import * as types from './mutation-types'

export default {
  [types.BOOTSTRAP_PARENTS] (state, parents) {
    state.parents = parents
  },

  [types.ADD_PARENT] (state, data) {
    state.parents.push(data.parent)
  },

  [types.UPDATE_PARENT] (state, data) {
    let pos = state.parents.findIndex(parent => parent.id === data.parent.id)
    Object.assign(state.parents[pos], {...data.parent})
  },

  [types.DELETE_PARENT] (state, id) {
    let pos = state.parents.findIndex(parent => parent.id === id)
    state.parents.splice(pos, 1)
  }
}
