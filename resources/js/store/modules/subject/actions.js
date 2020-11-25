import * as types from './mutation-types'

export const addSubject = ({ commit, dispatch, state }, data) => {
  return new Promise((resolve, reject) => {
    window.axios.post('/api/v1/subjects', data).then((response) => {
      commit(types.ADD_SUBJECT, response.data)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const fetchSubject = ({ commit, dispatch, state }, id) => {
  return new Promise((resolve, reject) => {
    window.axios.get(`/api/v1/subjects/${id}/edit`).then((response) => {
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const updateSubject = ({ commit, dispatch, state }, data) => {
  return new Promise((resolve, reject) => {
    window.axios.put(`/api/v1/subjects/${data.id}`, data).then((response) => {
      commit(types.UPDATE_SUBJECT, response.data)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const deleteSubject = ({ commit, dispatch, state }, id) => {
  return new Promise((resolve, reject) => {
    window.axios.delete(`/api/v1/subjects/${id}`).then((response) => {
      if (response.data.success) {
        commit(types.DELETE_SUBJECT, id)
      }
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}
