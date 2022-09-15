<template>
  <div class="container mt-5">
    <h3>Create Product</h3>
    <form @submit.prevent="store()" class="w-25">
        <div class="form-group">
          <label for="">Name : </label>
          <input type="text" v-model="product.name" class="form-control">
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.name" :key="error">{{ error }}</span>
          </div>
          <div class="form-group">
            <label for="">Price : </label>
            <input type="number" v-model="product.price" class="form-control">
            <div v-if="errorMessage">
              <span class="text-danger" v-for="error in errors.price" :key="error">{{ error }}</span>
            </div>
          </div>
          <div class="form-group">
            <label for="">Category : </label>
            <select class="form-control" v-model="product.category" multiple>
              <option selected :value="[]" >Choose Category</option>
              <option :value="category.name" v-for="category in categories" :key="category.id">{{ category.name }}</option>
            </select>
            <div v-if="errorMessage">
              <span class="text-danger" v-for="error in errors.category" :key="error">{{ error }}</span>
            </div>
          </div>
        <div class="mt-3 d-flex justify-content-between">
          <NuxtLink to="/product" class="btn btn-dark">Back</NuxtLink>
          <button class="btn btn-primary" type="submit">Create</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  // middleware: 'auth',
  data(){
    return {
      product: {
        id: '',
        name: '',
        price: '',
        category: []
      },
      categories: [],
      errorMessage: false,
      errors: []
    }
  },
  methods: {
     store() {
      this.$axios.post('/api/product', this.product)
        .then(response => {
          this.errorMessage = false
          this.$router.push({name : 'product'})
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.errorMessage = true
        })
    },
    view(){
      this.$axios.get('/api/product')
        .then(response => {
          this.categories = response.data.category
        })
    },
  },
  mounted(){
    this.view()
  }
}
</script>

<style>

</style>
