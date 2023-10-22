<template>
    <div>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb mt-3  bg-white shadow">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Product / Insert</li>
        </ol>
        <!-- Icon Cards-->
        <div class="row mr-3 ml-3">
            <div class="card col-lg-12  shadow mb-3" style="padding:0">
                <div class="card-header text-dark" style="font-size: 20px; font-weight: 700;">
                    <i class="fas fa-chart-area"></i>
                    Product Insert
                    <router-link to="/product" class="btn btn-success"
            style="border-radius: 20px" id="add_new"> All Product</router-link>
                </div>
          <div class="card-body">
            <form @submit.prevent="productInsert">
                <div class="form-group">
	              <div class="form-row">
                    <div class="col-lg-12">
	               	<div class="form-label-group">
                      <label for="firstName">Name</label>
	                  <input type="text" v-model="form.lable" class="form-control"  placeholder="Enter analysis name">
	                  <small class="text-danger" v-if="errors.lable">{{ errors.lable[0] }}</small>
	                </div>
	               </div>
	               <div class="col-md-12">
	               	<div class="form-group">
				       <label for="Textarea1">Description</label>
				       <textarea class="form-control" id="Textarea1"  v-model="form.description" required placeholder="Enter description"></textarea>
				       <small class="text-danger" v-if="errors.description">{{ errors.description[0] }}</small>
				     </div>
	               </div>
	               <div class="col-lg-12">
	               	<div class="form-label-group">
                      <label for="firstName">Price</label>
	                  <input type="text" v-model="form.price" class="form-control"  placeholder="Enter price">
	                  <small class="text-danger" v-if="errors.price">{{ errors.price[0] }}</small>
	                </div>
	               </div>
                    <div class="col-lg-12">
	               	<div class="form-label-group">
                      <label for="firstName">Second Prie</label>
	                  <input type="text" v-model="form.secondPrice" class="form-control"  placeholder="this filed can be empty">
	                  <small class="text-danger" v-if="errors.secondPrice">{{ errors.secondPrice[0] }}</small>
	                </div>
	               </div>
	             </div>
	            </div>
              <button type="submit" class="btn btn-success">Submit</button>
            </form>
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
        data(){
            return{
                form:{
                    lable :'',
                    price :null,
                    description:'',
                    secondPrice:null,
                },
                errors:{},

            }
        },
        methods:{
            productInsert(){
                axios.post('/lab/analysis/add',this.form,{headers:{
                Authorization: 'Bearer '+sessionStorage.getItem('token')
            }})
                    .then((response) => {
                        console.log(response.data.data)
                        this.$router.push({ name: 'product' })
                        Notification.success()
                    })
                    .catch((error) => {
                    let statusCode = error.response.status
                    console.log(statusCode)
                    if(statusCode == 422){
                    console.log(error.response.data);
                    this.errors = error.response.data.data.result;
                    }
                    else if(statusCode == 401){
                        AppStorage.clear()
                        this.$router.push({name:'/'})
                    }
                    else
                    {
                        Notification.error();
                    }
                        })
            },
        },
    }
</script>


<style>
    #add_new{
        float: right;
    }
</style>
