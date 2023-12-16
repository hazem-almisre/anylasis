
//--------Authenticaton_Components----------
let Login = require('./components/auth/login.vue').default;
let Register = require('./components/auth/register.vue').default;
let forgetPass = require('./components/auth/forget.vue').default;
let logout = require('./components/auth/logout.vue').default;
//--or--import Register from './components/auth/register.vue' //--or--
//-------Home/Dashboard_Components----------
let home = require('./components/home.vue').default;
let lab = require('./components/lab.vue').default;
//--------Employee_Components---------------
let storeEmployee = require('./components/employee/create.vue').default;
let employee = require('./components/employee/index.vue').default;
let editEmployee = require('./components/employee/edit.vue').default;
//--------region Lab---------------
let storeRegion = require('./components/region/create.vue').default;
let Region = require('./components/region/index.vue').default;
let editRegion = require('./components/region/edit.vue').default;
//--------Offers_Components--------------- as offer
let storeOffer = require('./components/offers/create.vue').default;
let Offer = require('./components/offers/index.vue').default;
let editOffer = require('./components/offers/edit.vue').default;
//-------Category_Components---------------
let storecategory = require('./components/category/create.vue').default;
let category = require('./components/category/index.vue').default;
let editcategory = require('./components/category/edit.vue').default;
let labProfile = require('./components/lab_profile.vue').default;
//-------Product_Components---------------
let storeproduct = require('./components/product/create.vue').default;
let product = require('./components/product/index.vue').default;
let editproduct = require('./components/product/edit.vue').default;
//-------Salary_Components----------------
let salary = require('./components/salary/all_employee.vue').default;
let paysalary = require('./components/salary/create.vue').default;
let allsalary = require('./components/salary/index.vue').default;
let viewsalary = require('./components/salary/view.vue').default;
let editsalary = require('./components/salary/edit.vue').default;
//------Stock_Components-----------------
let editstock = require('./components/product/edit-stock.vue').default;
let stock = require('./components/product/stock.vue').default;
//------Customers_Components-----------------
let storeCustomer = require('./components/customer/create.vue').default;
let Customer = require('./components/customer/index.vue').default;
let editCustomer = require('./components/customer/edit.vue').default;
//------Orders_Components-----------------------
let order = require('./components/order/order.vue').default;
let vieworder = require('./components/order/viewOrder.vue').default;
let searchorder = require('./components/order/search.vue').default;


export const routes = [
    //-------JWT/auth_routes--------
    { path: '/', component: Login, name: '/' },   //--amra ekane (name:'blah') ta use korteo pari,Nao pari,Not mendatory
    { path: '/register', component: Register, name: 'register' },   //--JWT-auth
    { path: '/forget', component: forgetPass, name: 'forget' },
    { path: '/logout', component: logout, name: 'logout' },
    //-------home_route----------
    { path: '/home', component: home, name: 'home' },       //--home_route
    { path: '/lab', component: lab, name: 'lab' },       //--home_route
    //-------Employee_routes-------
    { path: '/store-employee', component: storeEmployee, name:'store-employee' },
    { path: '/employee', component: employee, name:'employee' },   //route'r sate 'path' working,'name' not working
    { path: '/edit-employee/:id', component: editEmployee, name:'edit-employee' },  //-------------------
    //-------region_routes-------
    { path: '/store-region', component: storeRegion, name:'store-region' },
    { path: '/region', component: Region, name:'region' },   //route'r sate 'path' working,'name' not working
    { path: '/edit-region/:id', component: editRegion, name:'edit-region' },
    //-------Supplier_routes-----------
    { path: '/store-supplier', component: storeOffer, name:'store-supplier' },
    { path: '/supplier', component: Offer, name:'supplier' },
    { path: '/edit-supplier/:id', component: editOffer, name:'edit-supplier' },
    //-------Category_routes-----------
    { path: '/store-category', component: storecategory, name:'store-category' },
    { path: '/category', component: category, name:'category' },
    { path: '/edit-category/:id', component: editcategory, name:'edit-category' },
    { path: '/lab/profile', component: labProfile, name:'lab-profile' },
    //-------Product_routes------------
    { path: '/store-product', component: storeproduct, name:'store-product' },
    { path: '/product', component: product, name:'product' },
    { path: '/edit-product/:id', component: editproduct, name:'edit-product' },
    //-------Salary_routes------------
    { path: '/given-salary', component: salary, name:'given-salary' },
    { path: '/pay-salary/:id', component: paysalary, name:'pay-salary' },
    { path: '/salary', component: allsalary, name:'salary' },
    { path: '/view-salary/:id', component: viewsalary, name:'view-salary' },
    { path: '/edit-salary/:id', component: editsalary, name:'edit-salary' },
    //-------Stock_routes------------
    { path: '/stock', component: stock , name:'stock' },
    { path: '/edit-stock/:id', component: editstock, name:'edit-stock' },
    //-------Customers---------------
    { path: '/store-Customer', component: storeCustomer, name:'store-Customer' },
    { path: '/Customer', component: Customer, name:'Customer' },
    { path: '/edit-Customer/:id', component: editCustomer, name:'edit-Customer' },
    //-------Order-----------
    { path: '/order', component: order, name:'order' },
    { path: '/view-order/:id', component: vieworder, name:'view-order' },
    { path: '/searchorder', component: searchorder, name:'searchorder' },

]
