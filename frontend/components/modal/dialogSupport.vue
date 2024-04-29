<template lang="pug">
el-dialog(title="Edit Task" :visible.sync="dialogFormEditVisible")
    el-form( ref="taskPayload" :model="taskPayload")
      el-form-item(label="Title")
        el-input(v-model="taskPayload.name")
      el-form-item(label="description")
        el-input(v-model="taskPayload.description")
    span(slot="footer" class="dialog-footer")
      el-button(@click="dialogFormVisible = false") annuler
      el-button(@click="editTask") Modifier
</template>

<script>
export default {
  name:"DialogSupportComponents",
  props: {
    supportID : {
      type: Number
    }
  }
}
</script>
