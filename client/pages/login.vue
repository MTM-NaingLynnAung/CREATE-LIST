<template>

 <div class="">
  <div class="container mt-3">
    <h2>Login Form</h2>
    <form @submit.prevent="login">
      <div class="col-4">
        <div class="form-group">
          <label for="">Email : </label>
          <input type="email" class="form-control" v-model="email">
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.email" :key="error">{{ error }}</span>
          </div>
        </div>
        <div class="form-group">
          <label for="">Password : </label>
          <input type="password" class="form-control" v-model="password">
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.password" :key="error">{{ error }}</span>
          </div>
        </div>
        <button class="btn btn-primary mt-3" type="submit">Login</button>
      </div>
    </form>
  </div></div> 
 
</template>

<script>
export default {
  data(){
    return {
        email : '',
        password: '',
      errors: [],
      errorMessage: false
    }
  },
  methods: {
    async login(){
      await this.$auth.loginWith('laravelSanctum', { 
        data: {
          email: this.email,
          password: this.password
        }
       })
     this.$router.push('/category')
    }
  }
}
</script>

<style>
</style>

