<template lang="pug">
.container
  .chat-box
    div.messages(v-for="(item, index) in messages" :key="index" :class="item.username === username ? 'sent-mess': 'received-mess'")
      span {{ item.username }}
      span(:class="item.username === username ? 'sent': 'received'" ) {{ item.message }}
    .sendMessage
      el-form.input-chat
        el-input(placeholder="Enter Your Messages" v-model="message")
        el-button(@click="send") Send
</template>

<script>
import Pusher from 'pusher-js'
export default {
  middleware: ['authenticated'],
  data() {
    return {
      username: "",
      message: "",
      messages: [],
    }
  },
  mounted() {
    Pusher.logToConsole = true;

    const pusher = new Pusher('d971f26e54381a3238a8', {
      cluster: 'eu'
    });

    const channel = pusher.subscribe('chat');
    console.log({ channel })
    channel.bind('message', (data) => {
      this.messages.push(data)
    });
  },
  async fetch() {
    const data = await this.$axios.$get('/api/profile/')
    this.username = data.user.name
  },
  methods: {
    async send() {
      await this.$axios.$post('/api/messages/', {
        username: this.username,
        message: this.message
      })
      this.message = ""
    }
  }
}
</script>
</style>
