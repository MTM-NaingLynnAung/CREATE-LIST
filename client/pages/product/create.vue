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
              <option selected :value="[]" disabled>Choose Category</option>
              <option :value="category.name" v-for="category in categories" :key="category.id">{{ category.name }}</option>
            </select>
            <div v-if="errorMessage">
              <span class="text-danger" v-for="error in errors.category_id" :key="error">{{ error }}</span>
            </div>
          </div>
          <div class="form-group">
            
            <b-form-file v-model="product.image" class="mt-3 form-control" plain @change="imgPreview"></b-form-file>
             <b-img :src="imagePreview" v-show="showImage" fluid alt="Fluid image"></b-img>
            <div v-if="errorMessage">
              <span class="text-danger" v-for="error in errors.image" :key="error">{{ error }}</span>
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
        category: [],
        image: null
      },
      imagePreview: null,
      showImage : false,
      categories: [],
      errorMessage: false,
      errors: []
    }
  },
  methods: {
     store() {
      const formData = new FormData();
      formData.append('name', this.product.name)
      formData.append('price', this.product.price)
      formData.append('category', this.product.category)
      formData.append('image', this.product.image)

      this.$axios.post('/api/product', formData)
        .then(response => {
          this.errorMessage = false
          this.$router.push({name : 'product'})
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.errorMessage = true
        })
    },
    imgPreview(e){
       this.product.image = e.target.files[0];
       this.file = e.target.files[0];
       console.log(this.product.image)  
        let reader = new FileReader();
        reader.addEventListener('load', function(){
          this.showImage = true
          this.imagePreview = reader.result
        }.bind(this), false)
        if(this.product.image){
          reader.readAsDataURL(this.product.image)
        }
    },
    view(){
      this.$axios.get('/api/category')
        .then(response => {
          this.categories = response.data.data
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
