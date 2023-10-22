<template>
    <div>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb mt-3 bg-white shadow">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">All Product</li>
        </ol>
        <!-- Icon Cards-->
        <div class="row card  ml-3  shadow mr-3 mb-3">
            <div class="card-header text-dark" style="font-size: 20px; font-weight:700;">
                <i class="fas fa-chart-area"></i>
                All Product
                <router-link to="/store-product" class="btn btn-success"
            style="border-radius: 20px" id="add_new"> Add New</router-link>
            </div>
            <div class="card-body pt-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <label class="d-inline">Search : </label>
                        <input type="text" v-model="searchTerm" class="form-control d-inline" style="width:200px;" placeholder="Search by name"><br><br>
                        <table class="table table-bordered table-striped table-hover border-white" id="" width="100%" cellspacing="0">

                            <thead>
                            <tr class="bg-dark text-white">
                                <th>Name</th>
                                <th>Price</th>
                                <th>FirstPrice</th>
                                <th>SecondPrice</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="product in filtersearch" :key="product.id">
                                <td>{{ product.lable}}</td>
                                <td v-if="product.secondPrice==null">{{ product.firstPrice}}</td>
                                <td v-else>{{ product.secondPrice}}</td>
                                <td>{{ product.firstPrice }}</td>
                                <td>{{ product.secondPrice }}</td>
                                <td>{{ product.description }}</td>
                                <td>
                                    <router-link :to="{name: 'edit-product', params:{id: product.analysisId} }" class="btn btn-sm btn-info">Edit</router-link>
                                    <!-- <router-link :to="'/edit-category/'+category.id" class="btn btn-warning mr-1">Edit</router-link> -->   <!--or-->
                                    <!-- <router-link :to="`/edit-category/${category.id}`" class="btn btn-sm btn-primary text-white">Edit</router-link> -->
                                    <a @click="deleteProduct(product.analysisId)" class="btn btn-sm btn-danger text-white">Delete</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        mounted(){
            if (!User.loggedIn()) {
                this.$router.push({ name:'/' })
            }
        },
        created(){
            this.allProduct();
        },
        data(){
            return{
                products:[],
                searchTerm:'',
            }
        },
        computed:{
            filtersearch(){
                return this.products.filter(product => {
                    //return product.product_name.match(this.searchTerm)
                    return product.lable.toLowerCase().match(this.searchTerm.toLowerCase())
                })
            }
        },
        methods:{
            allProduct(){
                axios.get('/lab/analysis/get/analyses',{headers:{
                Authorization: 'Bearer '+sessionStorage.getItem('token')
            }})
                    .then((response) =>{
                        console.log(response)
                        this.products = response.data.data.result
            }
            )
                    .catch((error)=>{
                    let statusCode = error.response.status
                    if(statusCode == 401){
                        AppStorage.clear()
                        this.$router.push({name:'/'})
                    }
                    else
                    {
                        Notification.error();
                    }
                    })
            },
         deleteProduct(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Delete it!",
      }).then((result) => {
        if (result.value) {
          axios
            .delete("/lab/analysis/delete/"+id,{headers:{
                Authorization: 'Bearer '+sessionStorage.getItem('token')
            }}) //------------delete-------------
            .then((response) => {
                console.log(response.data.data)
              this.products = this.products.filter((product) => {
                return product.analysisId != id;
              });
              Swal.fire("Deleted!", "Your file has been deleted.", "success");
            //    this.$router.push({ name: "category" });
            })
            .catch((error) => {
                    let statusCode = error.response.status
                    if(statusCode == 401){
                        AppStorage.clear()
                        this.$router.push({name:'/'})
                    }
                    else
                    {
                        Notification.error();
                    }
            });

        }
      });
    },
        },
    }
</script>


<style>
    #add_new{
        float: right;
    }
    #em_photo{
        height: 40px;
        width: 40px;
    }
</style>
