<template>
  <div class="container mt-5">
    <div class="float-right mr-5">

      <b-button @click="create" variant="primary">Create</b-button>
      <b-modal v-model="show" title="Create Product" @hidden="resetModal">
        <template #modal-header>
          <h5> {{ isEdit ? 'Edit Product' : 'Create Product' }}</h5>
          <button type="button" aria-label="Close" class="close" @click="resetModal">×</button>
        </template>
        <form ref="form" @submit.stop.prevent="isEdit ? update() : store()">
          <b-form-group label="Name :" label-for="name" label-cols-sm="3" label-align-sm="right">
            <b-form-input id="name"  v-model="product.name"></b-form-input>
          </b-form-group>
          <b-form-group label="Description :" label-for="description" label-cols-sm="3" label-align-sm="right">
            <b-form-input id="description" v-model="product.description"></b-form-input>
          </b-form-group>
          <b-form-group label="Price :" label-for="price" label-cols-sm="3" label-align-sm="right">
            <b-form-input id="price" v-model="product.price"></b-form-input>
          </b-form-group>
          <b-form-group label="Category :" label-cols-sm="3" label-align-sm="right">
            <div>
              <b-form-select v-model="product.mainCategory">
                <b-form-select-option :value="null">Please select category</b-form-select-option>
                <b-form-select-option v-show="category.length != 0" v-for="category in categories" :key="category.id" :value="category.name">{{ category.name }}</b-form-select-option>
              </b-form-select>
            </div>
          </b-form-group>
          <b-form-group label="SubCategory :" label-cols-sm="3" label-align-sm="right" v-show="product.mainCategory">
            <div v-for="category in categories" :key="category.id">
              <b-form-select v-model="product.categories" v-show="category.length != 0" v-if="category.name == product.mainCategory">
                <b-form-select-option :value="[]">Please select sub category</b-form-select-option>
                <b-form-select-option v-for="subCat in category.category" :key="subCat.id" :value="[subCat.name]" v-show="subCat.name != category.name">{{subCat.name}}</b-form-select-option>
              </b-form-select>
            </div>
          </b-form-group>
          <hr>
          <b-button type="submit" variant="primary" class="float-right">{{ isEdit ? 'Update' : 'Create' }}</b-button>
          <b-button variant="dark" class="float-right mr-3" @click="resetModal">Close</b-button>
        </form>
        <template #modal-footer>
          <div class="w-100" style="display: none;">
            <p class="float-left">Modal Footer Content</p>
            
            <b-button variant="primary" size="sm" class="float-right" @click="show=false">
              Close
            </b-button>
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
        <td>{{ category.name }}</td>
        <td>
          <div v-for="subCat in category.category" :key="subCat.id" v-show="category.name != subCat.name">
              {{subCat.name}}
          </div>
        </td>
        <td>
          <div v-for="child in category.category" :key="category.id">
            <div v-for="product in child.product" :key="product.id">
              {{product.name}}
            </div>
          </div>
        </td>
        <td>
          <div v-for="child in category.category" :key="category.id">
            <div v-for="product in child.product" :key="product.id">
              {{product.description}}
            </div>
          </div>
        </td>
        <td>
          <div v-for="child in category.category" :key="category.id">
            <div v-for="product in child.product" :key="product.id">
              {{product.price}}
            </div>
          </div>
        </td>
        <td>
          <div v-for="child in category.category" :key="category.id">
            <div v-for="product in child.product" :key="product.id">
              <b-button @click="edit(product)" size="sm">Update</b-button>
            </div>
          </div>
        </td>
        <td>
          <div v-for="child in category.category" :key="category.id">
            <div v-for="product in child.product" :key="product.id">
              <b-button @click="destroy(product.id)" variant="danger" size="sm">Delete</b-button>
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
      product: {
        name: '',
        description: '',
        price: '',
        mainCategory: null,
        categories: [],
      },
      show: false,
      isEdit: false,
    }
  },
  methods: {
    create() {
      this.show = true
      this.isEdit = false   
    },
    store() {
      this.$axios.post('/products', this.product)
        .then(response => {
          this.show = false
          this.$nuxt.refresh()
        } )
        .catch(error => console.log(error))
    },
    resetModal() {
      this.show = false
      this.product.name = this.product.description = this.product.price = ''
      this.product.mainCategory = null,
      this.product.categories = []
    },
    edit(product) {
      this.isEdit = true
      this.show = true
      this.product.id = product.id
      this.product.name = product.name
      this.product.description = product.description
      this.product.price = product.price
      this.product.mainCategory = product.mainCategory
      this.product.categories = product.categories
    },
    update() {
      this.$axios.put('/products/' + this.product.id, this.product)
        .then(response => {
          this.show = false
          this.$nuxt.refresh()
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
    }
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
