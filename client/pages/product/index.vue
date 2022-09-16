<template>
  <client-only>
    <div class="container mt-5">
      <h3 class="mb-5">Product List</h3>
    <NuxtLink to="/product/create" class="btn btn-primary">Create</NuxtLink>
    <div class="float-right">
      <form class="d-flex" @submit.prevent = "view">
        <input type="search" class="form-control" v-model="search" placeholder="Search ... ">
      </form>
    </div>
     <table class="table mt-3">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Price</th>
        <th>Category Name</th>
        <th>Image</th>
        <th>Action</th>
      </tr>
      <tr v-for="product in products" :key="product.id">
        
        <td>{{ product.id }}</td>
        <td>{{ product.name }}</td>
        <td>{{ product.price }}</td>
        <td>
          {{ product.category_name }}
          
        </td>
        <td>
          <img :src="imageUrl(product.image)" alt="" width="70" height="70">
        </td>
        <td>
          <NuxtLink :to="`/product/edit/${product.id}`" class="btn btn-info btn-sm">Edit</NuxtLink>
          <b-button variant="danger" size="sm" @click="destroy(product.id)">Delete</b-button>
        </td>
      </tr>
    </table>
    <b-pagination 
      v-model="currentPage" 
      :total-rows="rows" 
      :per-page="perPage"
      @input="view(currentPage)">
  </b-pagination>
  </div>
  </client-only>
</template>

<script>
export default {
  middleware: 'auth',
  data(){
    return {
      products: [],
      product: {
        id: '',
        name: '',
        price: '',
        category: '',
        category_name: ''
      },
      search: '',
      currentPage: null,
      perPage: null,
      rows: null,
    }
  },
  methods: {
    view(page = 1){
      this.$axios.get(`/api/product?page=${page}&search=${this.search}`)
        .then(response => {
          this.products = response.data.data
          this.currentPage = response.data.meta.current_page
          this.rows = response.data.meta.total
          this.perPage = response.data.meta.per_page
        })
    },
    imageUrl(image){
      return `http://127.0.0.1:8000/storage/${image}`
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
            this.$axios.delete('/api/product/' + id)
              .then(response => {
                this.view()
              })
          }
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
