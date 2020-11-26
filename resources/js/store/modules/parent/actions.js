import * as types from './mutation-types'

export const addParent = ({ commit, dispatch, state }, data) => {
  return new Promise((resolve, reject) => {
    window.axios.post('/api/v1/parents', data).then((response) => {
      commit(types.ADD_PARENT, response.data)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const fetchParents = ({ commit, dispatch, state }) => {
  return new Promise((resolve, reject) => {
    window.axios.get(`/api/v1/parents`).then((response) => {
      console.log(response)
      commit(types.BOOTSTRAP_PARENTS, response.data.parents)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const fetchParent = ({ commit, dispatch, state }, id) => {
  return new Promise((resolve, reject) => {
    window.axios.get(`/api/v1/parents/${id}/edit`).then((response) => {
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const updateParent = ({ commit, dispatch, state }, data) => {
  return new Promise((resolve, reject) => {
    window.axios.put(`/api/v1/parents/${data.id}`, data).then((response) => {
      commit(types.UPDATE_PARENT, response.data)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const deleteParent = ({ commit, dispatch, state }, id) => {
  return new Promise((resolve, reject) => {
    window.axios.delete(`/api/v1/parents/${id}`).then((response) => {
      if (response.data.success) {
        commit(types.DELETE_PARENT, id)
      }
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}
