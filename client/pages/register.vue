<template>

 <div class="">
  <div class="container mt-3">
    <h2>Register Form</h2>
    <form @submit.prevent="register">
      <div class="col-4">
        <div class="form-group">
          <label for="">Name :</label>
          <input type="text" class="form-control" v-model="user.name">
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.name" :key="error">{{ error }}</span>
          </div>
        </div>
        <div class="form-group">
          <label for="">Email : </label>
          <input type="email" class="form-control" v-model="user.email">
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.email" :key="error">{{ error }}</span>
          </div>
        </div>
        <div class="form-group">
          <label for="">Password : </label>
          <input type="password" class="form-control" v-model="user.password">
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.password" :key="error">{{ error }}</span>
          </div>
        </div>
        <div class="form-group">
          <label for="">Confirm Password : </label>
          <input type="password" class="form-control" v-model="user.c_password">
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.c_password" :key="error">{{ error }}</span>
          </div>
        </div>
        <button class="btn btn-primary mt-3" type="submit">Register</button>
      </div>
    </form>
  </div></div> 
 
</template>

<script>
export default {
  data(){
    return {
      user: {
        name: '',
        email : '',
        password: '',
        c_password: ''
      },
      errors: [],
      errorMessage: false
    }
  },
  methods: {
    register(){
      this.$axios.post('/register', this.user)
      .then(response => {
        this.errorMessage = false
        this.$router.push('/login')
      })
      .catch(error => {
        this.errors = error.response.data.errors
        console.log(this.errors)
        this.errorMessage = true
      });
    }
  }
}
</script>

<style>
</style>
