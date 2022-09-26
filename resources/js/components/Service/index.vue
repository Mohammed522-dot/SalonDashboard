<template>
<v-app>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuther()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">جدول الخدمات</h3>

                <div class="card-tools">
                  <button class="btn btn-primary" data-toggle="modal" @click="newModal()">اضافة <i class="fas fa-user-plus"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>الرقم</th>
                      <th>نوع الخدمة </th>
                      <th>وصف الخدمة </th>
                      <th>السعر </th>
                      <th>الزمن </th>
                      <th>التحكم</th>
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

                  <tr v-for="service in services.data.data" :key="service.id">
                  <td>{{service.id}}</td>
                  <td>{{service.name}}</td>
                  <td>{{service.description}}</td>
                  <td>{{service.price}}</td>
                  <td>{{service.time_services}}</td>

                <!--
                  <td>
                    <div class="widget-user-image">
                        <img class="img-circle" :src="'icon/companies/'+category.logo" alt="User Avatar">
                    </div>
                  </td>
                      <td>{{category.created | myDate}}</td> -->
                      <td>
                  <a href="#" > <i class="fas fa-edit" @click="updateModal(service)"> </i>
                  </a>
                    /
                  <a href="#" @click="deleteUser(service.id)"> <i class="fas fa-trash red"> </i>
                  </a>

                  </td>
                  </tr>


                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

                <div class="card-footer">
                    <pagination :data="services.data"
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
<div class="modal fade " id="addNewUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"  v-show="!editeMode" id="exampleModalLabel">اضافة خدمة</h5>
          <h5 class="modal-title" v-show="editeMode" id="updateModaleTitle">تعديل بيانات خدمة</h5>


          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin:-1rem -1rem -1rem !important">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form  @submit.prevent="editeMode ? updateServce() :createService()">
      <div class="modal-body">
                <div class="row container-fluid">
    <div class="col-md-4">
        <div class="form-group">
              <select v-model="form.servicetype_id" name="servicetype_id"  placeholder="" id="servicetype_id"
                      class="form-control" :class="{'is-invalid':form.errors.has('servicetype_id')}" >
                  <option value="0">اختيار نوع الخدمة </option>
                  <option v-for="option in servicestypes" :key="option.id" :value="option.id">{{option.name}}</option>
              </select>
              <has-error :form="form" field="servicetype_id"></has-error>

          </div>
    </div>

            <div class="form-group col-md-4">

        <input v-model="form.name" type="text" name="name"  placeholder="اسم الخدمة  "
               class="form-control" :class="{'is-invalid':form.errors.has('name')}" >
            <has-error :form="form" field="name"></has-error>
            </div>


          <div class="form-group col-md-6">
              <textarea v-model="form.description" name="description"  placeholder="اضافة وصف مختصر (اختياري )" id="bio"
                        class="form-control" :class="{'is-invalid':form.errors.has('description')}" ></textarea>
              <has-error :form="form" field="description"></has-error>
          </div>



        <div class="form-group col-md-4">
        <input v-model="form.price" type="number" name="price"  placeholder="سعر الخدمة"
               class="form-control" :class="{'is-invalid':form.errors.has('price')}" >
            <has-error :form="form" field="price"></has-error>

        </div>

        <div class="form-group col-md-4">

<input v-model="form.time_services" type="text" name="time_services"  placeholder="زمن الخدمة  "
       class="form-control" :class="{'is-invalid':form.errors.has('time_services')}" >
    <has-error :form="form" field="time_services"></has-error>
    </div>
        <!-- <div class="form-group col-md-4">
        <input v-model="form.count" type="number" name="count"  placeholder="عدد الدواء"
               class="form-control" :class="{'is-invalid':form.errors.has('count')}" >
            <has-error :form="form" field="count"></has-error>

        </div> -->

        <div class="form-group col-md-6">
             <label for="inputSkills" class="col-sm-2 col-form-label">الصورة</label>
                 <div class="col-sm-10">
                    <input type="file" @change="uploadIcon" name="icon" class="form-control" id="inputSkills" placeholder="الصورة">
                </div>
        </div>



        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">اعلاق</button>
        <button v-show="editeMode" type="submit" class="btn btn-primary">تعديل </button>
          <button v-show="!editeMode" type="submit" class="btn btn-primary">حقظ</button>
      </div>
        </form>

    </div>
  </div>
</div>

<!-- end Modal -->
        <!-- <drug-company ></drug-company> -->

    </div>
</v-app>
</template>

