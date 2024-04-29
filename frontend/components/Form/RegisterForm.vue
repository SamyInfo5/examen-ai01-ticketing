<template lang="pug">
.container
  el-form(ref="registerPayload" :model="registerPayload")
    el-form-item(label="Username")
      el-input(v-model="registerPayload.name")
    el-form-item(label="email")
      el-input(v-model="registerPayload.email")
    el-form-item(label="password")
      el-input(v-model="registerPayload.password")
    el-form-item(label="confirmpassword")
      el-input(v-model="registerPayload.confirmpassword")
      el-form-item(label="Role")
        el-select(v-model='registerPayload.role_id')
          el-option(
            v-for="(item, i) in role_choice"
            :key="item.id"
            :label="item.name"
            :value='item.id'
          )
    el-button(@click="submitForm") register
</template>

<script>
const defaultRegisterPayload = {
  name: null,
  email: null,
  password: null,
  confirmpassword: null,
  role_id: []
};

export default {
  name: "RegistrationForm",
  data() {
    return {
      registerPayload: Object.assign({}, defaultRegisterPayload),
      rules: {
        name: [{ required: true, message: "Username is required", trigger: "blur" }],
        email: [{ required: true, message: "Email is required", trigger: "blur" }],
        password: [{ required: true, message: "Password is required", trigger: "blur" }],
        confirmpassword: [{ required: true, message: "Confirmed Password is required", trigger: "blur" }]
      }
    };
  },
  computed: {
    role_choice() {
      return this.$store.getters['roles/role_id']
    }
  },
  created() {
    this.$store.dispatch('roles/getRole')
  },
  methods: {
    submitForm() {
      this.$refs.registerPayload.validate(async (valid) => {
        if (valid) {
          const res = await this.$axios.$post('/api/register', this.registerPayload)
          this.$router.push('/login')
        }
      });
    }
  }
};
</script>
