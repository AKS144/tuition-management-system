export const levels = (state) => state.levels

export const getLeveltById = (state) => (id) => {
  return state.levels.find(level => level.id === id)
}
