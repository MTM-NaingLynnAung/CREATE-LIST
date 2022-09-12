<template>
  <div class="container mt-5">


    <b-button @click="createCategory" variant="primary">Create Category</b-button>
    <b-modal v-model="showCat" title="Create Category" @hidden="resetModal">
      <template #modal-header>
        <h5> {{ isEdit ? 'Edit Category' : 'Create Category' }}</h5>
        <button type="button" aria-label="Close" class="close" @click="resetModal">×</button>
      </template>
      <form ref="form" @submit.stop.prevent="isEdit ? updateCat() : storeCat()">
        <b-form-group label="Main Category " label-cols-sm="3" label-align-sm="right" v-show="mainCat">
          <b-form-input id="name" v-model="category.name"></b-form-input>
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.name" :key="error">{{ error }}</span>
          </div>
        </b-form-group>
        <b-form-group label="Sub Category" label-cols-sm="3" label-align-sm="right" v-show="subCat">
          <b-form-input id="name" v-model="category.sub_name"></b-form-input>
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.name" :key="error">{{ error }}</span>
          </div>
        </b-form-group>
        <b-button class="float-left" variant="danger" @click="delCat(category.id)" v-show="isEdit">Delete</b-button>
        <b-button type="submit" variant="primary" class="float-right" v-show="subCat == false">{{ isEdit ? 'Update' : 'Create' }}</b-button>
        <b-button type="submit" variant="primary" class="float-right" v-show="subCat" @click="closeModal">{{ isEdit ? 'Update' : 'Create' }}</b-button>
        <b-button variant="dark" class="float-right mr-3" @click="resetModal">Close</b-button>
      </form>
      <template #modal-footer>
        <div class="w-100" style="display: none;">
        </div>
      </template>
    </b-modal>



    <a :href="url" class="btn btn-dark ml-3 float-right" @click="download">Export</a>
    <b-button @click="create" variant="primary" class="float-right">Create</b-button>
    <b-modal v-model="show" @hidden="resetModal">
      <template #modal-header>
        <h5> {{ isEdit ? 'Edit Product' : 'Create Product' }}</h5>
        <button type="button" aria-label="Close" class="close" @click="resetModal">×</button>
      </template>
      <form ref="form" @submit.stop.prevent="isEdit ? update() : store()">
        <b-form-group label="Name :" label-for="name" label-cols-sm="3" label-align-sm="right">
          <b-form-input id="name" v-model="product.name"></b-form-input>
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

          <div v-for="subCat in category.category" :key="subCat.id" class="mb-3" >
            <div v-if="subCat.name == category.name">
              ---
            </div>
            <div v-else>
              <a href="javascript:void(0)" @click="editCat(subCat)">{{ subCat.name }}</a>
              <!--<b-button @click="editCat(subCat)" size="sm" class="mb-2">Update</b-button>-->
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
  data() {
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
      mainCat: false,
      show: false,
      showCat: false,
      subCat: false,
      isEdit: false,
      url: '',
      errors: [],
      errorMessage: false
    }
  },
  methods: {
    createCategory() {
      this.showCat = true
      this.mainCat = true
      this.isEdit = false
      this.errorMessage = false
    },
    storeCat() {
      this.$axios.post('/category', this.category)
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
    closeModal() {
      this.show = false
      this.showCat = false
      this.subCat = false
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
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.errorMessage = true
        })
    },
    resetModal() {
      this.show = false
      this.showCat = false
      this.category.id = this.category.sub_name = this.category.name = ''
      this.product.name = this.product.description = this.product.price = ''
      this.product.mainCategory = null,
      this.product.categories = []
      this.isEdit = false
    },
    editCat(subCat) {
      this.category.id = subCat.id
      this.category.sub_name = subCat.name
      this.showCat = true
      this.mainCat = false
      this.subCat = true
      this.isEdit = true
    },
    updateCat() {
      this.$axios.put('/category/' + this.category.id, this.category)
        .then(response => {
          this.showCat = false
          this.$nuxt.refresh()
          this.errorMessage = false
        })
        .catch(error => {
          console.log(error)
          this.errors = error.response.data.errors
          this.errorMessage = true
      })
    },
    delCat(id) {
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
            this.$axios.delete('/category/' + id)
              .then(response => {
                this.showCat = false
                this.$nuxt.refresh()
              })
          }
        })
    },
    edit(category, child, product) {
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
    download() {
      this.url = process.env.baseURL + '/export';
    },
  },

  async fetch() {
    this.categories = await fetch(process.env.baseURL + '/category').then(response => response.json())
  }

}
</script>

<style>
.modal-footer {
  border: none !important;
}
</style>
