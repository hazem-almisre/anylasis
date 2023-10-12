<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">   <!--this is for 'error free console'/(vue_devTool)-->
        <title>Admin-Inventory - Vue+Laravel</title>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">   <!--must be linked at the Top of All other CSS_files-->
        <link href="{{ asset('backend/css/styles.css') }}" rel="stylesheet" />
        <script src="{{ asset('backend/js/all.min.js') }}" crossorigin="anonymous"></script>
    </head>

    <style>

        .dropdown-divider{
            border-color: black;
        }
        .accordion-button::after{
            display: none;
            content: ""
        }
    </style>
    <body class="sb-nav-fixed" style="background-color: #f4f6f9">

    <div id="app">     <!---VUE_JS er jonno ei id='app' div ta niyechi pora/entire body tar jonno--->

    <!-----------start_Top_Navbar----------->
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark" id="topbar" v-show="$route.path === '/' || $route.path === '/register' || $route.path === '/forget' ? false : true" style="display: none;"> <!-------------------->
            <div class="container-fluid">
            <router-link class="navbar-brand" to="/home"> Inventory_Vue+Laravel </router-link>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>

            <div class="dropdown ml-auto ml-md-0 ">
                <button class=" btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" >
                    <i class="fas fa-user fa-fw"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-lg-right" style="right: 0%;left: -150%;" aria-labelledby="dropdownMenuButton1">
                  <li><a class="dropdown-item" href="#">Settings</a></li>
                  <li><a class="dropdown-item" href="#">Activity Log</a></li>
                  <div class="dropdown-divider"></div>
                  <li><router-link class="dropdown-item" to="/logout">Logout</a></li>
                </ul>
            </div>

        </div>
        </nav>      <!---End_Top_Navbar--->


