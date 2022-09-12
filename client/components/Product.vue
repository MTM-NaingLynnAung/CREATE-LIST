<template>
  <div class="container">
    <table class="table">
      <tr>
        <th>Main Category</th>
        <th>Sub Category</th>
        <th>Product Name</th>
        <th>Product Price</th>
      </tr>
     
      <tr v-for="product in products" :key="product.id">
        <td>{{ product.name }}</td>
        <td>
          <div v-for="category in product" :key="category.id">
            {{category}}
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
      products: [],
    }
  },
  method(){

  },
  mounted(){
    this.$axios.get('http://127.0.0.1:8000/api/category')
    .then(response => {
      this.products = response.data.data
      console.log(this.products);
    } )
    .catch(error => console.log(error))

  },
  // computed: {
  //   all(){
  //     return this.products.map((product) => {
  //      return this.categories.map( category => {
  //         return {
  //           product: product,
  //           category: category
  //         }
  //      } )
  //     })
  //   }
  // }
}
</script>

<style>

</style>
