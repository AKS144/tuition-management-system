import * as types from './mutation-types'

export const fetchPackages = ({ commit, dispatch, state }, data) => {
  return new Promise((resolve, reject) => {
    window.axios.get(`/api/v1/packages`).then((response) => {
      console.log(response);
      commit(types.SET_PACKAGES, response.data)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const fetchPackage = ({ commit, dispatch, state }, id) => {
  return new Promise((resolve, reject) => {
    window.axios.get(`/api/v1/packages/${id}/edit`).then((response) => {
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const addPackage = ({ commit, dispatch, state }, data) => {
  return new Promise((resolve, reject) => {
    window.axios.post('/api/v1/packages', data).then((response) => {
      commit(types.ADD_PACKAGE, response.data)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const updatePackage = ({ commit, dispatch, state }, data) => {
  return new Promise((resolve, reject) => {
    window.axios.put(`/api/v1/packages/${data.id}`, data).then((response) => {
      commit(types.UPDATE_PACKAGE, response.data)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}

export const deletePackage = ({ commit, dispatch, state }, id) => {
  return new Promise((resolve, reject) => {
    window.axios.delete(`/api/v1/packages/${id}`).then((response) => {
      if (response.data.success) {
        commit(types.DELETE_PACKAGE, id)
      }
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}