<!--------------------Left_Navbar------------------------>
    <div id="leftbar" v-show="$route.path === '/' || $route.path === '/register' || $route.path === '/forget' ? false : true" style="display: none;">       <!----------------------------->
        <div id="layoutSidenav" >
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark bg-dark" id="sidenavAccordion" >
                    <div class="sb-sidenav-menu">
                        <div class="nav">                       <!----------------------------->
                            {{-- <div class="sb-sidenav-menu-heading">Core</div> --}}
                        {{-- شريط الاحبار    <marquee class="text-white">#&nbsp&nbsp Laraval-5.8 &nbsp&nbsp#&nbsp&nbsp Vue  &nbsp&nbsp#&nbsp&nbsp Api &nbsp&nbsp#&nbsp&nbsp JWT &nbsp&nbsp#&nbsp&nbsp Inventory_POS</marquee> --}}
                            <router-link class="nav-link" to="/home">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </router-link>

                            <router-link class="nav-link" to="/lab/profile" id="labProfile" style="display: none">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Profile
                            </router-link>

                    <!--------------Employee----------->
                              <div class="accordion-item " id="employee" style="display: none">
                                <h2 class="accordion-header" id="heading1">
                                  <button class="accordion-button bg-dark text-light "  type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                    Employe
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                  </button>
                                </h2>
                                <div id="collapse1" class="accordion-collapse collapse " aria-labelledby="heading1" data-bs-parent="#sidenavAccordion">
                                  <div class="accordion-body bg-dark text-light" style="padding: 0%;margin: 0%;">
                                    <ul class='list-unstyled bg-dark' style="margin: 0">
                                        <li><router-link class="dropdown-item text-light" to="/store-employee">Add Employee</router-link></li>
                                        <div class="dropdown-divider text-black"></div>
                                        <li><router-link class="dropdown-item text-light" to="/employee">All Employee</router-link></li>
                                    </ul>
                                    </div>
                                </div>
                              </div>

                            <!--------------Region----------->
                            <div class="accordion-item " id="region" style="display: none">
                            <h2 class="accordion-header" id="heading9">
                                <button class="accordion-button bg-dark text-light "  type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Region
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </button>
                            </h2>
                            <div id="collapse9" class="accordion-collapse collapse " aria-labelledby="heading9" data-bs-parent="#sidenavAccordion">
                                <div class="accordion-body bg-dark text-light" style="padding: 0%;margin: 0%;">
                                <ul class='list-unstyled bg-dark' style="margin: 0">
                                    <li><router-link class="dropdown-item text-light" to="/store-region">Add Region</router-link></li>
                                    <div class="dropdown-divider text-black"></div>
                                    <li><router-link class="dropdown-item text-light" to="/region">All Region</router-link></li>
                                </ul>
                                </div>
                            </div>
                            </div>
                    <!--------------Offer----------->
                    <div class="accordion-item" id="offer" style="display: none">
                        <h2 class="accordion-header" id="headingtow">
                          <button class="accordion-button bg-dark text-light "  type="button" data-bs-toggle="collapse" data-bs-target="#collapsetow" aria-expanded="false" aria-controls="collapsetow">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Offer
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                          </button>
                        </h2>
                        <div id="collapsetow" class="accordion-collapse collapse " aria-labelledby="headingtow" data-bs-parent="#sidenavAccordion">
                          <div class="accordion-body bg-dark text-light" style="padding: 0%;margin: 0%;">
                            <ul class='list-unstyled bg-dark' style="margin: 0">
                                <li><router-link class="nav-link" to="/store-supplier">Add Offer</router-link></li>
                                <div class="dropdown-divider text-black"></div>
                                <li><router-link class="nav-link" to="/supplier">All Offer</router-link></li>
                            </ul>
                            </div>
                        </div>
                      </div>

                    <!--------------Categories----------->
                            <div class="accordion-item " id="categories" style="display: none">
                                <h2 class="accordion-header" id="headingThree">
                                  <button class="accordion-button bg-dark text-light "  type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                    Categories
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                  </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse " aria-labelledby="headingThree" data-bs-parent="#sidenavAccordion">
                                  <div class="accordion-body bg-dark text-light" style="padding: 0%;margin: 0%;">
                                    <ul class='list-unstyled bg-dark' style="margin: 0">
                                        <li><router-link class="nav-link" to="/store-category">Add Category</router-link></li>
                                        <div class="dropdown-divider text-black"></div>
                                        <li><router-link class="nav-link" to="/category">All Category</router-link></li>
                                    </ul>
                                    </div>
                                </div>
                              </div>

                    <!--------------Product----------->
                            <div class="accordion-item " id='product' style="display: none">
                                <h2 class="accordion-header" id="headingFour">
                                  <button class="accordion-button bg-dark text-light "  type="button" data-bs-toggle="collapse" data-bs-target="#collapseFoure" aria-expanded="false" aria-controls="collapseFoure">
                                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                    Products
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                  </button>
                                </h2>
                                <div id="collapseFoure" class="accordion-collapse collapse " aria-labelledby="headingFour" data-bs-parent="#sidenavAccordion">
                                  <div class="accordion-body bg-dark text-light" style="padding: 0%;margin: 0%;">
                                    <ul class='list-unstyled bg-dark' style="margin: 0">
                                        <li> <router-link class="nav-link" to="/store-product">Add Product</router-link></li>
                                        <div class="dropdown-divider text-black"></div>
                                        <li><router-link class="nav-link" to="/product">All Product</router-link></li>
                                    </ul>
                                    </div>
                                </div>
                              </div>

                    <!--------------Customer----------->
                            <div class="accordion-item ">
                                <h2 class="accordion-header" id="heading5">
                                  <button class="accordion-button bg-dark text-light "  type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                    Customers
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                  </button>
                                </h2>
                                <div id="collapse5" class="accordion-collapse collapse " aria-labelledby="heading5" data-bs-parent="#sidenavAccordion">
                                  <div class="accordion-body bg-dark text-light" style="padding: 0%;margin: 0%;">
                                    <ul class='list-unstyled bg-dark' style="margin: 0">
                                        <li>  <router-link class="nav-link" to="/store-Customer">Add Customer</router-link></li>
                                        <div class="dropdown-divider text-black"></div>
                                        <li><router-link class="nav-link" to="/Customer">All Customer</router-link></li>
                                    </ul>
                                    </div>
                                </div>
                              </div>

                    <!--------------Salary----------->
                            <div class="accordion-item ">
                                <h2 class="accordion-header" id="heading7">
                                  <button class="accordion-button bg-dark text-light "  type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                    Salary
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                  </button>
                                </h2>
                                <div id="collapse7" class="accordion-collapse collapse " aria-labelledby="heading7" data-bs-parent="#sidenavAccordion">
                                  <div class="accordion-body bg-dark text-light" style="padding: 0%;margin: 0%;">
                                    <ul class='list-unstyled bg-dark' style="margin: 0">
                                        <li><router-link class="nav-link" to="/given-salary">Pay Salary</router-link></li>
                                        <div class="dropdown-divider text-black"></div>
                                        <li><router-link class="nav-link" to="/salary">All Salary</router-link></li>
                                    </ul>
                                    </div>
                                </div>
                              </div>
                    <!--------------Orders----------->
                            <div class="accordion-item ">
                                <h2 class="accordion-header" id="heading7">
                                  <button class="accordion-button bg-dark text-light "  type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                    Orders
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                  </button>
                                </h2>
                                <div id="collapse8" class="accordion-collapse collapse " aria-labelledby="heading7" data-bs-parent="#sidenavAccordion">
                                  <div class="accordion-body bg-dark text-light" style="padding: 0%;margin: 0%;">
                                    <ul class='list-unstyled bg-dark' style="margin: 0">
                                        <li><router-link class="nav-link" to="/order">Today Order</router-link></li>
                                        <div class="dropdown-divider text-black"></div>
                                        <li> <router-link class="nav-link" to="/searchorder">Search</router-link></li>
                                    </ul>
                                    </div>
                                </div>
                              </div>
                    <!--------------Stock----------->
                            <router-link class="nav-link collapsed" to="/stock">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Stock
                            </router-link>

                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>  <!---End_Left_Navbar-->


<!--------------------Dashboard/Body------------------------>
        <div id="layoutSidenav">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <router-view></router-view>     <!-------------------------------------->
                    </div>
                </main>
            </div>
        </div><!---End__Dashboard--->

</div>  <!---End___VUE_JS er jonno j id='app' div ta niyechilam pora body tar jonno--->





    <!---------JavaScript_external_files-------->
        <script src="{{ mix('js/app.js') }}"></script>   <!--must be linked at the Top of All other JS_files-->
        <script src="{{ asset('backend/assets/demo/jquery-3.5.1.min.js') }}" crossorigin="anonymous"></script>

        <script>    //<!--Topbar & Navbar Show korano[after login//'token' takle]-->
            let type = sessionStorage.getItem('type');
            console.log(sessionStorage.getItem('type'))
            if(type) {
                $("#topbar").css("display","");
                $("#leftbar").css("display","");
                if(type === 'api'){
                    $("#employee").css("display","");
                    $("#categories").css("display","");
                    $("#region").css("display","");
                }
                else if(type === 'lab'){
                    $("#product").css("display","");
                    $("#offer").css("display","");
                    $("#labProfile").css("display","");
                }
            }
        </script>

        {{-- <script src="{{ asset('backend/assets/demo/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script> --}}
            <!--//--output e login/setting option gula click kora jacchilo na tai amra ei BS_4 file ta comment korechi--//-->
        <script src="{{ asset('backend/js/scripts.js') }}"></script>

    </body>
</html>
