const state = {
    selectedDate: ''
}

const mutations = {
    setSelectedDate(state, date) {
        state.selectedDate = date
    }
}

export default {
    state,
    mutations
}