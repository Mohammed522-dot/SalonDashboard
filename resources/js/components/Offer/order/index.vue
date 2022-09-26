<template>
<v-app>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuther()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">التقارير  </h3>
                <div class="card-tools">
                <div class="row">
                  <div class="col-sm">
                  <button class="btn btn-primary" data-toggle="modal" @click="newModal()">اضافة <i class="fas fa-user-plus"></i></button>
                  </div>
                  <div class="col-sm-auto">

                    <!-- DropDown List To Specific Print Choise -->
<!-- Example single danger button -->
<div class="btn-group">
  <button type="button" @click="inilizeData()" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    طباعة او تصدير
  </button>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="#" >
            <download-excel
            class="dropdown-item"
            :data="orders.data"
            :fields="orders_fields"

            worksheet="My Worksheet"

            name="filename.xls"
            >
            اكسيل
            </download-excel>
    </a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#">
            <download-excel
            class="dropdown-item"
            :data="orders.data"
            :fields="orders_fields"
            worksheet="My Worksheet"
            type="csv"
            name="csvfilename.xls"
            >
            CSV
            </download-excel>

    </a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item text-center" href="#" @click="printReport">طباعة</a>
    <!-- <download-excel
  class="dropdown-item"
  :data="json_data"
  :fields="json_fields"
  worksheet="My Worksheet"
  name="filename.xls"
>
   Excel
    </download-excel> -->

  </div>
</div>
                    <!-- End DropDown -->

                  </div>

<div class="col-sm-auto">
   <select v-model="statusOrder" class="form-control " @change="filterData">
        <option value="-1">
            الكل
        </option>
        <option value="0">
            جديدة
        </option>
        <option value="1">
            تم قبوله
        </option>
    </select>
</div>
       </div>
        </div>
          </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table id="Report" class="table table-hover">
                  <thead>
                    <tr >
                       <th> رقم الحجز</th>
                       <th>المستخدم</th>
                       <th>رقم الهاتف</th>
                       <th>رقم هاتف اخر</th>
                       <!-- <th>عنوان الطلب</th> -->
                       <th>الملاحظة</th>
                       <!-- <th>اسم العرض</th> -->
                       <!-- <th> الكمية </th> -->
                       <!-- <th>الاجمالي</th> -->
                       <th>الحالة</th>
                        <!-- <th>الخريطة</th> -->
                      <th>التحكم </th>
                    </tr>
                  </thead>
                  <template>
                    <v-progress-linear
                        :active="loading"
                        :indeterminate="loading"
                        absolute
                        bottom
                        color="deep-purple accent-4"
                  ></v-progress-linear>
                  </template>

                  <tbody>
                   <td style="text-align: center;" v-if="loading" colspan="6"> انتظر جاري التحميل ...... </td>

                  <tr v-for="order in orders.data " :key="order.id" style="text-align: center;" >
                  <td>{{order.id}}</td>
                  <td>{{order.user_name}}</td>
                  <td>{{order.phone}}</td>
                  <td>{{order.phone}}</td>
                  <!-- <td>{{order.address}}</td> -->
                  <td>{{order.note}}</td>
                  <!-- <td>{{order.name}}</td> -->
                  <!-- <td>{{order.booking_dates}}</td> -->
                  <!-- <td>{{order.offer.price * order.amount }}</td> -->
                  <td >
                        <b-button @click="changeStatusOrder(order.id,order.status_id)" size="sm" pill :variant="order.status_id ? 'outline-danger' : 'outline-primary'">
                            {{order.status_id | statusText}}
                        </b-button>

                      <!-- <b-button  @click="(order.status_id >=0 ? changeStatusOrder(order.id,1):changeStatusOrder(order.id,1))" :variant="order.status_id =0 ?'danger' :'success'">{{order.status_id | statusText}}</b-button> -->
                  </td>
<!-- 
                  <td>
                  <a href="maps" > <i class="fas fa-map-marker-alt" > </i>
                  </a>

                  </td> -->
                      <!-- <td>{{order.date_price | myDate}}</td> -->
                      <td style="text-align: center;">
                  <a href="#" > <i class="fas fa-eye" @click="showOrderDetailsDialog(order)"> </i>
                  </a>
                    /
                  <a href="#" @click="deleteItems(order.id)"> <i class="fas fa-trash red"> </i>
                  </a>
                  <!-- /
                    <a href="#" > <i class="fas fa-eye" @click="showOrderDetailsDialog(order)"> </i>
                    </a> -->

                  </td>
                  </tr>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

                <div class="card-footer">
                    <pagination :data="orders.data"
                     @pagination-change-page="getResults" ></pagination>
                </div>

            </div>
            <!-- /.card -->
          </div>
        </div>

<div v-if="!$gate.isAdminOrAuther()">
    <not-found> </not-found>
</div>




