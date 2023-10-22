<template>
  <div>
    <!-- Breadcrumbs-->
    <ol class="breadcrumb mt-3 bg-white shadow">
      <!-----f----->
      <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">All Employee</li>
    </ol>
    <!-- Icon Cards-->
    <div class="row card shadow ml-3 mr-3">
      <!-----f----->
      <div
        class="card-header text-dark bg-white"
        style="font-size: 20px; font-weight: 700"
      >
        <i class="fas fa-chart-area"></i>
        All Employee
        <router-link
          to="/store-category"
          class="btn btn-success"
          style="
            border-radius: 20px;
            "
          id="add_new"
        >
          Add Lab</router-link
        >
        <!-----f----->
      </div>
      <div class="card-body pt-0 shadow">
        <!-----f----->
        <div class="card-body">
          <div class="table-responsive">
            <label class="d-inline">Search : </label>
            <!-----f----->
            <input
              type="text"
              v-model="searchTerm"
              class="form-control d-inline"
              style="width: 200px"
              placeholder="Search by name"
            /><br />
            <br />
            <!-----f----->
            <table
              class="table table-striped table-hover border-white table-bordered"
              width="100%"
              cellspacing="0"
            >
              <!-----f----->

              <thead>
                <tr class="bg-secondary text-white">
                  <!-----f----->
                  <th>Name</th>
                  <th>Photo</th>
                  <th>Phone</th>
                  <th>OwnerName</th>
                  <th>Joining Date</th>
                  <th>isActivie</th>
                  <th>Address</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                <tr v-for="lab in filtersearch" :key="lab.labID">
                  <!-------------------------->
                  <td>{{ lab.name }}</td>
                  <td><img :src="lab.photo" id="em_photo" /></td>
                  <!--bind(:) korle R {{}} lage na-->
                  <td>{{ lab.phone }}</td>
                  <td>{{ lab.ownerName }}</td>
                  <td>{{ lab.created_at }}</td>
                  <td>
                        <div class="form-check form-switch">
                        <input class="form-check-input" style="margin: auto;transform:scale(1.5)" false:value="0" true:value="1" type="checkbox" @click="changeIsActive(lab.labId)" v-model="lab.isActive" role="switch" id="flexSwitchCheckDefault">
                        </div>
                  </td>
                  <td>{{ lab.address }}</td>
                  <td>
                    <router-link
                      :to="{ name: 'edit-category', params: { id: lab } }"
                      class="btn btn-sm btn-info"
                      >Edit</router-link
                    >
                    <!----it will dynamic thats why applied bind(:to)---->
                    <!-- <router-link :to="'/edit-category/'+category.id" class="btn btn-warning mr-1">Edit</router-link> -->
                    <!--or, -->
                    <!-- <router-link :to="`/edit-category/${category.id}`" class="btn btn-sm btn-primary text-white">Edit</router-link> -->
                    <a
                      @click="deleteLab(lab.labId)"
                      class="btn btn-sm btn-danger text-white"
                      >Delete</a
                    >
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
  mounted() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "/" });
    }
  },

  created() {
    //--immediately showing data_table after opening file
    this.allLabs();
    // console.log(this.labs);
  },

  data() {
    return {
      labs: [],
      searchTerm: "",
    };
  },
  computed: {
    //----search + show-------
    filtersearch() {
      return this.labs.filter((lab) => {
        //return employee.phone.match(this.searchTerm)
        return lab.name.toLowerCase().match(this.searchTerm.toLowerCase());
        // let searchLowerCase = employee.name.toLowerCase()
        // return searchLowerCase.match(this.searchTerm.toLowerCase())
      });
    },
  },
  methods: {
    allLabs() {
      axios
        .get("/lab/admin/get/labs",{headers:{
                Authorization: 'Bearer '+sessionStorage.getItem('token')
            }}) //--'get' will auto call index()_mathod in controller
        .then((data) => {
        this.labs=data.data.data.result
        console.log(this.labs)
        })
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
        });
    },
    deleteLab(labId) {
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
            .delete("/lab/admin/delete/"+labId,{headers:{
                Authorization: 'Bearer '+sessionStorage.getItem('token')
            }}) //------------delete-------------
            .then((response) => {
                console.log(response.data.data)
              this.labs = this.labs.filter((lab) => {
                return lab.labId != labId;
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
    changeIsActive(labId){
        axios.post("/lab/admin/changeActivie/"+labId,null,{headers:{
                Authorization: 'Bearer '+sessionStorage.getItem('token')
            }})
        .then((response)=>{
            console.log(response.data);
            Toast.fire({
            icon: 'success',
            title: 'isActivie lab has been change'
            })
        }).catch(()=>{
             Toast.fire({
            icon: 'warning',
            title: 'please try later or contact with us'
            })
        })
    }
  },
};
</script>

<style>
#add_new {
  float: right;
}
#em_photo {
  height: 40px;
  width: 40px;
}
</style>
