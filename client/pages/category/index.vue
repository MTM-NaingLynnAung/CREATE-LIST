<template>
  <div class="container mt-5">
    <NuxtLink to="/category/create" class="btn btn-primary">Create</NuxtLink>
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
    }
  },
  methods: {
    view(){
      this.$axios.get(`/category`)
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
