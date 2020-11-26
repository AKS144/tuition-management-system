export const parents = (state) => state.parents

export const getParentById = (state) => (id) => {
  return state.parents.find(parent => parent.id === id)
}
