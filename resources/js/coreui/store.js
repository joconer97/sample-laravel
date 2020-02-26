import { getLocalUser } from './helpers/auth'

const user = getLocalUser()
// server.js

// Replace with your stripe public and secret keys
export default {
  state: {
    currentUser  : user,
    isLoggedIn   : !!user,
    loading      : false,
    auth_error   : null,
    employees : [],
    rooms : [],
    items : [],
    locations : [],
    tasks : [],
    inventoryReports : [],
    inventoryReportsDay : []
  },
  getters: {
    isLoading (state) {
      return state.loading
    },
    isLoggedIn (state) {
      return state.isLoggedIn
    },
    currentUser (state) {
      return state.currentUser
    },
    authError (state) {
      return state.auth_error
    },
    employees (state){
      return state.employees
    },
    rooms (state){
      return state.rooms
    },
    items(state){
      return state.items
    },
    employeesLabel(state){
      return state.employeesLabel
    },
    locations(state){
      return state.locations
    },
    tasks(state){
      return state.tasks
    },
    inventoryReports(state){
      return state.inventoryReports
    },
    inventoryReportsDay(state){
      return state.inventoryReportsDay
    },
    
  },
  mutations: {
    login (state) {
      state.loading    = true
      state.auth_error = null
    },
    loginSuccess (state, payload) {
      state.auth_error  = null
      state.isLoggedIn  = true
      state.loading     = false
      state.currentUser = Object.assign({}, payload.user, { token: payload.access_token })

      localStorage.setItem('user', JSON.stringify(state.currentUser))
    },
    loginFailed (state, payload) {
      state.loading    = false
      state.auth_error = payload.error
    },
    logout (state) {
      localStorage.removeItem('user')
      state.isLoggedIn  = false
      state.currentUser = null
    },
    updateEmployee (state,payload){
      state.employees = payload
    },
    updateRooms(state,payload){
      state.rooms = payload
    },
    updateItems(state,payload){
      state.items = payload
    },
    updateLocations(state,payload){
      state.locations = payload
    },
    updateTasks(state,payload){
      state.tasks = payload
    },
    updateInventoryReports(state,payload){
      state.inventoryReports = payload
    },
    updateInventoryReportsDay(state,payload){
      state.inventoryReportsDay = payload
    }
  },
  actions: {
    login (context) {
      context.commit('login')
    },
    getEmployee(context){
      axios.get('/api/users')
        .then(response => {
          context.commit('updateEmployee', response.data.users)
        })
    },
    getRooms(context){
      axios.get('/api/rooms')
      .then(response => {
        context.commit('updateRooms',response.data.rooms)
      })
    },
    getItems(context){
      axios.get('api/items')
      .then(response => {
        context.commit('updateItems',response.data.items)
      })
    },
    getLocations(context){
      axios.get('/api/location').then(response => {
        context.commit('updateLocations',response.data.locations)
      })
    },
    getTasks(context){
      axios.get('/api/task').then(response => {
        context.commit('updateTasks',response.data.tasks)
      })
    },
    getInventoryReports(context){
      axios.get('/api/inventory').then(response => {
        context.commit('updateInventoryReports',response.data.inventoryMonth)
        context.commit('updateInventoryReportsDay',response.data.inventoryDay)

      })
    }
  },
}
