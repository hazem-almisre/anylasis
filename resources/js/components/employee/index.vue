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
          to="/store-employee"
          class="btn btn-success"
          style="
            border-radius: 20px;
            "
          id="add_new"
        >
          Add Employee</router-link
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
                  <th>Ratio</th>
                  <th>Joining Date</th>
                  <th>isActivie</th>
                  <th>Address</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                <tr v-for="employee in filtersearch" :key="employee.nurseId">
                  <!-------------------------->
                  <td>{{ employee.name }}</td>
                  <td><img :src="'storage/'+employee.photo" id="em_photo" /></td>
                  <!--bind(:) korle R {{}} lage na-->
                  <td>{{ employee.phone }}</td>
                  <td>{{ employee.ratio }}</td>
                  <td>{{ employee.created_at }}</td>
                  <td>
                        <div class="form-check form-switch">
                        <input class="form-check-input" style="margin: auto;transform:scale(1.5)" false:value="0" true:value="1" type="checkbox" @click="changeIsActive(employee.nurseId)" v-model="employee.isActive" role="switch" id="flexSwitchCheckDefault">
                        </div>
                  </td>
                  <td>{{ employee.address }}</td>
                  <td>
                    <router-link
                      :to="{ name: 'edit-employee', params: { id: employee } }"
                      class="btn btn-sm btn-info"
                      >Edit</router-link
                    >
                    <!----it will dynamic thats why applied bind(:to)---->
                    <!-- <router-link :to="'/edit-category/'+category.id" class="btn btn-warning mr-1">Edit</router-link> -->
                    <!--or, -->
                    <!-- <router-link :to="`/edit-category/${category.id}`" class="btn btn-sm btn-primary text-white">Edit</router-link> -->
                    <a
                      @click="deleteEmployee(employee.nurseId)"
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
    this.allEmployee();
    // console.log(this.employees);
  },

  data() {
    return {
      employees: [],
      searchTerm: "",
    };
  },
  computed: {
    //----search + show-------
    filtersearch() {
      return this.employees.filter((employee) => {
        //return employee.phone.match(this.searchTerm)
        return employee.name.toLowerCase().match(this.searchTerm.toLowerCase());
        // let searchLowerCase = employee.name.toLowerCase()
        // return searchLowerCase.match(this.searchTerm.toLowerCase())
      });
    },
  },
  methods: {
    allEmployee() {
        console.log(sessionStorage.getItem('token'))
      axios.get("/nurse/web/get/nurses",
        {
            headers:{
                Authorization: 'Bearer '+sessionStorage.getItem('token')
            }
        }
        ) //--'get' will auto call index()_mathod in controller
        .then((data) => {
        this.employees=data.data.data.result
        console.log(this.employees)
        })
        .catch();
    },
    deleteEmployee(nurseId) {
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
            .delete("/nurse/web/delete/nurse/"+nurseId,{headers:{
                Authorization: 'Bearer '+sessionStorage.getItem('token')
            }}) //------------delete-------------
            .then((response) => {
                console.log(response.data.data)
              this.employees = this.employees.filter((employee) => {
                return employee.nurseId != nurseId;
              });
              Swal.fire("Deleted!", "Your file has been deleted.", "success");
              this.$router.push({ name: "employee" });
            })
            .catch((error) => {
              console.log(error.response.data)
            });

        }
      });
    },
    changeIsActive(nurseId){
        console.log(sessionStorage.getItem('token'))
        axios.post("nurse/web/changeActivie/nurse/"+nurseId,null,
        {
            headers:{
                Authorization: 'Bearer '+sessionStorage.getItem('token')
            }
        }
        )
        .then((response)=>{
            console.log(response.data);
            Toast.fire({
            icon: 'success',
            title: 'isActivie nurse has been change'
            })
        }).catch((error)=>{
            console.log(error)
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
