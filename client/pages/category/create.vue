<template>
  <div class="container mt-5">
    <h3>Create Category</h3>
    <form @submit.prevent="store()" class="w-25">
        <div class="form-group">
          <label for="">Name : </label>
          <input type="text" v-model="category.name" class="form-control">
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.name" :key="error">{{ error }}</span>
          </div>
        <div class="mt-3 d-flex justify-content-between">
          <NuxtLink to="/category" class="btn btn-dark">Back</NuxtLink>
          <button class="btn btn-primary" type="submit">Create</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data(){
    return {
      category: {
        id: '',
        name: '',
      },
      errorMessage: false,
      errors: []
    }
  },
  methods: {
     store() {
      this.$axios.post('/category', this.category)
        .then(response => {
          this.errorMessage = false
          this.$router.push({name : 'category'})
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.errorMessage = true
        })
    },
  }
}
</script>

<style>

</style>
