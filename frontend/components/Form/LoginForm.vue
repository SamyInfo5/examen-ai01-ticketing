<template lang="pug">
.container
  el-form(ref="loginPayload" :model="loginPayload")
    el-form-item(label="Username")
      el-input(v-model="loginPayload.name")
    el-form-item(label="password")
      el-input(v-model="loginPayload.password" type="password")
    el-button(@click="submitForm") Login
</template>

<script>
const defaultLoginPayload = {
  name: null,
  password: null
}

export default {
  data() {
    return {
      loginPayload: Object.assign({}, defaultLoginPayload)
    }
  },
  methods: {
    submitForm() {
      this.$refs.loginPayload.validate(async (valid) => {
        if (valid) {
          try {
            await this.$store.dispatch('login', this.loginPayload)
            this.$router.push('/home')
          } catch (e) {
            console.error('Error', e)
          }
        }
      })
    }
  }
}
</script>
