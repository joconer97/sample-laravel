export default {
  items: [
    {
      name : 'Dashboard',
      url  : '/dashboard',
      icon : 'icon-speedometer',
      badge: {
        variant: 'primary',
        text   : 'NEW',
      },
    },
    {
      title  : true,
      name   : 'Monitoring',
      class  : '',
      wrapper: {
        element   : '',
        attributes: {},
      },
    },
    {
      name: 'Task Monitoring',
      url : '/theme/colors',
      icon: 'icon-people',
    },
    {
      name: 'Payroll',
      url : '/theme/typography',
      icon: 'icon-book-open',
    },
    {
      title  : true,
      name   : 'Others',
      class  : '',
      wrapper: {
        element   : '',
        attributes: {},
      },
    },
    {
      name    : 'Employee Module',
      url     : '/employee',
      icon    : 'icon-cursor',
      children: [
        {
          name: 'Employee List',
          url : '/employee/',
          icon: 'icon-puzzle',
        },
        {
          name: 'Employee Create',
          url : '/employee/create',
          icon: 'icon-puzzle',
        },
      ]
    },
    {
      name    : 'Room Module',
      url     : '/icons',
      icon    : 'icon-star',
      children: [
        {
          name: 'Room List',
          url : '/room/',
          icon: 'icon-puzzle',
        },
        {
          name: 'Room Create',
          url : '/room/create',
          icon: 'icon-puzzle',
        },
      ]
    },
    {
      name    : 'Item Module',
      url     : '/inventory',
      icon    : 'icon-puzzle',
    },
    {
      name    : 'Attendance',
      url     : '/attendance',
      icon    : 'icon-puzzle',
    },
    {
      name    : 'Maintenance',
      url     : '/buttons',
      icon    : 'icon-cursor',
    },
    {
      name: 'Task Activity',
      url : '/task',
      icon: 'icon-pie-chart',
    },
  ],
}
