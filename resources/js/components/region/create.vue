 <template>
    <div>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb mt-3 bg-white shadow">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Region / Insert</li>
        </ol>
        <!-- Icon Cards-->
       <div class="row ml-3 mr-3" >
         <div class="card col-lg-12 shadow" style="padding: 0;">
          <div class="card-header text-dark" style="font-size: 20px; font-weight: 700;">
            <i class="fas fa-chart-area"></i>
            Region Insert
            <router-link to="/region" class="btn btn-success"
            style="border-radius: 20px" id="add_new"> All Region</router-link>
          </div>

          <div class="card-body">
            <form @submit.prevent="regionInsert">
                <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-12">
	               	<div class="form-group">
				       <label for="Textarea1">Region Of Expense</label>
				       <textarea class="form-control" id="Textarea1"  v-model="form.region" required placeholder="EnterRegion"></textarea>
				       <small class="text-danger" v-if="errors.region">{{ errors.region[0] }}</small>
				     </div>
	               </div>
	               <div class="col-lg-12">
	               	<div class="form-label-group">
                      <label for="firstName">Town Amount</label>
	                  <input type="text" v-model="form.town" class="form-control"  placeholder="Enter town">
	                  <small class="text-danger" v-if="errors.town">{{ errors.town[0] }}</small>
	                </div>
	               </div>
                    <div class="col-lg-12">
	               	<div class="form-label-group">
                      <label for="firstName">Country Amount</label>
	                  <input type="text" v-model="form.country" class="form-control"  placeholder="Enter country">
	                  <small class="text-danger" v-if="errors.country">{{ errors.country[0] }}</small>
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
        			region :null,
        			town:null,
        			country:null,
        		},
        		errors:{},
        	}
        },
        methods:{
        	regionInsert(){
        		axios.post('/lab/region/add/',this.form,{headers:{
                Authorization: 'Bearer '+sessionStorage.getItem('token')
            }})
        		.then((response) => {
                    console.log(response.data.data)
        			this.$router.push({ name: 'region' })
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
                }
              )
        	},
        }
    }
</script>


<style>
#add_new{
	float: right;
}
</style>
