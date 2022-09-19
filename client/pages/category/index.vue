<template>
  <client-only>
    <div class="container mt-5">
      <h3 class="mb-5">Category List Count : {{ rows }}</h3>
    <NuxtLink to="/category/create" class="btn btn-primary">Create</NuxtLink>
    <div class="float-right">
      <form class="d-flex" @submit.prevent = "view">
        <input type="search" class="form-control" v-model="search" placeholder="Search ... ">
      </form>
    </div>
     <table class="table mt-3">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Action</th>
      </tr>
      <tr v-for="category in categories" :key="category.id">
        <td>{{ category.id }}</td>
        <td>{{ category.name }}</td>
        <td>
          <NuxtLink :to="`/category/edit/${category.id}`" class="btn btn-info btn-sm">Edit</NuxtLink>
          <b-button variant="danger" size="sm" @click="destroy(category.id)">Delete</b-button>
        </td>
      </tr>
    </table>
    <b-pagination 
      v-show="rows > perPage"
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
      categories: [],
      category: {
        id: '',
        name: '',
      },
      search: '',
      currentPage: null,
      perPage: null,
      rows: null,
    }
  },
  methods: {
    view(page = 1){
      this.$axios.get(`/api/category?page=${page}&search=${this.search}`)
        .then(response => {
          this.categories = response.data.data
          this.currentPage = response.data.current_page
          this.rows = response.data.total
          this.perPage = response.data.per_page
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
            this.$axios.delete('/api/category/' + id)
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
