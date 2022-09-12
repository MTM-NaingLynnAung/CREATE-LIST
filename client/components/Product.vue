<template>
  <div class="container mt-5">
    <div class="float-right mr-5">

      <b-button @click="createCategory" variant="primary">Create Category</b-button>
      <b-modal v-model="showCat" title="Create Category" @hidden="resetModal">
        <form ref="form" @submit.stop.prevent="storeCat()">
          <b-form-group label="Main Category " label-cols-sm="3" label-align-sm="right">
            <b-form-input id="name"  v-model="category.name"></b-form-input>
              <div v-if="errorMessage">
                <span class="text-danger" v-for="error in errors.name" :key="error">{{ error }}</span>
              </div>
          </b-form-group>
          <b-form-group label="Sub Category" label-cols-sm="3" label-align-sm="right" v-show="subCat">
            <b-form-input id="name"  v-model="category.sub_name"></b-form-input>
              <div v-if="errorMessage">
                <span class="text-danger" v-for="error in errors.name" :key="error">{{ error }}</span>
              </div>
          </b-form-group>
          <b-button type="submit" variant="primary" class="float-right">Create</b-button>
          <b-button variant="dark" class="float-right mr-3" @click="resetModal">Close</b-button>
        </form>
        <template #modal-footer>
          <div class="w-100" style="display: none;">
          </div>
        </template>
      </b-modal>



      <b-button @click="create" variant="primary">Create</b-button>
      <a :href="url" class="btn btn-dark me-3" @click="download">Export</a>
      <b-modal v-model="show" @hidden="resetModal">
        <template #modal-header>
          <h5> {{ isEdit ? 'Edit Product' : 'Create Product' }}</h5>
          <button type="button" aria-label="Close" class="close" @click="resetModal">×</button>
        </template>
        <form ref="form" @submit.stop.prevent="isEdit ? update() : store()">
          <b-form-group label="Name :" label-for="name" label-cols-sm="3" label-align-sm="right">
            <b-form-input id="name"  v-model="product.name"></b-form-input>
              <div v-if="errorMessage">
                <span class="text-danger" v-for="error in errors.name" :key="error">{{ error }}</span>
              </div>
          </b-form-group>
          <b-form-group label="Description :" label-for="description" label-cols-sm="3" label-align-sm="right">
            <b-form-input id="description" v-model="product.description"></b-form-input>
             <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.description" :key="error">{{ error }}</span>
          </div>
          </b-form-group>
          <b-form-group label="Price :" label-for="price" label-cols-sm="3" label-align-sm="right">
            <b-form-input id="price" v-model="product.price"></b-form-input>
             <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.price" :key="error">{{ error }}</span>
          </div>
          </b-form-group>
          <b-form-group label="Category :" label-cols-sm="3" label-align-sm="right">
            <div>
              <b-form-select v-model="product.mainCategory">
                <b-form-select-option :value="null">Please select category</b-form-select-option>
                <b-form-select-option v-show="category.length != 0" v-for="category in categories" :key="category.id" :value="category.name">{{ category.name }}</b-form-select-option>
              </b-form-select>
              <div v-if="errorMessage">
                <span class="text-danger" v-for="error in errors.mainCategory" :key="error">{{ error }}</span>
              </div>
            </div>
          </b-form-group>
          <b-form-group label="SubCategory :" label-cols-sm="3" label-align-sm="right" v-show="product.mainCategory">
            <div v-for="category in categories" :key="category.id">
              <b-form-select v-model="product.categories" v-show="category.length != 0" v-if="category.name == product.mainCategory">
                <b-form-select-option :value="[]">Please select sub category</b-form-select-option>
                <b-form-select-option v-for="subCat in category.category" :key="subCat.id" :value="[subCat.name]">{{subCat.name}}</b-form-select-option>
              </b-form-select>
            </div>
          </b-form-group>
          <hr>
          <b-button type="submit" variant="primary" class="float-right">{{ isEdit ? 'Update' : 'Create' }}</b-button>
          <b-button variant="dark" class="float-right mr-3" @click="resetModal">Close</b-button>
        </form>
        <template #modal-footer>
          <div class="w-100" style="display: none;">
          </div>
        </template>
      </b-modal>
    </div>
    <table class="table">
      <tr>
        <th>Main Category</th>
        <th>Sub Category</th>
        <th>Product Name</th>
        <th>Product Description</th>
        <th>Product Price</th>
      </tr>

      <tr v-for="category in categories" :key="category.id" v-show="category.length != 0">
        <td>
          {{ category.name }}
        </td>
        <td>
          
          <div v-for="subCat in category.category" :key="subCat.id" class="mb-3" v-show="subCat.product.length">
            <div v-if="subCat.name == category.name">
              ---
            </div>
            <div v-else>
              {{subCat.name}}
            </div>
            <div v-for="length in subCat.product.length" :key="length" class="mb-3">
              <br v-if="length > 1">
            </div>
          </div>
        </td>
        <td>
          <div v-for="child in category.category" :key="child.id">
            <div v-for="product in child.product" :key="product.id" class="mb-3">
              {{product.name}}
            </div>
          </div>
        </td>
        <td>
          <div v-for="child in category.category" :key="child.id">
            <div v-for="product in child.product" :key="product.id" class="mb-3">
              {{product.description}}
            </div>
          </div>
        </td>
        <td>
          <div v-for="child in category.category" :key="child.id">
            <div v-for="product in child.product" :key="product.id" class="mb-3">
              {{product.price}}
            </div>
          </div>
        </td>
        <td>
          <div v-for="child in category.category" :key="child.id">
            <div v-for="product in child.product" :key="product.id">
              <b-button @click="edit(category,child, product)" size="sm" class="mb-2">Update</b-button>
              <b-button @click="destroy(product.id)" variant="danger" size="sm" class="mb-2">Delete</b-button>
            </div>
          </div>
        </td>
        
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  data(){
    return {
      categories: [],
      category: {
        id: '',
        name: '',
        parent_id: '',
        sub_id: '',
        sub_parent_id: '',
        sub_name: ''
      },

      product: {
        id: '',
        name: '',
        description: '',
        price: '',
        mainCategory: null,
        categories: [],
        pivot: ''
      },
      show: false,
      showCat: false,
      subCat: false,
      isEdit: false,
      url: '',
      errors: [],
      errorMessage : false
    }
  },
  methods: {
    createCategory()
    {
      this.showCat =true
      this.isEdit = false
      this.errorMessage = false
    },
    storeCat(){
      this.$axios.post('/category', this.category, this.subCategory)
      .then(response => {
        console.log(response.data)
        this.subCat = true
      
        this.errorMessage = false
        this.$nuxt.refresh()
      })
      .catch(error => {
        this.errors = error.response.data.errors
        this.errorMessage = true
      })
    },
    create() {
      this.show = true
      this.isEdit = false
      this.errorMessage = false
    },
    store() {
      this.$axios.post('/products', this.product)
        .then(response => {
          this.show = false
          this.errorMessage = false
          this.$nuxt.refresh()
        } )
        .catch(error => {
          this.errors = error.response.data.errors
          this.errorMessage = true
        })
    },
    resetModal() {
      this.show = false
      this.showCat = false
      this.category.id = this.category.sub_cat = this.category.name = ''
      this.product.name = this.product.description = this.product.price = ''
      this.product.mainCategory = null,
      this.product.categories = []
    },
    edit(category,child, product) {
      this.product.mainCategory = category.name
      this.product.categories = [child.name]
      this.product.id = product.id
      this.product.name = product.name
      this.product.description = product.description
      this.product.price = product.price
      this.isEdit = true
      this.show = true
      
      
    },
    update() {
      this.$axios.put('/products/' + this.product.id, this.product)
        .then(response => {
          this.show = false
          this.errorMessage = false
          this.$nuxt.refresh()
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.errorMessage = true
        })
    },
    destroy(id) {
      this.$bvModal.msgBoxConfirm('Are you Sure to Delete.', {
        title: 'Please Confirm',
        size: 'sm',
        buttonSize: 'sm',
        okVariant: 'danger',
        okTitle: 'YES',
        cancelTitle: 'NO',
        footerClass: 'p-2',
        hideHeaderClose: false,
        centered: true
      })
        .then(value => {
          if (value == true) {
            this.$axios.delete('/products/' + id)
            .then(response => this.$nuxt.refresh())
          }
        })
    },
    download(){
      this.url = process.env.baseURL+'/export';
    },
  },

  async fetch() {
    this.categories = await fetch(process.env.baseURL+'/category').then( response => response.json())
  }

}
</script>

<style>
.modal-footer {
  border: none !important;
}
</style>
