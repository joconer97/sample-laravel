import Vue from 'vue'
import Router from 'vue-router'

// Containers


// Views


// Views - Pages
import Page404 from '@/views/pages/Page404'
import Page500 from '@/views/pages/Page500'
import Login from '@/views/pages/Login'
import Register from '@/views/pages/Register'
import Home from '@/views/pages/Home'
import MainCustomer from '@/views/pages/MainCustomer'
import CustomerNew from '@/views/pages/CustomerNew'
import LandingPage from '@/views/pages/LandingPage'
import CustomerEdit from '@/views/pages/CustomerEdit'
import Payslip from '@/views/pages/Payslip'
import Payment from '@/views/pages/Payment'
import Full from '@/containers/Full'
import Dashboard from '@/views/sample/Dashboard'
import Employee from '@/views/pages/Employee'
import EmployeeCreate from '@/views/pages/EmployeeCreate'
import EmployeeList from '@/views/pages/EmployeeList'
import EmployeeUpdate from '@/views/pages/EmployeeUpdate'
import Room from '@/views/pages/Room'
import RoomCreate from '@/views/pages/RoomCreate'
import RoomList from '@/views/pages/RoomList'
import RoomUpdate from '@/views/pages/RoomUpdate'
import AttendanceRecord from '@/views/pages/AttendanceRecord'
import Inventory from '@/views/pages/Inventory'
// Sample route
import sample from './sample'

Vue.use(Router)

export default new Router({
  mode           : 'history',
  linkActiveClass: 'open active',
  scrollBehavior : () => ({ y: 0 }),
  routes         : [
    {
      path     : '/',
      component: LandingPage,
      meta : {
        requiresAuth : false
      }
    },
    {
      path : '/attendance',
      name : 'Attendance',
      component : AttendanceRecord,
      meta : {
        requiresAuth : true
      }
    },
    {
      path     : '/user/dashboard',
      redirect : '/dashboard',
      name     : 'Home',
      component: Full,
      meta : {
        requiresAuth : true
      },
      children : [
        {
          path     : '/dashboard',
          name     : 'Dashboard',
          component: Dashboard,
        },
        {
          path : '/inventory',
          name : 'Inventory',
          component : Inventory
        },
        {
          path     : '/employee',
          redirect : '/employee/list',
          name     : 'Employee',
          component: Employee,
          children : [
            {
              path : 'list',
              name : 'Employee list',
              component : EmployeeList
            },
            {
              path : '/employee/create',
              name : 'EmployeeCreate',
              component : EmployeeCreate
            },
            {
              path : `/employee/update/:id`,
              name : 'EmployeeUpdate',
              component : EmployeeUpdate
            },
            
          ]
        },
        {
          path     : '/room',
          redirect : '/room/list',
          name     : 'Room',
          component: Room,
          children : [
            {
              path : 'list',
              name : 'Room list',
              component : RoomList
            },
            {
              path : '/room/create',
              name : 'RoomCreate',
              component : RoomCreate
            },
            {
              path : `/room/update/:id`,
              name : 'RoomUpdate',
              component : RoomUpdate
            },
            
          ]
        },
        ...sample,
      ],
    },
    {
      path : '/payslip',
      component : Payslip
    },
    {
      path : '/payment',
      component : Payment
    },
    {
      path     : '/pages',
      redirect : '/pages/404',
      name     : 'Pages',
      component: { render (c) { return c('router-view') } },
      children : [
        {
          path     : '404',
          name     : 'Page404',
          component: Page404,
        },
        {
          path     : '500',
          name     : 'Page500',
          component: Page500,
        },
        {
          path     : 'login',
          name     : 'Login',
          component: Login,
        },
        {
          path     : 'register',
          name     : 'Register',
          component: Register,
        }
      ],
    },
    {
      path     : '*',
      name     : '404',
      component: Page404,
    },
  ],
})
