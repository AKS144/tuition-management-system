import * as types from './mutation-types'

export default {
  [types.BOOTSTRAP_CLASSES] (state, classes) {
    state.classes = classes
  },

  [types.SET_TOTAL_CLASSES] (state, totalClasses) {
    state.totalClasses = totalClasses
  },

  [types.ADD_CLASS] (state, data) {
    state.classes.push(data.class)
  },

  [types.UPDATE_CLASS] (state, data) {
    let pos = state.classes.findIndex(item => item.id === data.class.id)

    state.classes[pos] = data.class
  },

  [types.DELETE_CLASS] (state, id) {
    let index = state.classes.findIndex(item => item.id === id)
    state.classes.splice(index, 1)
  },

  [types.DELETE_MULTIPLE_CLASSES] (state, selectedClasses) {
    selectedClasses.forEach((classes) => {
      let index = state.classes.findIndex(_item => _item.id === classes.id)
      state.classes.splice(index, 1)
    })

    state.selectedClasses = []
  },

  [types.SET_SELECTED_CLASSES] (state, data) {
    state.selectedClasses = data
  },

  [types.SET_SELECT_ALL_STATE] (state, data) {
    state.selectAllField = data
  },

  [types.ADD_CLASS_TUTOR] (state, data) {
    state.classTutors = [data.tutor, ...state.classTutors]
  },

  [types.SET_CLASS_TUTORS] (state, data) {
    state.classTutors = data
  },

  [types.DELETE_CLASS_TUTOR] (state, id) {
    let index = state.classTutors.findIndex(tutor => tutor.id === id)
    state.classTutors.splice(index, 1)
  },

  [types.UPDATE_CLASS_TUTOR] (state, data) {
    let pos = state.classTutors.findIndex(tutor => tutor.id === data.tutor.id)
    state.classTutors.splice(pos, 1)
    state.classTutors = [data.tutor, ...state.classTutors]
  }
}
