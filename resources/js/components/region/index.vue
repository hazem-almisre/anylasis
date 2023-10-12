<template>
  <div>
    <!-- Breadcrumbs-->
    <ol class="breadcrumb mt-3 bg-white shadow">
      <!-----f----->
      <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">All Region</li>
    </ol>
    <!-- Icon Cards-->
    <div class="row card shadow ml-3 mr-3">
      <!-----f----->
      <div
        class="card-header text-dark bg-white"
        style="font-size: 20px; font-weight: 700"
      >
        <i class="fas fa-chart-area"></i>
        All Region
        <router-link
          to="/store-region"
          class="btn btn-success"
          style="
            border-radius: 20px;
            "
          id="add_new"
        >
          Add Region</router-link
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
              placeholder="Search by region"
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
                  <th>Region</th>
                  <th>Town</th>
                  <th>Country</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                <tr v-for="labLocation in filtersearch" :key="labLocation.labLocationId">
                  <!-------------------------->
                  <td>{{ labLocation.region }}</td>
                  <!--bind(:) korle R {{}} lage na-->
                  <td v-if="labLocation.town!=null">{{ labLocation.town }}</td>
                  <td v-else> you do not add Town for this location </td>
                   <td v-if="labLocation.country!=null">{{ labLocation.country }}</td>
                  <td v-else> you do not add Country for this location </td>
                  <td>
                    <router-link
                      :to="{ name: 'edit-region', params: { id: labLocation.labLocationId } }"
                      class="btn btn-sm btn-info"
                      >Edit</router-link
                    >
                    <!----it will dynamic thats why applied bind(:to)---->
                    <!-- <router-link :to="'/edit-category/'+category.id" class="btn btn-warning mr-1">Edit</router-link> -->
                    <!--or, -->
                    <!-- <router-link :to="`/edit-category/${category.id}`" class="btn btn-sm btn-primary text-white">Edit</router-link> -->
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
    this.allLabLocations();
    // console.log(this.employees);
  },

  data() {
    return {
      labLocations: [],
      searchTerm: "",
    };
  },
  computed: {
    //----search + show-------
    filtersearch() {
      return this.labLocations.filter((labLocation) => {
        //return employee.phone.match(this.searchTerm)
        return labLocation.region.toLowerCase().match(this.searchTerm.toLowerCase());
        // let searchLowerCase = employee.name.toLowerCase()
        // return searchLowerCase.match(this.searchTerm.toLowerCase())
      });
    },
  },
  methods: {
    allLabLocations() {
      axios
        .get("/lab/region/get",{headers:{
                Authorization: 'Bearer '+sessionStorage.getItem('token')
        }}) //--'get' will auto call index()_mathod in controller
        .then((data) => {
        this.labLocations=data.data.data.result
        console.log(this.labLocations)
        })
        .catch((error)=>{
            console.log(error.response.data)
        });
    },
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
