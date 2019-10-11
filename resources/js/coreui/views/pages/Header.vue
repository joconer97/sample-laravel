<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a
      class="navbar-brand"
      href="#"
    >Navbar</a>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon" />
    </button>

    <div
      id="navbarSupportedContent"
      class="collapse navbar-collapse"
    >
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a
            class="nav-link"
            href="#"
          >Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            href="#"
          >Link</a>
        </li>
        <li class="nav-item dropdown">
          <a
            id="navbarDropdown"
            class="nav-link dropdown-toggle"
            href="#"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            Dropdown
          </a>
          <div
            class="dropdown-menu"
            aria-labelledby="navbarDropdown"
          >
            <a
              class="dropdown-item"
              href="#"
            >Action</a>
            <a
              class="dropdown-item"
              href="#"
            >Another action</a>
            <div class="dropdown-divider" />
            <a
              class="dropdown-item"
              href="#"
            >Something else here</a>
          </div>
        </li>
        <li class="nav-item">
          <a
            class="nav-link disabled"
            href="#"
          >Disabled</a>
        </li>
      </ul>
      <div
        id="navbarSupportedContent"
        class="collapse navbar-collapse"
      >
        <ul class="navbar-nav ml-auto">
          <template v-if="currentUser">
            <li>
              <router-link
                to="/customer"
                class="nav-link"
              >
                Customer
              </router-link>
            </li>
            <li class="nav-item dropdown">
              <a
                id="navbarDropdown"
                href="#"
                class="nav-link dropdown-toggle"
                data-toggle="dropdown"
                role="button"
                aria-expanded="false"
                aria-haspopup="true"
              >
                {{ currentUser.name }}<span class="caret" />
              </a>
              <div
                class="dropdown-menu"
                aria-labelledby="navbarDropdown"
              >
                <a
                  href="#"
                  class="dropdown-item"
                  @click.prevent="logout"
                >Logout</a>
              </div>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script>
export default {
  name: 'AppHeader',
  data () {
    return {}
  },
  computed: {
    currentUser () {
      return this.$store.getters.currentUser
    },
  },
  methods: {
    logout () {
      this.$store.commit('logout')
      this.$router.push('/login')
    },
  },
}
</script>
