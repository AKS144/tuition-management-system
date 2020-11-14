import * as types from './mutation-types'

export default {
  [types.BOOTSTRAP_STUDENTS] (state, students) {
    state.students = students
  },

  [types.SET_TOTAL_STUDENTS] (state, totalStudents) {
    state.totalStudents = totalStudents
  },

  [types.ADD_STUDENT] (state, data) {
    state.students.push(data.student)
  },

  [types.UPDATE_STUDENT] (state, data) {
    let pos = state.students.findIndex(student => student.id === data.student.id)

    state.students[pos] = data.student
  },

  [types.DELETE_STUDENT] (state, id) {
    let index = state.students.findIndex(student => student.id === id)
    state.students.splice(index, 1)
  },

  [types.DELETE_MULTIPLE_STUDENTS] (state, selectedStudents) {
    selectedStudents.forEach((student) => {
      let index = state.students.findIndex(_cust => _cust.id === student.id)
      state.students.splice(index, 1)
    })

    state.selectedStudents = []
  },

  [types.SET_SELECTED_STUDENTS] (state, data) {
    state.selectedStudents = data
  },

  [types.RESET_SELECTED_STUDENT] (state, data) {
    state.selectedStudents = null
  },

  [types.SET_SELECT_ALL_STATE] (state, data) {
    state.selectAllField = data
  }

}
