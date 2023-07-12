const state = {
    selectedDate: ''
}

const mutations = {
    SELECTED_DATE(state, date) {
        state.selectedDate = date
    }
}

const actions = {
    setSelectedDate({ commit }, date) {
      const formattedDate = date.split('-').reverse().join('/')
      commit('SELECTED_DATE', formattedDate)
    }
  }

export default {
    state,
    actions,
    mutations
}