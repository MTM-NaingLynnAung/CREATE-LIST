<template>
  <div class="container mt-5">
    <form @submit.prevent="update()" class="w-25">

        <div class="form-group">
          <label>Category : </label>
          <input type="text" v-model="category.name" class="form-control" />
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.name" :key="error">{{ error }}</span>
          </div>
        </div>
       <button class="btn btn-primary mt-3 btn-sm" type="submit">Update</button>
    </form>
        <NuxtLink to="/category" class="btn btn-dark btn-sm mt-3">Back</NuxtLink>
  </div>
</template>

<script>
export default {
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
      this.$axios.put(`/category/${this.category.id}`, this.category)
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
    this.$axios.get('/category/'+ this.category.id)
    .then(response => {
      this.category = response.data
    })
  }
}
</script>

<style>

</style>
