<template>
	<div>
		<!-- Breadcrumbs-->
		<ol class="breadcrumb mt-3 bg-white shadow">		<!--------f-------->
			<li class="breadcrumb-item">
				<a href="#">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Employee / Add</li>
		</ol>

		<!-- Icon Cards-->
		<div class="row ml-3 mr-3">
			<div class="card col-12 shadow" style="padding: 0;">	    <!--------f------->
				<div class="card-header text-white bg-dark" style="font-size: 20px; font-weight: 700;">  <!------f----->
					<i class="fas fa-chart-area"></i>
					Employee Insert
					<router-link to="/employee" class="btn btn-success"
                    style="
                        border-radius: 20px;
                    " id="add_new"> All Employee</router-link>  <!----------->
				</div>

				<div class="card-body">
					<form @submit.prevent="employeeInsert" enctype="multipart/form-data" name="fileinfo">	<!------------------------>
						<div class="form-group">
							<div class="form-row">
								<div class="col-md-6">
									<div class="form-label-group">
										<label for="firstName">Full Name</label>
										<input type="text" id="firstName" v-model="form.name" class="form-control" required placeholder="Enter Name">
										<small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
									</div>
								</div>
                                <div class="col-md-6">
									<div class="form-label-group">
										<label for="phone">Phone Number</label>
										<input type="text" id="phone" v-model="form.phone" class="form-control" required placeholder="Enter Phone Number">
										<small class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="form-row">
								<div class="col-md-6">
									<div class="form-label-group">
										<label for="firstName">Address</label>
										<input type="text" v-model="form.address" class="form-control" required placeholder="Enter Address">
										<small class="text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-label-group">
										<label for="ratio">Ratio</label>
										<input type="text" id="ratio" v-model="form.ratio" class="form-control" required placeholder="Enter ratio">
										<small class="text-danger" v-if="errors.ratio">{{ errors.ratio[0] }}</small>
									</div>
								</div>
							</div>
						</div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-6">
                                <div class="form-label-group">
                                    <label for="password">password</label>
                                    <input type="password" id="password" v-model="form.password" class="form-control" required placeholder="Enter password">
                                    <small class="text-danger" v-if="errors.password">{{ errors.password[0] }}</small>
                                </div>
                                </div>
                                <div class="col-6">
                                <div class="form-label-group">
                                    <label for="select">Choose multi Region with CTRL+Click</label>
                                    <select class="form-select" size="2" multiple aria-label="multiple select example" v-model="labLocationIds">
                                    <option v-for="labLocation in form.labLocationIds " :key="labLocation.labLocationId" :value="labLocation.labLocationId">{{ labLocation.region }}</option>
                                    </select>
										<small class="text-danger" v-if="errors.region">{{ errors.region[0] }}</small>
									</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-6">
                                <div class="form-label-group">
                                    <label for="select">Choose multi Labs with CTRL+Click</label>
                                    <select class="form-select" size="2" multiple aria-label="multiple select example" v-model="labs">
                                    <option v-for="lab in form.labs " :key="lab.labId" :value="lab.labId">{{ lab.name }}</option>
                                    </select>
										<small class="text-danger" v-if="errors.region">{{ errors.region[0] }}</small>
									</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-5">
                                    <div class="form-label-group">
                                        <input type="file" class="btn btn-info" @change="onFileselected">   <!----------------->
                                        <small class="text-danger" v-if="errors.image">{{ errors.image[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <img v-if="image!=''" :src="image" style="height:40px; width: 40px;">	<!------------------>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" v-model="form.isActive" role="switch" id="flexSwitchCheckDefault">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Activie</label>
                                    </div>
                                <h6 v-html="form.isActive"></h6>
								</div>
                            </div>
                        </div>
						<button type="submit" class="btn btn-success">Submit</button>
					</form>
				</div>
				<div class="card-footer small text-muted">Labs App</div>
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
            this.getRegions();
			this.getLabs();
        },
		data(){
			return{

				form:{
					name :null,
                    password:null,
					ratio:null,
					address:null,
					photo :null,
					phone:null,
                    isActive:false,
                    labLocationIds:[],
                    labs:[],
				},
                formData:null,
                labLocationIds:[],
                labs:[],
                image:'',
				errors:{}
			}
		},

		methods:{
			onFileselected(event){        //click korlei ai 'event' er vitor pic er sob details chole asbe
				//console.log(event)
                this.form.photo=event.target.files[0];
				let file=event.target.files[0];      //now,File's(name,size,type) available in variable 'file'
				if (file.size > 1048770) {           //made condition: file will less than 1MB
				    Notification.image_validation()     //used 'Noti'
				}else{
                    let reader = new FileReader();     //created new instance
                    reader.onload = event => {
                        this.image = event.target.result   //storing/taking pic's extention in 'photo'
                        console.log(event.target.result);
                    };
                    reader.readAsDataURL(file);
				}
			},
			employeeInsert(){
                this.form.labLocationIds= this.labLocationIds
                this.form.labs= this.labs
                console.log(this.form.labLocationIds)
                const formDate=new FormData();
                Object.entries(this.form).forEach(([key, value]) => {
                    console.log(key+" "+value);
                    if(value !== null){
                    formDate.append(key, value);
                    }
                });
				axios.post('/nurse/web/add/nurse',formDate,{headers : {
                'Content-Type': 'multipart/form-data',
                Authorization: 'Bearer '+sessionStorage.getItem('token')
                }})  //resource_route|api.php|post_method+route= go>Controller>Store()
				.then((response) => {
                    console.log(response.data)
					this.$router.push({ name: 'employee' })   //(index.vue)all-employee vue page e jabe
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

            getRegions(){
                axios.get('/nurse/web/get/regions',{headers:{
                Authorization: 'Bearer '+sessionStorage.getItem('token')
            }})
                .then((response)=>{
                    console.log(response.data)
                    this.form.labLocationIds=response.data.data.result
                    }
                    )
                .catch((error) => {
                    console.log(error);
                    this.errors = error.data.data;
                })
            },

            getLabs(){
            axios.get('user/labs/getByRegion/hazem')
                .then((response)=>{
                    console.log(response.data.data.result.labs)
                    this.form.labs=response.data.data.result[0].labs
                }
                    )
                .catch((error) => {
                    console.log(error);
                    this.errors = error.data.data;
                })
            },
		}
	}
</script>


<style>
	#add_new {
		float: right;
	}
</style>
