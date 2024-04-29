export const state = () => ({
  user: null,
  auth: false
});

export const mutations = {
  setUser(state, user) {
    state.user = user;
    state.auth = !!user;
  },
};

export const actions = {
  async login({ commit }, payload) {
    try {
      const response = await this.$axios.$post(
        "/api/login",
        payload
      );
      const token = response.token;
      this.$cookies.set("csrftoken", token, {
        maxAge: 60 * 60 * 24 * 7,
        secure: true,
      });
      commit("setUser", { token });
      return response;
    } catch (error) {
      console.error(error);
      throw error;
    }
  },

  async logout({ commit }) {
    const token  = this.$cookies.get("csrftoken");
    const logout = await this.$axios.get('/api/profile', {
      headers: { Authorization: `Bearer ${token}` },
    })
    this.$cookies.remove('csrftoken')
    commit("setUser", null);
    return logout
  },

  async checkAuth({ commit }) {
    const authToken = this.$cookies.get("csrftoken");
    const check = await this.$axios.$get("/api/profile", {
      headers: { Authorization: `Bearer ${authToken}` },
    });
    if (authToken) {
      commit("setUser", { token: authToken });
      return check
    }
  },
};
