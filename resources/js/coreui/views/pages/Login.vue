<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group mb-0">
            <div class="card p-4">
              <div class="card-body">
                <h1>Login</h1>
                <p class="text-muted">
                  Sign In to your account
                </p>
                <div class="input-group mb-3">
                  <span class="input-group-addon"><i class="icon-user" /></span>
                  <input
                    v-model="form.email"
                    type="email"
                    class="form-control"
                    placeholder="email"
                  >
                </div>
                <div class="input-group mb-4">
                  <span class="input-group-addon"><i class="icon-lock" /></span>
                  <input
                    v-model="form.password"
                    type="password"
                    class="form-control"
                    placeholder="Password"
                  >
                </div>
                <div class="row">
                  <div class="col-6">
                    <button
                      type="button"
                      class="btn btn-primary px-4"
                      @click="authenticate"
                    >
                      Login
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div
              class="card text-white bg-primary py-5 d-md-down-none"
              style="width:44%"
            >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { login } from '../../helpers/auth'

export default {
  name: 'Login',
  data () {
    return {
      form: {
        email   : '',
        password: '',
        role    : 'Admin',
      },
      error: null,
    }
  },
  methods: {
    authenticate () {
      this.$store.dispatch('login')

      login(this.$data.form)
        .then((res) => {
          this.$store.commit('loginSuccess', res)
          this.$router.push('/user/dashboard')
        })
        .catch((error) => {
          this.$store.commit('loginFailed', { error })
        })
    },
  },
  created(){
    console.log(this.$store.getters.currentUser)
  }
}
</script>
<style lang="scss" scoped>
.btn-primary {
    color: #fff;
    background-color: #901d1d;
    border-color: #540202;
}
.bg-primary {
    background-color: #941212 !important;
}
</style>
