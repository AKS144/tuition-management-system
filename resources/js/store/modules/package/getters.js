export const packages = (state) => state.packages

export const getPackageById = (state) => (id) => {
  return state.packages.find(packages => packages.id === id)
}