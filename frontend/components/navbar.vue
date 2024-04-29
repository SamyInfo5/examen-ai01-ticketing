<template lang="pug">
div
  ul(v-if="auth")
    li
      el-button
        NuxtLink(to="/messages") Messages
    li
      el-button(@click="logout") deconnecter
  ul(v-if="!auth")
    li
      el-button(round)
        NuxtLink(to="login") Login
    li
      el-button(round)
        NuxtLink(to="/register") Register
</template>

<script>
import { mapState } from 'vuex'

export default {
  computed: {
    ...mapState(['auth'])
  },
  methods: {
    logout() {
      console.log('coucu')
      this.$store.dispatch('logout')
      this.$router.push('/')
    }
  }
}
</script>
