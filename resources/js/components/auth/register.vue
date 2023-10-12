<template>
    <div>
        <div class="container">
<div class="row justify-content-left">
    <div class="col-lg-7 offset-1">
        <div class="card shadow-lg border-primary rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center text-primary font-weight-bold my-4">Register New Account</h3></div>
            <div class="card-body">

                <form @submit.prevent="signup">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1" for="inputFirstName">Full Name</label>
                                <input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter Full Name" v-model="form.name"/>

                                <small class="text-danger" v-if="errors.name" style="color:red">{{ errors.name[0] }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="mb-1" for="inputPhoneAddress">phone</label>
                        <input class="form-control py-4" id="inputPhoneAddress" type="phone" aria-describedby="phoneHelp" placeholder="Enter phone Address" v-model="form.phone"/>

                        <small class="text-danger" v-if="errors.phone" style="color:red">{{ errors.phone[0] }}</small>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-1" for="inputPassword">Password</label>
                                <input class="form-control py-4" id="inputPassword" type="password" placeholder="Enter Password" v-model="form.password"/>

                                <small class="text-danger" v-if="errors.password" style="color:red">{{ errors.password[0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-1" for="inputConfirmPassword">Confirm Password</label>
                                <input class="form-control py-4" id="inputConfirmPassword" type="password" placeholder="Confirm Password" v-model="form.password_confirmation"/>

                                <!-- <small class="text-danger" v-if="errors.password_confirmation" style="color:red">{{ errors.password_confirmation[0] }}</small> -->
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4 mb-0">
                        <button type="submit" class="btn btn-primary btn-block"> Sign up </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <div class="">
                    <router-link to="/">Already have an account? Go to login</router-link>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    </div>
</template>


<script>
    export default {
        created(){
            if (User.loggedIn()) {
                this.$router.push({name:'home'})   // or, //this.$router.push('/home')
            }
        },
        data(){
            return {
                form:{
                    name:null,
                    phone:null,
                    password:null,
                    password_confirmation:null
                },
                errors:{},
            }
        },
        methods:{
            signup(){
                // alert('done');   //--testing submit
                axios.post('/api/auth/signup',this.form)
                // .then(response => console.log(response.data))
                .then(response => {
                    console.log(response);
                    User.responseAfterLogin(response)
                    Toast.fire({
                        icon: 'success',
                        title: 'Signed in Successfully'
                    })
                    this.$router.push('/home')    // or, this.$router.push({name:'home})
                })
                .catch(error => console.log(error.response))
                // .catch(function(error) {
                //     console.log(error.response);
                // })



            }
        }
    }
</script>


<style>

</style>
