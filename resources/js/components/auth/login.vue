<template>
    <div>
        <div class="container">
<div class="row justify-content-left">
    <div class="col-lg-5 offset-2">
        <div class="card shadow-lg border-primary rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center text-primary font-weight-bold my-3">Login</h3></div>
            <div class="card-body">

                <form @submit.prevent="login">      <!--------------------------------------------->
                    <div class="form-group">
                        <label class="mb-1" for="inputPhoneAddress">Phone</label>
                        <input class="form-control py-4" id="inputphoneAddress" type="phone" placeholder="Enter phone Address" required v-model="form.phone"/>     <!------------------------------------>

                        <small class="text-danger" v-if="errors.phone" style="color:red">{{ errors.phone[0] }}</small>  <!---------->
                    </div>

                    <div class="form-group">
                        <label class="mb-1" for="inputPassword">Password</label>
                        <input class="form-control py-4" id="inputPassword" type="password" v-model="form.password" required placeholder="Enter Password"/>    <!------------------------------------->

                        <small class="text-danger" v-if="errors.password" style="color:red">{{ errors.password[0] }}</small> <!----------->
                    </div>

                    <div class="form-group">
                    <label for="select">You Are</label>
                    <select class="form-select" id="select" v-model="form.socId"  aria-label="Default select example" required>
                    <option value="UserType.user">Admin</option>
                    <option value="UserType.lab">Lab</option>
                    </select>
                        <small class="text-danger" v-if="errors.region">{{ errors.region[0] }}</small>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                            <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                        <router-link to="/forget">Forgot Password?</router-link>
                        <button type="submit" class="btn btn-primary"> Login </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
        </div>
    </div>
</template>


<script>            //-------------------------------------------
    export default {
        created(){                  //--will load created() before others
            if(User.loggedIn()){
                this.$router.push({name : 'home'})      // or, //this.$router.push('/home')
            }
        },

        data(){
            return{
                form:{
                    phone: '',        //--OR-- ''(blank)---
                    password: '',
                    socId:""
                },
                errors:{}
            }
        },
        methods:{
            login(){
                axios.post('/user/mobile/login',this.form)
                //.then(response => console.log(response.data))   //--here,(token+other's_info) situated in 'data' property
                .then((response) => {
                    const result=response.data.data.result
                    console.log(result);
                    if (result.type === 'api') {
                        if(result.role==1)
                        {
                        this.$router.push({name:'home'})
                        Toast.fire({
                        icon: 'success',
                        title: 'Signed in Successfully'
                        })
                        User.responseAfterLogin(result)
                        }
                        else
                        {
                        Toast.fire({
                        icon: 'warning',
                        title: 'I am Sorry you are not Admin'
                        })
                        }
                    }
                    else if(result.type === 'lab'){
                    User.responseAfterLogin(result)
                    this.$router.push({name:'lab'})
                    } 
                    else{
                         Toast.fire({
                        icon: 'warning',
                        title: 'you are not auth please contect with admin'
                    })
                    }
                    location.reload();
                })
                //.catch(error => console.log(error.response.data))
                // .catch(error => this.errors = error.response.data.errors)
                .catch(
                    (error)=>{
                        console.log(error);
                    Toast.fire({
                        icon: 'warning',
                        title: 'phone or Password Invalid'
                    })
                    }
                )
            }
        }
    }
</script>


<style>

</style>
