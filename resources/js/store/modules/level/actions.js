import * as types from './mutation-types'

export const addLevel = ({ commit, dispatch, state }, data) => {
  return new Promise((resolve, reject) => {
    window.axios.post('/api/v1/levels', data).then((response) => {
      commit(types.ADD_LEVEL, response.data)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const fetchLevel = ({ commit, dispatch, state }, id) => {
  return new Promise((resolve, reject) => {
    window.axios.get(`/api/v1/levels/${id}/edit`).then((response) => {
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const updateLevel = ({ commit, dispatch, state }, data) => {
  return new Promise((resolve, reject) => {
    window.axios.put(`/api/v1/levels/${data.id}`, data).then((response) => {
      commit(types.UPDATE_LEVEL, response.data)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const deleteLevel = ({ commit, dispatch, state }, id) => {
  return new Promise((resolve, reject) => {
    window.axios.delete(`/api/v1/levels/${id}`).then((response) => {
      if (response.data.success) {
        commit(types.DELETE_LEVEL, id)
      }
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}
