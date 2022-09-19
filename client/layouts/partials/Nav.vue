<template>
  <div class="">
    
    <nav class="navbar bg-light">
      <div class="container">
        <NuxtLink to="/" class="navbar-brand">CRUD</NuxtLink>
        <div v-if="$auth.loggedIn == true" class="d-flex">
          <div class="mr-3">
           {{ $auth.user.email }}
          </div>
          <nuxt-link to="/category" class="btn btn-sm btn-secondary mr-3">Category List</nuxt-link>
          <nuxt-link to="/product" class="btn btn-sm btn-info mr-3">Product List</nuxt-link>
          <button class="btn btn-sm btn-outline-danger" @click="logout">Logout</button>
        </div>
        <div v-else>
          <nuxt-link to="/login" class="btn btn-sm btn-outline-success">Login</nuxt-link>
          <NuxtLink to="/register" class="btn btn-sm btn-outline-primary">Register</NuxtLink>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
export default {

  methods: {
    async logout(){
      await this.$auth.logout();
      this.$router.push('/login')
    }
  },

}
</script>
