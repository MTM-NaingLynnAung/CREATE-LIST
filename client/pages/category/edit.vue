<template>
  <div class="container mt-5">
    <h3>Edit Category</h3>
    <form @submit.prevent="update()" class="w-25">

        <div class="form-group">
          <label>Name : </label>
          <input type="text" v-model="category.name" class="form-control" />
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.name" :key="error">{{ error }}</span>
          </div>
        </div>
        <div class="mt-3 d-flex justify-content-between">
          <NuxtLink to="/category" class="btn btn-dark">Back</NuxtLink>
        <button class="btn btn-primary" type="submit">Update</button>
        </div>
    </form>
  </div>
</template>

<script>
export default {
  middleware: 'auth',
  data(){
    return {
      category: {
        id: '',
        name: ''
      },
      errorMessage: false,
      errors: []
    }
  },
  methods: {
    update(){
      this.$axios.put(`/api/category/${this.category.id}`, this.category)
      .then(response => {
        this.$router.push({ name: 'category' })
        this.errorMessage = false
      })
      .catch(error => {
        this.errors = error.response.data.errors
        this.errorMessage = true
      })
    }
  },
  mounted(){
    this.category.id = this.$route.params.id
    this.$axios.get('/api/category/'+ this.category.id)
    .then(response => {
      this.category = response.data
    })
  }
}
</script>

<style>

</style>
