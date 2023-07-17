const state = {
    selectedDate: '',
    selectedHour: ''
}

const mutations = {
    SELECTED_DATE(state, date) {
        state.selectedDate = date
    },
    SELECTED_HOUR(state, hour) {
        state.selectedHour = hour
    }
}

const actions = {
    setSelectedDate({ commit }, date) {
      const formattedDate = date.split('-').reverse().join('/')
      commit('SELECTED_DATE', formattedDate)
    },

    setSelectedHour({ commit }, hour) {
        commit('SELECTED_HOUR', hour)
    }
  }

export default {
    state,
    actions,
    mutations
}