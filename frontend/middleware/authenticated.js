export default async ( { store, redirect }) => {
  if(store.state.auth) return await store.dispatch('checkAuth')
  if(!store.state.auth) return redirect('/login')
}
