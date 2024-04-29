<template lang="pug">
.container
  .chat-box
    div.df(v-for="(item, index) in messages" :key="index" :class="{ 'even-message': index % 2 === 0 }")
      span {{ item.username }}
      span.messages {{ item.message }}
    .sendMessage
      el-form()
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
      console.log(data)
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

<style lang="scss">
.even-message {
  background-color: blue;
  color: white;
  span{
    color: white !important;
  }
}
.df{
  display: flex;
  flex-direction: column;
}
</style>
