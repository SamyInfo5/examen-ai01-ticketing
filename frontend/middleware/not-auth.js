export default async ( { store, redirect }) =>  {
  if(store.state.auth) return redirect('/home')
}
