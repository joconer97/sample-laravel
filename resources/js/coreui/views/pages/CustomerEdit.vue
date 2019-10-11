<template>
  <div class="container">
    <div class="card card-default">
      <div class="card">
        <div class="card-header">
          Customer
        </div>
        <div class="card-body">
          <input
            v-model="customer.name"
            type="text"
          >
          <input
            v-model="customer.email"
            type="email"
          >
          <button
            class="btn btn-danger"
            @click="edit"
          >
            Save
          </button>
          <button
            class="btn btn-primary"
            @click="back"
          >
            Back to list
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data () {
    return { customer: '' }
  },
  computed: {
    currentUser () {
      return this.$store.getters.currentUser
    },
    customers () {
      return this.$store.getters.customers
    },
  },
  created () {
    if (this.customers.length)
      this.customer = this.customers.find((customer) => customer.id == this.$route.params.id)
  },
  methods: {
    back () {
      this.$router.go(-1)
    },
    edit () {
      axios.put(`/api/customers/edit/`, this.customer).then((response) => {
        console.log(response)
      })
    },
  },

}
</script>
