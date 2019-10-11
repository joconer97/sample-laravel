<template>
  <div>
    <b-navbar
      toggleable="lg"
      type="dark"
      variant="dark"
    >
      <b-navbar-brand href="#">
        ORB
      </b-navbar-brand>

      <b-navbar-toggle target="nav-collapse" />
      <b-collapse
        id="nav-collapse"
        is-nav
      >
        <b-navbar-nav class="ml-auto">
          <b-nav-text style="color:white">
            Login
          </b-nav-text>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>

    <div
      class="container"
      style="margin-top : 150px"
    >
      <b-card-group>
        <b-card title="Registration">
          <b-card-body>
            <b-form @submit.prevent="register">
              <!-- <b-form-group id="input-group-2" label="Your First name:" label-for="input-1">
                                <b-form-input
                                id="input-1"
                                v-model="form.name"
                                required
                                placeholder="First name"
                                ></b-form-input>
                            </b-form-group> -->

              <b-form-group
                id="input-group-2"
                label="Your name:"
                label-for="input-2"
              >
                <b-form-input
                  id="input-2"
                  v-model="form.name"
                  required
                  placeholder="Last name"
                />
              </b-form-group>

              <b-form-group
                id="input-group-3"
                label="Email address:"
                label-for="input-3"
                description="We'll never share your email with anyone else."
              >
                <b-form-input
                  id="input-3"
                  v-model="form.email"
                  type="email"
                  required
                  placeholder="Enter email"
                />
              </b-form-group>

              <b-form-group
                id="input-group-4"
                label="Password :"
                label-for="input-4"
              >
                <b-form-input
                  id="input-4"
                  type="password"
                  required
                  placeholder="Password"
                />
              </b-form-group>

              <b-form-group
                id="input-group-5"
                label="Password :"
                label-for="input-5"
              >
                <b-form-input
                  id="input-5"
                  type="password"
                  required
                  placeholder="Confirm Password"
                />
              </b-form-group>

              <b-button
                type="submit"
                variant="primary"
              >
                Submit
              </b-button>
            </b-form>
          </b-card-body>
        </b-card>
      </b-card-group>
    </div>
  </div>
</template>
<script>
import { BForm, BFormGroup, BFormInput } from 'bootstrap-vue'
export default {
  components: {
    BForm, BFormGroup, BFormInput,
  },
  data () {
    return {
      form: {
        name           : '', email          : '', password       : '', confirmPassword: '',
      },
    }
  },
  methods: {
    register () {
      this.$auth.register({
        params    : this.form, // data: {} in Axios
        success   : function () {},
        error     : function () {},
        autoLogin : true,
        rememberMe: true,
        redirect  : { name: 'account' },
        // etc...
      })
    },
  },
}
</script>
