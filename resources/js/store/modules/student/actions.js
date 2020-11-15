import * as types from './mutation-types'

export const fetchStudents = ({ commit, dispatch, state }, params) => {
  return new Promise((resolve, reject) => {
    window.axios.get(`/api/v1/students`, {params}).then((response) => {
      console.log(response);
      commit(types.BOOTSTRAP_STUDENTS, response.data.students.data)
      commit(types.SET_TOTAL_STUDENTS, response.data.students.total)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const fetchStudent = ({ commit, dispatch }, id) => {
  return new Promise((resolve, reject) => {
    window.axios.get(`/api/v1/students/${id}/edit`).then((response) => {
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const addStudent = ({ commit, dispatch, state }, data) => {
  return new Promise((resolve, reject) => {
    window.axios.post('/api/v1/students', data).then((response) => {
      commit(types.ADD_STUDENT, response.data)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const updateStudent = ({ commit, dispatch, state }, data) => {
  return new Promise((resolve, reject) => {
    window.axios.put(`/api/v1/students/${data.id}`, data).then((response) => {
      if(response.data.success){
        commit(types.UPDATE_STUDENT, response.data)
      }
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const deleteStudent = ({ commit, dispatch, state }, id) => {
  return new Promise((resolve, reject) => {
    window.axios.delete(`/api/v1/students/${id}`).then((response) => {
      commit(types.DELETE_STUDENT, id)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const deleteMultipleStudents = ({ commit, dispatch, state }, id) => {
  return new Promise((resolve, reject) => {
    window.axios.post(`/api/v1/students/delete`, {'id': state.selectedStudents}).then((response) => {
      commit(types.DELETE_MULTIPLE_STUDENTS, state.selectedStudents)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const setSelectAllState = ({ commit, dispatch, state }, data) => {
  commit(types.SET_SELECT_ALL_STATE, data)
}

export const selectAllStudents = ({ commit, dispatch, state }) => {
  if (state.selectedStudents.length === state.students.length) {
    commit(types.SET_SELECTED_STUDENTS, [])
    commit(types.SET_SELECT_ALL_STATE, false)
  } else {
    let allStudentIds = state.students.map(cust => cust.id)
    commit(types.SET_SELECTED_STUDENTS, allStudentIds)
    commit(types.SET_SELECT_ALL_STATE, true)
  }
}

export const selectStudent = ({ commit, dispatch, state }, data) => {
  commit(types.SET_SELECTED_STUDENTS, data)
  if (state.selectedStudents.length === state.students.length) {
    commit(types.SET_SELECT_ALL_STATE, true)
  } else {
    commit(types.SET_SELECT_ALL_STATE, false)
  }
}

export const resetSelectedStudent = ({ commit, dispatch, state }, data) => {
  commit(types.RESET_SELECTED_STUDENT)
}
