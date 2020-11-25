import subject from "."

export const subjects = (state) => state.subjects

export const getSubjectById = (state) => (id) => {
  return state.subjects.find(subject => subject.id === id)
}
