<template>

 <div class="">
  <div class="container mt-3">
    <h2>Login Form</h2>
    <form @submit.prevent="login">
      <div class="col-4">
        <div class="form-group">
          <label for="">Email : </label>
          <input type="email" class="form-control" v-model="user.email">
         
        </div>
        <div class="form-group">
          <label for="">Password : </label>
          <input type="password" class="form-control" v-model="user.password">
          <div v-if="errorMessage">
            <span class="text-danger" >{{ errors }}</span>
          </div>
        </div>
        <button class="btn btn-primary mt-3" type="submit">Login</button>
      </div>
    </form>
  </div></div> 
 
</template>

<script>
export default {
  auth: 'guest',
  data(){
    return {
       user:{
         email : '',
          password: '',
       },
      errors: {},
      errorMessage: false
    }
  },
  methods: {
    async login(){
      try{
        await this.$auth.loginWith('local', { 
        data: this.user })
        console.log('user login')
          this.$router.push('/')````````
        this.errorMessage = false
      }catch(error){
        this.errors = error.response.data.message
        this.errorMessage = true
      }
    }
  },
  mounted() {
    this.$axios.$get('/sanctum/csrf-cookie');
  }
}
</script>

<style>
</style>

