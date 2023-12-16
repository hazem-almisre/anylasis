<template>
    <div>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb mt-3 bg-white shadow">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Offer</li>
        </ol>
        <!-- Icon Cards-->
        <div class="row  ml-3 mr-3">
            <div class="card col-lg-12  shadow" style="padding:0">
                <div class="card-header text-dark" style="font-size: 20px; font-weight: 700;">
                    <i class="fas fa-chart-area"></i>
                    Offer Insert
                    <router-link to="/supplier" class="btn btn-success"
            style="border-radius: 20px" id="add_new"> All Offer</router-link>    <!----------->
                </div>

                <div class="card-body">
                    <form @submit.prevent="supplierInsert" enctype="multipart/form-data">   <!--------------------->
                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <label>Date End</label>
                                        <input type="date" pattern="\d{4}-\d{2}-\d{2}" v-model="form.dateEnd" class="form-control"  autofocus="autofocus" required="">
                                            <small class="text-danger" v-if="errors.dateEnd">{{ errors.dateEnd[0] }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-label-group">
                                            <label>Count</label>
                                            <input type="text" v-model="form.analysisCount" class="form-control" placeholder="analysisCount" required readonly>
                                            <small class="text-danger" v-if="errors.analysisCount">{{ errors.analysisCount[0] }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <label>Price Befor Offer</label>
                                        <input type="text" v-model="form.priceBeforOffer" class="form-control" required placeholder="Enter price">
                                        <small class="text-danger" v-if="errors.PriceBeforOffer">{{ errors.PriceBeforOffer[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <label>Price After Offer</label>
                                        <input type="text" v-model="form.priceAfterOffer" class="form-control" required placeholder="Enter price">
                                        <small class="text-danger" v-if="errors.priceAfterOffer">{{ errors.priceAfterOffer[0] }}</small>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                <div class="col-md-12" >
                                    <div class="form-label-group" >
                                    <h2>Choose Analysis</h2>
                                    <div style="height:100px;overflow-y : scroll;">
                                    <div class="list-group  bg-secondary">
                                    <label  class="list-group-item"  v-for="analy in analysis" :key="analy.analysisId">
                                        <input class="form-check-input me-1"  type="checkbox"  :value="analy.analysisId" v-model="form.analysisIds">
                                        {{ analy.lable }}
                                    </label>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="file" class="btn btn-info" @change="onFileselected">   <!----------------->
                                        <small class="text-danger" v-if="errors.image">{{ errors.image[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <img v-if="image!=''" :src="image" style="height:40px; width: 40px;">	<!------------------>
                                </div>
                            </div>
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        created(){
           this.getAnalysis()
        },
        mounted(){
            if (!User.loggedIn()) {
                this.$router.push({ name:'/' })
            }
        },
        data(){
            return{
                form:{
                    dateEnd :null,
                    priceAfterOffer :null,
                    priceBeforOffer:null,
                    analysisIds:[],
                    photo :null,
                    analysisCount:0
                },
                analysis:[],
                image:'',
                errors:{},
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
            supplierInsert(){
                console.log(this.form)
                const formDate=new FormData();
                console.log(formDate);
                Object.entries(this.form).forEach(([key, value]) => {
                    console.log(key+" "+value);
                    formDate.append(key, value);
                });
                axios.post('/lab/offer/add',formDate,{headers:{
                    Authorization: 'Bearer '+sessionStorage.getItem('token')
                    }})
                    .then((response) => {
                        console.log(response.data)
                        this.$router.push({ name: 'supplier' })
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
            getAnalysis(){
                    axios.get('lab/analysis/get/analyses',{headers:{
                    Authorization: 'Bearer '+sessionStorage.getItem('token')
                    }})
                    .then((response) => {
                        console.log(response.data)
                        this.analysis=response.data.data.result;
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
            // chooseAnalysis(analysisId,event){
            //     console.log(event.preventDefault())
            //     if(event.checked){
            //         this.form.analysisIds.push(parseInt(analysisId))
            //         this.form.analysisCount++;
            //         console.log(this.form.analysisCount)
            //     }
            //     else
            //     {
            //         this.form.analysisIds.pop(parseInt(analysisId))
            //         this.form.analysisCount--;
            //     }

            // }
        }
    }
</script>


<style>
    #add_new{
        float: right;
    }
</style>
