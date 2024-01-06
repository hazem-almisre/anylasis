<template>
	<div>
		<!-- Breadcrumbs-->
		<ol class="breadcrumb mt-3 bg-white shadow">		<!--------f-------->
			<li class="breadcrumb-item">
				<a href="#">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">Lab / Add</li>
		</ol>

		<!-- Icon Cards-->
		<div class="row ml-3 mr-3">
			<div class="card col-12 shadow" style="padding: 0;">	    <!--------f------->
				<div class="card-header text-white bg-dark" style="font-size: 20px; font-weight: 700;">  <!------f----->
					<i class="fas fa-chart-area"></i>
					Lab Insert
					<router-link to="/category" class="btn btn-success"
                    style="
                        border-radius: 20px;
                    " id="add_new"> All Labs</router-link>  <!----------->
				</div>

				<div class="card-body">
					<form @submit.prevent="employeeInsert" enctype="multipart/form-data" >	<!------------------------>
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
                            <div class="col-md-12">
                            <div class="form-group">
                            <label for="Textarea1">Description Of labs</label>
                            <textarea class="form-control" id="Textarea1"  v-model="form.description" required placeholder="Enter Description"></textarea>
                            <small class="text-danger" v-if="errors.description">{{ errors.description[0] }}</small>
                            </div>
                            </div>
                   		</div>
						</div>
						<div class="form-group">
							<div class="form-row align-items-end">
								<div class="col-md-4">
									<div class="form-label-group">
										<label for="Address">Address</label>
										<input type="text" v-model="form.address" class="form-control" required placeholder="Enter Address">
										<small class="text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
									</div>
								</div>
                                <div class="col-md-4">
									<div class="form-label-group">
                                    <label for="select">Choose Region</label>
                                    <select class="form-select" id="select" v-model="region"  aria-label="Default select example">
                                    <option v-for="labLocation in labLocations " :key="labLocation.labLocationId" :value="{ key:labLocation.labLocationId,value:labLocation.region }">{{ labLocation.region }}</option>
                                    </select>
										<small class="text-danger" v-if="errors.region">{{ errors.region[0] }}</small>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-label-group">
										<label for="ownerName">OwnerName</label>
										<input type="text" id="ownerName" v-model="form.ownerName" class="form-control" required placeholder="Enter ownerName">
										<small class="text-danger" v-if="errors.ownerName">{{ errors.ownerName[0] }}</small>
									</div>
								</div>
							</div>
						</div>
                        <div class="form-group">
                            <div class="form-row">
                                 <div class="col-md-6">
                                <div class="form-label-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" v-model="form.password" class="form-control" required placeholder="Enter password">
                                    <small class="text-danger" v-if="errors.password">{{ errors.password[0] }}</small>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-label-group">
                                    <label for="phoneEnter">PhoneEnter</label>
                                    <input type="phoneEnter" id="phoneEnter" v-model="form.phoneEnter" class="form-control" required placeholder="Enter phoneEnter">
                                    <small class="text-danger" v-if="errors.phoneEnter">{{ errors.phoneEnter[0] }}</small>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-5">
                                    <div class="form-label-group">
                                        <input type="file" class="btn btn-info" @change="onFileselected">   <!----------------->
                                        <small class="text-danger" v-if="errors.photo">{{ errors.photo[0] }}</small>
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
        },
		data(){
			return{
				form:{
					name :null,
					phone :null,
                    password:null,
					ownerName:null,
					address:null,
					photo :null,
					phoneEnter:null,
                    region:null,
                    labLocationId:null,
                    isActive:false,
                    description:null
				},
                labLocations:[],
                region:{
                    key:null,
                    value:null,
                },
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
                this.form.region=this.region.value
                this.form.labLocationId=this.region.key
                const formDate=new FormData();
                Object.entries(this.form).forEach(([key, value]) => {
                    console.log(key+" "+value);
                    if(value !== null){
                    formDate.append(key, value);
                    }
                });
				axios.post('/lab/admin/add/lab',formDate,{headers : {
                'Content-Type': 'multipart/form-data',
                'Authorization': 'Bearer '+sessionStorage.getItem('token')
                }})  //resource_route|api.php|post_method+route= go>Controller>Store()
				.then(() => {
					this.$router.push({ name: 'category' })   //(index.vue)all-employee vue page e jabe
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
                axios.get('/lab/admin/get/regions',{headers:{
                Authorization: 'Bearer '+sessionStorage.getItem('token')
            }})
                .then((response)=>{
                    console.log(response.data)
                    this.labLocations=response.data.data.result
                    }
                    )
                .catch((error) => {
                    console.log(error);
                    this.errors = error.data.data;
                })
            },
            getLocationId(id)
            {
                console.log(id)
                this.form.lablocationId=id;
            }
		}
	}
</script>


<style>
	#add_new {
		float: right;
	}
</style>
