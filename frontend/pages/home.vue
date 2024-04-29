<template lang="pug">
.container
  span My Tickets
  el-button(type="primary" round @click="dialogFormVisible = true")
    i(class="el-icon-plus")
    span Add Tickets
  el-card(v-for="(index, i) in ticket" :key="i")
    el-row
      el-col(:span="12")
        span title : {{ index.name }} <br>
        span description : {{ index.description }}
      el-col(:span="12")
        el-popconfirm(
          title="sur frerot ?"
          confirm-button-text='OK'
          cancel-button-text='No, Thanks'
          @confirm="deleteTask(index.id)"
        )
          el-button(slot="reference" type="danger" icon="el-icon-delete" circle)
        el-button(type="primary" icon="el-icon-edit" circle @click="openEditModal(index.id)")

  el-dialog(title="Add Task" :visible.sync="dialogFormVisible")
    el-form( ref="taskPayload" :model="taskPayload")
      el-form-item(label="Title")
        el-input(v-model="taskPayload.name")
      el-form-item(label="description")
        el-input(v-model="taskPayload.description")
    span(slot="footer" class="dialog-footer")
      el-button(@click="dialogFormVisible = false") annuler
      el-button(@click="submitFormAdd") Ajouter

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

const defaulTaskPayload = {
  name: null,
  description: null
}
export default {
  name: "HomePage",
  middleware: ['authenticated'],
  data() {
    return {
      editingTaskId: null,
      ticket: [],
      taskPayload: Object.assign({}, defaulTaskPayload),
      dialogFormVisible: false,
      dialogFormEditVisible: false
    }
  },
  async fetch() {
    this.ticket = await this.$axios.$get('/api/support/')
  },
  methods: {
    submitFormAdd() {
      this.$refs.taskPayload.validate(async (valid) => {
        if (valid) {
          try {
            await this.$axios.$post('/api/support/', this.taskPayload)
            this.dialogFormVisible = false
            this.$notify({
              title: 'Success',
              message: 'Tâche Crée',
              type: 'success'
            });
            this.taskPayload = Object.assign({}, defaulTaskPayload);
          } catch (e) {
            console.error('Error', e)
          }
          this.$fetch()
        }
      })
    },
    deleteTask(id) {
      this.$axios.$delete(`/api/support/${id}/`)
      this.$notify({
        title: 'Deleted',
        message: 'Tâche Supprimer',
        type: 'success'
      });
      this.$fetch()
    },
    async openEditModal(id) {
      this.editingTaskId = id;
      this.dialogFormEditVisible = true
      const data = await this.$axios.$get(`/api/support/${id}`);
      this.taskPayload.name = data.name
      this.taskPayload.description = data.description
    },
    editTask() {
      const id = this.editingTaskId
      this.$refs.taskPayload.validate(async (valid) => {
        if (valid) {
          try {
            await this.$axios.$patch(`/api/support/${id}`, this.taskPayload)
            this.dialogFormEditVisible = false
            this.$notify({
              title: 'Success',
              message: 'Tâche Crée',
              type: 'success'
            })
            this.taskPayload.name = null;
            this.taskPayload.description = null;
          } catch (e) {
            console.error('Error', e)
          }
          this.$fetch()
        }
      })
    }
  }
}
</script>
