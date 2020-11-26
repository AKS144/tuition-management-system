import * as types from './mutation-types'

export default {
  [types.BOOTSTRAP_LEVELS] (state, levels) {
    state.levels = levels
  },

  [types.ADD_LEVEL] (state, data) {
    state.levels.push(data.level)
  },

  [types.UPDATE_LEVEL] (state, data) {
    let pos = state.levels.findIndex(level => level.id === data.level.id)
    Object.assign(state.levels[pos], {...data.level})
  },

  [types.DELETE_LEVEL] (state, id) {
    let pos = state.levels.findIndex(level => level.id === id)
    state.levels.splice(pos, 1)
  }
}
