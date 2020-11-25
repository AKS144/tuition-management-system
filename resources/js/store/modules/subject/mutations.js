import * as types from './mutation-types'

export default {
  [types.BOOTSTRAP_SUBJECTS] (state, subjects) {
    state.subjects = subjects
  },

  [types.ADD_SUBJECT] (state, data) {
    state.subjects.push(data.subject)
  },

  [types.UPDATE_SUBJECT] (state, data) {
    let pos = state.subjects.findIndex(subject => subject.id === data.subject.id)
    Object.assign(state.subjects[pos], {...data.subject})
  },

  [types.DELETE_SUBJECT] (state, id) {
    let pos = state.subjects.findIndex(subject => subject.id === id)
    state.subjects.splice(pos, 1)
  }
}
