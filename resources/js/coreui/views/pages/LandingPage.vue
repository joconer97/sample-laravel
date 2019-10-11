<template>
  <div>
    <login></login>
  </div>
</template>
<script>
import Login from './Login'

export default {
  components : {Login},
  methods: {
    register () {
      this.$router.push('/pages/register')
    },
    
  },
}
</script>
<style>
@media only screen and (max-width: 600px) {
  #navbar{
      margin-bottom : 0px !important;
  }
}
</style>