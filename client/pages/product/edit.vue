<template>
  <div class="container mt-5">
    <h3>Edit Product</h3>
    <form @submit.prevent="update()" class="w-25">
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
            <select class="form-control" v-model="product.category_id">
              <option :value="category.id" v-for="category in categories" :key="category.id">{{ category.name }}</option>
            </select>
            <div v-if="errorMessage">
              <span class="text-danger" v-for="error in errors.category_id" :key="error">{{ error }}</span>
            </div>
          </div>
        <div class="mt-3 d-flex justify-content-between">
          <NuxtLink to="/product" class="btn btn-dark">Back</NuxtLink>
          <button class="btn btn-primary" type="submit">Update</button>
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
        category: ''
      },
      categories: [],
      errorMessage: false,
      errors: []
    }
  },
  methods: {
     update() {
      this.$axios.put(`/api/product/${this.product.id}`, this.product)
        .then(response => {
          this.errorMessage = false
          this.$router.push({name : 'product'})
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.errorMessage = true
        })
    },
    list(){
      this.$axios.get('/api/product')
        .then(response => {
          console.log(response.data)
          this.categories = response.data.category
        })
    }
  },
  mounted(){
    this.list()
    this.product.id = this.$route.params.id
    this.$axios.get('/api/product/'+ this.product.id)
    .then(response => {
      this.product = response.data
    })
  }
}
</script>

<style>

</style>
