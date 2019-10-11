<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header">
            Customers
          </div>

          <div class="card-body">
            <form @submit.prevent="createCustomer">
              <input
                v-model="form.name"
                type="text"
                placeholder="Name"
              >
              <input
                v-model="form.email"
                type="text"
                placeholder="Email"
              >
              <input
                v-model="form.website"
                type="text"
                placeholder="Website"
              >
              <input
                type="submit"
                value="Create"
              >
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CustomersNew',
  data () {
    return {
      form: {
        name   : '',
        email  : '',
        website: '',
        user_id: this.$store.getters.currentUser.id,
      },
    }
  },
  methods: {
    createCustomer () {
      axios.post('/api/customers/new', this.$data.form).then((response) => {
        if (response.status == 200) {
          this.$store.getters.userCustomers.push(response.data.customer)
          this.$router.push('/customer')
        }
      })
    },
  },
}
</script>
