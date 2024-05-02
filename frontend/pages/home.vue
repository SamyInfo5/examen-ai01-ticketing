<template lang="pug">
.container
  span My Tickets
  el-button(type="primary" round @click="dialogFormVisible = true")
    i(class="el-icon-plus")
    span Add Tickets
  el-card.card(v-for="(index, i) in ticket" :key="i")
    el-row
      el-col(:span="12")
        span title : {{ index.name }} <br>
        span description : {{ index.description }} <br>
        span Status : {{ getStatusName(index.status_id) }}
      el-col.btn-group(:span="12")
        el-popconfirm(
          title="your sur ?"
          confirm-button-text='i am sur'
          cancel-button-text='No, Thanks'
          @confirm="deleteTask(index.id)"
        )
          el-button(slot="reference" type="danger" icon="el-icon-delete" circle)
        el-button(type="primary" icon="el-icon-edit" circle @click="openEditModal(index.id)")

  el-dialog(title="Add Task" :visible.sync="dialogFormVisible")
    el-form( ref="taskPayload" :model="taskPayload" :rules="rules")
      el-form-item(label="Title" prop="name")
        el-input(v-model="taskPayload.name")
      el-form-item(label="description" prop="description")
        el-input(v-model="taskPayload.description")
      el-select(v-model="taskPayload.status_id" label="status" prop="status")
        el-option(v-for="(item, i) in role" :key="i" :label="item.name" :value="item.id")

    span(slot="footer" class="dialog-footer")
      el-button(@click="dialogFormVisible = false") annuler
      el-button(@click="submitFormAdd") Ajouter

  el-dialog(title="Edit Task" :visible.sync="dialogFormEditVisible" @close="closeModal")
    el-form( ref="taskPayload" :model="taskPayload" :rules="rules")
      el-form-item(label="Title" prop="name")
        el-input(v-model="taskPayload.name")
      el-form-item(label="description" prop="description")
        el-input(v-model="taskPayload.description")
      el-select(v-model="taskPayload.status_id" placeholder="Select a status" prop="status")
        el-option(v-for="(item, i) in role" :key="i" :label="item.name" :value="item.id")
    span(slot="footer" class="dialog-footer")
      el-button(@click="dialogFormVisible = false") annuler
      el-button(@click="editTask") Modifier
</template>

<script>

const defaulTaskPayload = {
  name: null,
  description: null,
  status_id: null
}

export default {
  name: "HomePage",
  middleware: ['authenticated'],
  data() {
    return {
      editingTaskId: null,
      ticket: [],
      role: [],
      taskPayload: Object.assign({}, defaulTaskPayload),
      dialogFormVisible: false,
      dialogFormEditVisible: false,
      rules: {
        name: [
          { required: true, message: 'Please input name', trigger: 'blur' },
        ],
        description: [
          { required: true, message: 'Please input description', trigger: 'blur' },
        ],
        status: [
          { required: true, message: 'Please input status', trigger: 'blur' },
        ]
      }
    }
  },
  async fetch() {
    this.ticket = await this.$axios.$get('/api/support/')
    this.role = await this.$axios.$get('/api/status/')
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
              message: 'Task Created',
              type: 'success'
            });
            this.taskPayload = Object.assign({}, defaulTaskPayload);
          } catch (e) {
            this.$message.error('Fields missed');
          }
          this.$fetch()
        }
      })
    },
    deleteTask(id) {
      this.$axios.$delete(`/api/support/${id}/`)
      this.$notify({
        title: 'Deleted',
        message: 'Task Deleted',
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
              message: 'Task Edited',
              type: 'success'
            })
            this.taskPayload.name = null;
            this.taskPayload.description = null;
            this.$fetch()
          } catch {
            this.$message.error('Edit failed');
          }
        }
      })
    },
    closeModal() {
      this.taskPayload = Object.assign({}, defaulTaskPayload);
    },
    getStatusName(statusId) {
    const status = this.role.find(item => item.id === statusId)
    return status ? status.name : 'Unknown'
  },
  }
}
</script>
