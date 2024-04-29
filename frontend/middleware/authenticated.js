export default async ( { store, redirect }) => {
  await store.dispatch('checkAuth')
  if(!store.state.user) return redirect('/login')
}
