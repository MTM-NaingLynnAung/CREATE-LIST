<template>
  <div class="container mt-5">
    <NuxtLink to="/category/create" class="btn btn-primary">Create</NuxtLink>
    <div class="float-right" @click="view">
      <form class="d-flex" @submit.prevent = "view">
        <input type="search" class="form-control" v-model="search" placeholder="Search ... ">
      </form>
    </div>
     <table class="table">
      <tr>
        <th>ID</th>
        <th>Category Name</th>
      </tr>
      <tr v-for="category in categories" :key="category.id">
        <td>{{ category.id }}</td>
        <td>{{ category.name }}</td>
        <td>
          <NuxtLink :to="`/category/edit/${category.id}`" class="btn btn-info btn-sm">Update</NuxtLink>
          <b-button variant="danger" size="sm" @click="destroy(category.id)">Delete</b-button>
        </td>
      </tr>
    </table>
    <b-pagination 
      v-model="currentPage" 
      :total-rows="rows" 
      :per-page="perPage"
      @input="paginate(currentPage)">
  </b-pagination>
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
      },
      search: '',
      currentPage: null,
      perPage: null,
      rows: null,
    }
  },
  methods: {
    view(page = 1){
      this.$axios.get(`/category?page=${page}&search=${this.search}`)
        .then(response => {
        console.log(page)
        this.categories = response.data.data
        console.log(this.categories)
          this.currentPage = response.data.current_page
        console.log(this.currentPage)
        this.rows = response.data.total
        this.perPage = response.data.per_page
      })
    },
    paginate(page) {
      this.$axios.get('/category?page=' + page)
        .then(response => {
          this.categories = response.data.data
        })
    },
     edit(category) {
      this.category.id = category.id
      this.category.name = category.name
      this.isEdit = true
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
            this.$axios.delete('/category/' + id)
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
