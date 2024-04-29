<template lang="pug">
.container
  .login-form
    FormLoginForm
</template>

<script>
export default {
  middleware: ['not-auth']
}
</script>
