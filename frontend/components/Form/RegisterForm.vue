<template lang="pug">
.container
  el-form(ref="registerPayload" :model="registerPayload" :rules="rules")
    el-form-item(label="Username" prop="name")
      el-input(v-model="registerPayload.name")
    el-form-item(label="email" prop="email")
      el-input(v-model="registerPayload.email")
    el-form-item(label="password" prop="pass" autocomplete="off")
      el-input(v-model="registerPayload.password" type="password" show-password)
    el-form-item(label="confirmpassword" prop="checkPass" autocomplete="off")
      el-input(v-model="registerPayload.confirmpassword" type="password" show-password)
    el-form-item(label="Role" prop="role_id")
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
  role_id: null
};

export default {
  name: "RegistrationForm",
  data() {
    const validatePass = (rule, value, callback) => {
        if (this.registerPayload.password === '') {
          callback(new Error('Veuillez entrer le mot de passe'));
        } else {
          if (this.registerPayload.confirmpassword !== '') {
            this.$refs.registerPayload.validateField('checkPass');
          }
          callback();
        }
      };
      const validatePass2 = (rule, value, callback) => {
        if (this.registerPayload.confirmpassword === '') {
          callback(new Error('Veuillez entrer à nouveau le mot de passe'));
        } else if (this.registerPayload.confirmpassword !== this.registerPayload.password) {
          callback(new Error('Les deux entrées ne correspondent pas!'));
        } else {
          callback();
        }
    }
    return {
      registerPayload: Object.assign({}, defaultRegisterPayload),
      rules: {
        name: [{ required: true, message: "Username is required", trigger: "blur" }],
        email: [{ required: true, message: "Email is required", trigger: "blur" }],
        pass: [{required: true, validator: validatePass, trigger: 'blur' }],
        checkPass: [{required: true, validator: validatePass2, trigger: 'blur' }],
        role_id: [{ required: true, message: "role is required", trigger: "blur" }]
      },
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