<script>
import DrugCompany from './DrugCompany.vue'
    export default {
            components:{
                'drug-company':DrugCompany
            },

       data(){
            return{
                editeMode:false,
                services:{},
                servicestypes:{},
                drugsSelect:{},
                companyDialog:false,
                companyList:[],
                PharmaceuticalformList:[],
                nameScinces:[],
                loading:true,
                form :new Form({
                    id:'',
                    name:'',
                    description:'',
                    price:'',
                    count:'',
                    icons:'',
                    servicetype_id:'0',
                    time_services:''
                })
            }
        },

        methods:{
            changeActive(id){
                this.$Progress.start()
                axios.get('api/admin/drugs/'+id+'/operation')
                .then(()=>{
                    Swal.fire('تفعيل!','تم العملية بنجاح','success')
                    Fire.$emit('AfterCreated')
                })
                .catch(()=>{
                    Swal.fire('فشل','حدث خطاء ماء  ','warning')
                    this.$Progress.fail()
                })
            },
            updateModal(categoryDate){
                console.log(categoryDate)
                this.editeMode=true
                this.getServicesType()
                $('#addNewUserModal').modal('show')
                this.form.reset()
                this.form.fill(categoryDate)
            },

            newModal(){
                this.editeMode=false
                this.getServicesType()
                this.form.reset()
                $('#addNewUserModal').modal('show')

            },

            getServicesType(){
                if(this.$gate.isAdminOrAuther()){
                axios.get('api/admin/servicesTypes')
                .then(({data})=>{
                    this.servicestypes=data.data
                       console.log(data.data)
                })}
            },

            getPharmaceuticalformList(){
                if(this.$gate.isAdminOrAuther()){
                axios.get('api/admin/pharmaceuticalforms')
                .then(({data})=>{
                    this.PharmaceuticalformList=data.data
                })}

            },
            loadServices(){
                if(this.$gate.isAdminOrAuther()){
                    var salon_id = window.user.salone_id    
                axios.get('api/admin/salons/'+salon_id+'/services?admin=admin')
                .then(({data})=>{
                    console.log(data)
                    this.$Progress.finish();
                    this.services=data
                    this.loading=false
                })}
            },

            updateServce(id){
                this.$Progress.start()
                var salon_id = window.user.salone_id;
              this.form.put('api/admin/salons/'+salon_id+'/services/'+this.form.id)
                .then(()=>{
                    $('#addNewUserModal').modal('hide')
                    Swal.fire('تعديل!','تم التعيل بنجاح','success')

                    Fire.$emit('AfterCreated')
                    this.$Progress.finish()
                })
                .catch(()=>{
                    Swal.fire('قشل ','هناك خطاء ماء ','warning')
                    this.$Progress.fail()
                })
            },

            deleteUser(id){
                Swal.fire({
                    title: 'هل انت متاكد?',
                    text: "يمكنك الرجوع عن خذه العملية!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText:' لا | خروج ',
                    confirmButtonText: 'نعم امسحه!'
                }).then((result) => {
                    if (result.value) {
                        // send ajax requestto delete
                        this.form.delete('api/admin/services/'+id).then(()=>{
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
              axios.get('api/admin/drugs?admin=admin&page='+page)
              .then(response=>{
                  this.categories=response.data
              })
            },
          createService(){
              this.$Progress.start();
              var salon_id = window.user.salone_id 
              this.form.post('api/admin/salons/'+salon_id+'/services')
              .then(()=>{

                  $('#addNewUserModal').modal('hide')

                  Toast.fire({
                      icon: 'success',
                      title: 'تمت الاضافة بنجاح'

                  })

                  this.$Progress.finish();

                  Fire.$emit('AfterCreated');
              })
              .catch(()=>{

              })

          },

        uploadIcon(e){
                let file=e.target.files[0];
                console.log((file))
                var reader=new FileReader()
                if(file['size']<2111775) {
                    reader.onloadend = (file) => {
                        console.log('Result ',reader.result)
                        this.form.icons = reader.result
                    }
                }else{
                    Swal.fire('Failed','The Image Is More Than 10MB','warning')

                }

                reader.readAsDataURL(file)
            },

            getIcon(){
                let photo=(this.form.icons.length>200) ? this.form.icons:"icon/drugs/"+this.form.icons
                return photo
            },

            showCompanyDialog(drugItem){
                // this.drugsSelect=drugItem
                // this.companyDialog=true

                 Fire.$emit('showCompanyDialog',{companyDialog:true,drugItem:drugItem});
            },




                    loadCompany(){
                    if(this.$gate.isAdminOrAuther()){
                    axios.get('api/admin/companies')
                    .then(({data})=>{
                        this.companyList=data.data
                    })}
        },

        addnewCompanies(){
            this.form.newDrugCompanies.push({
                companies_id:'',
                    price:'',
                    amount:''
            });
            this.loadCompany()
        },

        deleteCompany(item){
            this.form.newDrugCompanies.splice(this.form.newDrugCompanies.indexOf(item),1)
        },

                getNameScinces(){
                    if(this.$gate.isAdminOrAuther()){
                    axios.get('api/admin/nameScinces')
                    .then(({data})=>{
                        this.nameScinces=data.data
                    })}
                }

        },

        created() {
            this.$Progress.start();
            this.loadServices()

            Fire.$on('AfterCreated',()=>{
                this.loadCategories()
            })

            Fire.$on('closeDialogCompalny',()=>{
                this.companyDialog=false
            })

            Fire.$on("Searching",()=>{
                let query=this.$parent.search
                axios.get('api/drugs?admin=admin&q='+query)
                .then((data)=>{
                    this.categories=data.data
                })
                .catch(()=>{

                })
            })

            // setInterval(()=>this.loadCategories(),3000)
            //this.$Progress.finish();
        },
        //
        // mounted() {
        //console.log('Component mounted.')
        // }
    }
</script>
