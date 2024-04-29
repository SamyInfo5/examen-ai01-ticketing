const state = () => ({
  role_id: []
})

const getters = {
  role_id: (state) => state.role_id
}

export default {
  state,
  getters,
  mutations: {
    SET_ROLES_ID(state, list) {
      state.role_id = list
    },
  },
  actions: {
    async getRole({commit, dispatch}) {
      try{
        const role = await this.$axios.$get('/api/role/')
        commit('SET_ROLES_ID', role)
      } catch (e) {
        console.error(e)
      }
    }
  }
}
