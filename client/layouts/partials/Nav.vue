<template>
  <div class="">
    
    <nav class="navbar bg-light">
      <div class="container">
        <NuxtLink to="/" class="navbar-brand">CRUD</NuxtLink>
        <!-- <div v-if="isAuthenticated">
          <nuxt-link to="/login" class="btn btn-sm btn-outline-danger">Logout</nuxt-link>
        </div> -->
        <div>
          <nuxt-link to="/login" class="btn btn-sm btn-outline-success">Login</nuxt-link>
          <NuxtLink to="/register" class="btn btn-sm btn-outline-primary">Register</NuxtLink>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>

</script>
