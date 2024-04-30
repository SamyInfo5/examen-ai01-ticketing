const state = () => ({
  status_id: []
})

const getters = {
  status_id: (state) => state.status_id
}

export default {
  state,
  getters,
  mutations: {
    SET_STATUS_ID(state, list) {
      state.status_id = list
    },
  },
  actions: {
    async getStatus({commit, dispatch}) {
      try{
        const status = await this.$axios.$get('/api/status/')
        commit('SET_STATUS_ID', status)
      } catch (e) {
        console.error(e)
      }
    }
  }
}
