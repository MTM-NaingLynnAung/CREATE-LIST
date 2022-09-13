<template>
  <div class="container mt-5">

     <div @keyup="view" class="float-right d-flex">
       <a :href="url" class="btn btn-dark mr-3 float-right" @click="download">Export</a>
        <input type="search" class="form-control" v-model="search" placeholder="Search ... ">
      </div>
    <b-button @click="create" variant="primary">Create</b-button>

    <b-modal v-model="show" title="Create Category" @hidden="resetModal">
      <template #modal-header>
        <h5> {{ isEdit ? 'Edit Category' : 'Create Category' }}</h5>
        <button type="button" aria-label="Close" class="close" @click="resetModal">×</button>
      </template>
      <form ref="form" @submit.stop.prevent="isEdit ? update() : store()">
        <b-form-group label="Category " label-cols-sm="3" label-align-sm="right">
          <b-form-input id="name" v-model="category.name"></b-form-input>
          <div v-if="errorMessage">
            <span class="text-danger" v-for="error in errors.name" :key="error">{{ error }}</span>
          </div>
        </b-form-group>
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
        <th>ID</th>
        <th>Category Name</th>
      </tr>
      <tr v-for="category in categories" :key="category.id">
        <td>{{ category.id }}</td>
        <td>{{ category.name }}</td>
        <td>
           <b-button variant="success" size="sm" @click="edit(category)">Update</b-button>
          <b-button variant="danger" size="sm" @click="destroy(category.id)">Delete</b-button>
        </td>
      </tr>
    </table>
    <b-pagination
    v-show="currentPage"
      v-model="currentPage"
      :total-rows="rows"
      :per-page="perPage"
      aria-controls="my-table"
      @input="paginate(currentPage)"
    ></b-pagination>
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
      },
      search: '',
      currentPage: null,
      perPage: null,
      rows: null,
      show: false,
      url: '',
      isEdit: false,
      errors: [],
      errorMessage: false
    }
  },
  methods: {
    view(page = 1){
      this.$axios.get(`/category?page=${page}&search=${this.search}`)
      .then(response => {
        this.categories = response.data.data
        this.currentPage = response.data.current_page
        this.rows = response.data.total
        this.perPage = response.data.per_page
      })
    },
    paginate(page){
      this.$axios.get('/category?page='+ page)
      .then(response => this.categories = response.data.data)
    },
    create() {
      this.show = true
      this.isEdit = false
      this.errorMessage = false
    },
    store() {
      this.$axios.post('/category', this.category)
        .then(response => {
          this.errorMessage = false
          this.show = false
          this.view()
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.errorMessage = true
        })
    },
    closeModal() {
      this.show = false
    },
    
    resetModal() {
      this.show = false
      this.category.id = this.category.name = ''
      this.isEdit = false
    },
    edit(category) {
      this.category.id = category.id
      this.category.name = category.name
      this.show = true
      this.isEdit = true
    },
    update() {
      this.$axios.put('/category/' + this.category.id, this.category)
        .then(response => {
          this.show = false
          this.view()
          this.errorMessage = false
        })
        .catch(error => {
          console.log(error)
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
            this.$axios.delete('/category/' + id)
              .then(response => {
                this.view()
                this.show = false
              })
          }
        })
    },
    download(){
      this.url = process.env.baseURL + `/export`;
      console.log(this.url);
    }

  },
  mounted() {
    this.view();
  }

}
</script>

<style>
.modal-footer {
  border: none !important;
}
</style>
