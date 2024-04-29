// plugins/axios.js
export default function ({ $axios, store }) {
  $axios.onRequest((config) => {
    const user = store.state.user;
    if (user && user.token) {
      config.headers.common['Authorization'] = `Bearer ${user.token}`;
    }
    return config;
  });
}
