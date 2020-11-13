
import * as types from './mutation-types'

export const loadData = ({ commit, dispatch, state }, params) => {
  return new Promise((resolve, reject) => {
    window.axios.get(`/api/v1/dashboard`, { params }).then((response) => {
      commit(types.SET_INITIAL_DATA, response.data)
      commit(types.GET_INITIAL_DATA, true)
      resolve(response)
    }).catch((err) => {
      reject(err)
    })
  })
}