<!-- Modal -->
<div class="modal fade" id="bookingsDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title"  v-show="!editeMode" id="exampleModalLabel">اضافة قسم</h5>
          <h5 class="modal-title" v-show="editeMode" id="updateModaleTitle">تعديل بيانات قسم</h5> -->


          <table class="table">
  <thead>
    <tr>
    
      <th scope="col">اسم الخدمة</th>
      <th scope="col">السعر</th>
      <th scope="col">الوقت</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="bookingdetail in bookingDetails " :key="bookingdetail.id">
     
      <td>{{ bookingdetail.name }}</td>
      <td>{{ bookingdetail.price }}</td>
      <td>{{ bookingdetail.time_service }}</td>
    </tr>
   
  </tbody>
</table>          


      </div>
    </div>
  </div>
</div>
<!-- end Modal -->

    </div>
</v-app>
</template>

<script>

    export default {
        components:{

        },

        data(){
            return{
                loading:false,
                statusOrder:-1,
                styleObect:{},
                orders_fields:{
                    "اسم المستخدم":"user_name",
                    " رقم الهاتف":"phone",
                    "العنوان":"address",
                    "الملاحظة":"note",
                    "اسم العرض":"offer.name",
                    "الكمية":"amount",
                    "الاجمالي":{
                        callback:(value) => {
                            return value.amount * value.offer.price
                        }
                    },
                    "حالة الطلب":{
                        field:"status_id",
                        callback(value){
                            return value ? 'تم تسليمه' : 'جديد'
                        }

                    },


                },
    json_fields: {
      "Complete name": "name",
      City: "city",
      Telephone: "phone.mobile",
      "Telephone 2": {
        field: "phone.landline",
        callback: (value) => {
          return `Landline Phone - ${value}`;
        },
      },
    },
    json_data: [
      {
        name: "Tony Peña",
        city: "New York",
        country: "United States",
        birthdate: "1978-03-15",
        phone: {
          mobile: "1-541-754-3010",
          landline: "(541) 754-3010",
        },
      },
      {
        name: "Thessaloniki",
        city: "Athens",
        country: "Greece",
        birthdate: "1987-11-23",
        phone: {
          mobile: "+1 855 275 5071",
          landline: "(2741) 2621-244",
        },
      },
    ],
    json_meta: [
      [
        {
          key: "charset",
          value: "utf-8",
        },
      ],
    ],

                editeMode:false,
                orderDetailsDialog:false,
                orders:{},
                orderDetails:{},
                resources:{},
                subCategories:{},
                orderDetailsID:0,
                bookingDetails:[],
                form :new Form({
                    id:'',
                    total_price:0,
                    inputs: [{
                    quantity:[],
                    price_puyer:[],
                    component_id:[],
                    // purches_id:''
                    }],
                    date_price:'2020-10-10',
                    image:'ana.png',
                })
            }
        },

        methods:{

            changeStatusOrder(id,statusID){
                if(statusID > 0 )
                return
                Swal.fire({
                    title: 'هل انت متاكد?',
                    text: "من انك تريد تسليم الطلبية!",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText:' لا | خروج ',
                    confirmButtonText: 'نعم'
                }).then((result) => {
                    if (result.value) {
                        var vform=new Form({
                            status_id:1
                        });
                        // send ajax requestto delete
              vform.put('api/admin/orders/'+id)
                .then(()=>{
                    $('#addNewUserModal').modal('hide')
                    Swal.fire('تسليم طلب!','تم الارسال  بنجاح','success')
                    Fire.$emit('AfterCreated')
                    this.$Progress.finish()
                })
                .catch(()=>{
                    Swal.fire('قشل ','هناك خطاء ماء ','warning')
                    this.$Progress.fail()
                })

                    }
                })
                .catch(()=>{
                    Swal.fire('فشل','هناك هطاء ماء','warning')
                })

            },
            filterData(){
                this.loading=true
                let query='';
                if(this.statusOrder>=0)
                   query='status_id='+this.statusOrder
                axios.get('api/admin/orders?admin=admin&'+query)
                .then(({data})=>{
                    this.orders=data.data
                    this.loading=false
                })

            },


            inilizeData(){
                this.json_data
                console.log("ana Clicked")
            },
            updateModal(ordersData){
                this.getResources()
                this.editeMode=true
                $('#addNewUserModal').modal('show')
                this.form.reset()
                this.form.fill(ordersData)
            },

            newModal(){
                this.getResources()
                this.editeMode=false
                this.form.reset()
                $('#addNewUserModal').modal('show')


            },

            loadReports(){
                this.loading=true
                if(this.$gate.isAdminOrAuther()){
                axios.get('api/admin/orders?admin=admin')
                .then(({data})=>{
                  this.orders=data.data
                  //console.log(this.orders.data)
                    this.loading=false
                })}
            },

            updatePurches(id){
                this.$Progress.start()
              this.form.put('api/admin/reports/'+this.form.id)
                .then(()=>{
                    $('#addNewUserModal').modal('hide')
                    Swal.fire('Updated!','Updated User Successfully ','success')
                    Fire.$emit('AfterCreated')
                    this.$Progress.finish()
                })
                .catch(()=>{
                    Swal.fire('Failed','There was Somthing Wrong ','warning')
                    this.$Progress.fail()
                })
            },

            deleteItems(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        // send ajax requestto delete
                        this.form.delete('api/admin/reports/'+id).then(()=>{
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )

                            Fire.$emit('AfterCreated')

                        })
                    }
                })
                .catch(()=>{
                    Swal.fire('Failed','There was Somthing Wrong ','warning')
                })

            },

            getResults(page=1){
                let query=''
                if(this.statusOrder>=0)
                   query='status_id='+this.statusOrder
              axios.get('api/admin/orders?admin=admin&page='+page+'&'+query)
              .then(response=>{
                  this.orders=response.data.data
              })
            },
          createPurches(){
              this.$Progress.start();
              this.form.post('api/admin/reports')
              .then(()=>{

                  $('#addNewUserModal').modal('hide')

                  Toast.fire({
                      icon: 'success',
                      title: 'Created User Successfully '
                  })

                  this.$Progress.finish();

                  Fire.$emit('AfterCreated');
              })
              .catch(()=>{

              })

          },
          getOrderDetails(id){
                          if(this.$gate.isAdminOrAuther()){
                  axios.get('api/admin/orders/'+id+'/details')
                  .then(({data})=> {
                      this.orderDetails=data.data

                      console.log(this.orderDetails)

            }  )
              }

            this.orderDetailsID=id
            this.editeMode=true
            $('#addNewUserModal').modal('show')
          },
        getResources(event){
              if(this.$gate.isAdminOrAuther()){
                  axios.get('api/components/')
                  .then(({data})=> {
                      this.resources=data.data
                      }  )
              }
          },

          // Add Row Fields For Input
          add () {
       this.form.inputs.push({
                    quantity:'',
                    price_puyer:0,
                    component_id:'',
                    purches_id:''
      })
      // console.log(this.form)
    },
    remove (index) {
      // removeData=this.form.inputs[index]
      var dataRemoved =this.form.inputs.splice(index, 1)
      // console.log(dataRemoved[0].price_puyer)
    },
            exil(){
 import('./../../../Exportxlsx').then(excel => {
  //  const orders=this.orders;
  excel.export_json_to_excel({
    header: ['Id', 'Title', 'Author', 'Readings', 'Date'], //Header Required
    data:[[1,'ana','ana','ana','ana']],//Specific data Required
    // filename: 'excel-list', //Optional
    autoWidth: true, //Optional
    bookType: 'xlsx' //Optional
  })
})

        },

          formatJson(filterVal, jsonData) {
      return jsonData.map(v => filterVal.map(j => {
        if (j === 'timestamp') {
          return parseTime(v[j])
        } else {
          return v[j]
        }
      }))
    },


            showOrderDetailsDialog(order){
              this.bookingDetails = order.services
              $('#bookingsDetails').modal('show');
              
            },

            showMapsDialog(order){
                 Fire.$emit('showMapsDialog',{order:order,dialogMap:true})
            },


    printReport() {

    // this.styleObect={
    //     "border": "1px solid black",
    //     "border-collapse": "collapse"
    // };
    let list2=[];
    let list=[{"name":"ana","age":2},{"name":"ana","age":2},{"name":"ana","age":2},];
    this.orders.data.map((value,key)=>{
    //  list.push(value);
    list2.push(Object.values(value));
    console.log(Object.values(value)  + " k   "+key+ "    lIst   \n")
    console.log(list2)
   });
    //  this.$htmlToPaper('Report');
    }
          //
        },


        created() {

            //this.$Progress.start();
            this.loadReports()

            Fire.$on('closeOrderDetailsDialog',()=>{
                this.orderDetailsDialog=false
            })

            Fire.$on('closeMapsDialog',()=>{
                // this.orderDetailsDialog=false
            })



            Fire.$on('AfterCreated',()=>{
                this.loadReports()
            })

            Fire.$on("Searching",()=>{
                let query=this.$parent.search
                axios.get('api/admin/reports?q='+query)
                .then((data)=>{
                    this.orders=data.data
                })
                .catch(()=>{

                })
            })

            // setInterval(()=>this.loadSubCategory(),3000)
            //this.$Progress.finish();
        },
        computed: {
    total(){
       var sum= this.form.inputs.reduce( (total, item) =>

        parseInt(item.price_puyer) + parseInt(total)  ,0

        );
        this.form.total_price=sum
        return sum
        },

  },
        //printReport
        // mounted() {
        //console.log('Component mounted.')
        // }
    }
</script>

<style scoped>
/* @import url('/css/Print.css'); */
</style>
<style scoped>

hr.style1{
	border-top: 1px solid #8c8b8b;
}

</style>
