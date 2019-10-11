<template>
  <div class="container justify-content-center">
    <div class="col-md-20">
      <table class="table">
        <thead>
          <td>Customer Name</td>
          <td>Customer Email</td>
          <td>Customer Website</td>
        </thead>
        <tbody>
          <template v-if="!customers.length">
            <tr>
              <td colspan="2" class="text-center">0 RECORDS</td>
            </tr>
          </template>
          <template>
            <tr v-for="customer in customers" :key="customer.id">
              <td>{{customer.name}}</td>
              <td>{{customer.email}}</td>
              <td>{{customer.website}}</td>
              <td><router-link :to="{path : `customer/${customer.id}`}">Edit</router-link></td>
            </tr>
          </template>


        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
export default {
  name: "customer-list",
  mounted() {
    //do something after mounting vue instance
    if(this.customers.length)
      return;

      this.$store.dispatch('getUserCustomers',5);

  },
  computed : {
    customers(){
      return this.$store.getters.userCustomers;
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
