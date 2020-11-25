import * as types from './mutation-types'
import Ls from '../../../services/ls'

export default {
  [types.BOOTSTRAP_BRANCHES] (state, branches) {
    state.branches = branches
    state.selectedBranch = branches[0]
  },
  [types.SET_SELECTED_BRANCH] (state, branch) {
    Ls.set('selectedBranch', branch.id)
    state.selectedBranch = branch
  }
}
