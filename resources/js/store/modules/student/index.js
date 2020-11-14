import mutations from './mutations'
import * as actions from './actions'
import * as getters from './getters'

const initialState = {
  students: [],
  totalStudents: 0,
  selectAllField: false,
  selectedStudents: []
}

export default {
  namespaced: true,

  state: initialState,

  getters: getters,

  actions: actions,

  mutations: mutations
}
