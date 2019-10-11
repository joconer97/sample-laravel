<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header">
            Customers
          </div>
          <router-link to="/new">
            New Customer
          </router-link>
          <div class="card-body">
            <router-view />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default { name: 'CustomersMain' }
</script>
