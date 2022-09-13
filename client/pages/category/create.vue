<template>
  <div class="container mt-5">
    <form @submit.prevent="store()" class="w-25">
        <div class="form-group">
          <label for="">Category : </label>
          <input type="text" v-model="category.name" class="form-control">
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.name" :key="error">{{ error }}</span>
          </div>
        <button class="btn btn-primary mt-3" type="submit">Create</button>
      </div>
    </form>
    <NuxtLink to="/category" class="btn btn-dark btn-sm">Back</NuxtLink>
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
