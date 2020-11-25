import * as types from './mutation-types'

export const fetchClasses = ({ commit, dispatch, state }, params) => {
  return new Promise((resolve, reject) => {
    window.axios.get(`/api/v1/class`, {params}).then((response) => {
      console.log(response);
      commit(types.BOOTSTRAP_CLASSES, response.data.classroom.data)
      commit(types.SET_TOTAL_CLASSES, response.data.classroom.total)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const fetchClass = ({ commit, dispatch }, id) => {
  return new Promise((resolve, reject) => {
    window.axios.get(`/api/v1/class/${id}/edit`).then((response) => {
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const addClass = ({ commit, dispatch, state }, data) => {
  return new Promise((resolve, reject) => {
    window.axios.post('/api/v1/class', data).then((response) => {
      commit(types.ADD_CLASS, response.data)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const updateClass = ({ commit, dispatch, state }, data) => {
  return new Promise((resolve, reject) => {
    window.axios.put(`/api/v1/class/${data.id}`, data).then((response) => {
      commit(types.UPDATE_CLASS, response.data)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const deleteClass = ({ commit, dispatch, state }, id) => {
  return new Promise((resolve, reject) => {
    window.axios.delete(`/api/v1/class/${id}`).then((response) => {
      commit(types.DELETE_CLASS, response.data)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const deleteMultipleClasses = ({ commit, dispatch, state }, id) => {
  return new Promise((resolve, reject) => {
    window.axios.post(`/api/v1/class/delete`, {'id': state.selectedClasses}).then((response) => {
      commit(types.DELETE_MULTIPLE_CLASSES, state.selectedClasses)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const setSelectAllState = ({ commit, dispatch, state }, data) => {
  commit(types.SET_SELECT_ALL_STATE, data)
}

export const selectAllClasses = ({ commit, dispatch, state }) => {
  if (state.selectedClasses.length === state.classes.length) {
    commit(types.SET_SELECTED_CLASSES, [])
    commit(types.SET_SELECT_ALL_STATE, false)
  } else {
    let allItemIds = state.classes.map(item => item.id)
    commit(types.SET_SELECTED_CLASSES, allItemIds)
    commit(types.SET_SELECT_ALL_STATE, true)
  }
}

export const selectClass = ({ commit, dispatch, state }, data) => {
  commit(types.SET_SELECTED_CLASSES, data)
  if (state.selectedClasses.length === state.classes.length) {
    commit(types.SET_SELECT_ALL_STATE, true)
  } else {
    commit(types.SET_SELECT_ALL_STATE, false)
  }
}

export const addClassTutor = ({ commit, dispatch, state }, data) => {
  return new Promise((resolve, reject) => {
    window.axios.post(`/api/v1/tutors`, data).then((response) => {
      commit(types.ADD_CLASS_TUTOR, response.data)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const updateClassTutor = ({ commit, dispatch, state }, data) => {
  return new Promise((resolve, reject) => {
    window.axios.put(`/api/v1/tutors/${data.id}`, data).then((response) => {
      commit(types.UPDATE_CLASS_TUTOR, response.data)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const fetchClassTutors = ({ commit, dispatch, state }) => {
  return new Promise((resolve, reject) => {
    window.axios.get(`/api/v1/tutors`).then((response) => {
      console.log(response)
      commit(types.SET_CLASS_TUTORS, response.data.tutors)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const fatchClassTutor = ({ commit, dispatch, state }, id) => {
  return new Promise((resolve, reject) => {
    window.axios.get(`/api/v1/tutors/${id}`).then((response) => {
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const deleteClasstutor = ({ commit, dispatch, state }, id) => {
  return new Promise((resolve, reject) => {
    window.axios.delete(`/api/v1/tutors/${id}`).then((response) => {
      if (!response.data.error) {
        commit(types.DELETE_CLASS_TUTOR, id)
      }
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}
