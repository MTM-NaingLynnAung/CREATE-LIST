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
            <select class="form-control" v-model="product.category" multiple>
              <option :value="category.name" v-for="category in categories" :key="category.id" selected>{{ category.name }}</option>
            </select>
            <div v-if="errorMessage">
              <span class="text-danger" v-for="error in errors.category_id" :key="error">{{ error }}</span>
            </div>
          </div>
          <div class="form-group">
            <b-form-file v-model="product.image" class="mt-3 form-control" plain @change="imgPreview" multiple></b-form-file>
            <b-container fluid class="mt-3">
              <b-row v-if="preview">
                <b-col v-for="image in images" :key="image.id">
                <b-img :src="image.preview" v-show="showImage" alt="Fluid image" style="width:100px" class="mb-3"></b-img>
                </b-col>
              </b-row>
              <b-row v-else>
                <b-col v-for="image in product.image" :key="image.id">
                  <b-img :src="imageUrl(image)" v-show="showImage" alt="Fluid image" style="width:100px" class="mb-3"></b-img>
                </b-col>
              </b-row>
            </b-container>
             <div v-if="imageErr != errors.price" v-show="errorMessage">
              <span class="text-danger" v-for="error in imageErr" :key="error">{{ error }}</span>
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
  middleware: 'auth',
  data(){
    return {
      product: {
        id: '',
        name: '',
        price: '',
        category: [],
        image: []
      },
      images: [],
      preview: false,
      showImage: false,
      categories: [],
      errorMessage: false,
      errors: [],
      imageErr: null
    }
  },
  methods: {
     update() {
      const formData = new FormData();
      formData.append('name', this.product.name)
      formData.append('price', this.product.price)
      formData.append('category', this.product.category)
      this.product.image.forEach(element => {      
         formData.append('image[]', element);
      }); 
      this.$axios.post(`/api/product-update/${this.product.id}`, formData)
        .then(response => {
          this.errorMessage = false
          this.$router.push({name : 'product'})
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.imageErr = Object.values(this.errors).pop()
          this.errorMessage = true
        })
    },
    imageUrl(image){
      return `http://127.0.0.1:8000/storage/${image}`
    },
    imgPreview(e) {
      this.preview = true
      let files = e.target.files
      for (let i = 0; i < files.length; i++) {
        this.product.image = files[i];
        let img = {
          preview: null
        };
        let reader = new FileReader();
        reader.addEventListener('load', function () {
          this.showImage = true
          img.preview = reader.result
          this.images.push(img)
        }.bind(this), false)
        reader.readAsDataURL(this.product.image)
        this.images = []
      }

    },
    list(){
      this.$axios.get('/api/all')
        .then(response => {
          this.categories = response.data
        })
    }
  },
  mounted(){
    this.list()
    this.product.id = this.$route.params.id
    this.$axios.get('/api/product/'+ this.product.id)
      .then(response => {
        this.product = response.data.data
        this.product.category = this.product.category
        this.showImage = true
      })
  }
}
</script>

<style>

</style>
