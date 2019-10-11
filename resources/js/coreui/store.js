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
    employeesLabel : []
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
    }
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
    updateEmployeeLabels(state,payload){
      state.employeesLabel = payload
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
    getEmployeesLabel(context){
        var temps = []

        for(let i = 1;i <= 4; i++){
              new Promise(function(resolve, reject) {
              try {
                  var xhr = new XMLHttpRequest();
                  xhr.open("GET", "https://vuespatest.test/images/label_images/3-arnel/1.jpg");
                  xhr.responseType = "blob";
                  xhr.onerror = function() {reject("Network error.")};
                  xhr.onload = function() {
                      if (xhr.status === 200) 
                      {
                          resolve(xhr.response)
                          let temp = {name : 'Arnel Joshua',image : xhr.response}
                          if(temp != undefined){
                              console.log(i)
                              temps.push(temp)
                          }
                      }
                      else {reject("Loading error:" + xhr.statusText)}
                  };
                  xhr.send();
              }
              catch(err) {reject(err.message)}
          })
        }
        context.commit('updateEmployeeLabels',temps)
    }
  
  

  },
}
