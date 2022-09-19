<template>
<v-app>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuther()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">جدول الاقسام الفرعية  </h3>

                <div class="card-tools">
                 <div class="row">
                    <div class="col-sm">
                  <button class="btn btn-primary" data-toggle="modal" @click="newModal()">اضافة <i class="fas fa-user-plus"></i></button>
                </div>

                <div class="col-md-auto">

              <select v-model="cat_id_search"
              @change="filtterData()"
                class="form-control">
                  <option value=""> كل الاقسام </option>
                  <option v-for="option in categoriesDrowpDown" :key="option.id" :value="option.id">{{option.name}}</option>
              </select>

                </div>

                </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>الرقم</th>
                      <th>اسم القسم الفرعي </th>
                      <th>الوصف </th>
                      <th>التفعيل</th>
                        <th>الانشاء</th>
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

                  <tr v-for="category in categories.data " :key="category.id">
                  <td>{{category.id}}</td>
                  <td>{{category.name}}</td>
                  <td>{{category.description}}</td>
                 <td>
                        <v-switch
                        @change="changeActive(category.id)"
                        :color="category.active? '#3f51b5' : '#b71c1c'"
                        :success="category.active? true:false"
                        hide-details
                        :input-value="category.active"
                        ></v-switch>
                  </td>

                      <td>{{category.created | myDate}}</td>
                      <td>
                  <a href="#" > <i class="fas fa-edit" @click="updateModal(category)"> </i>
                  </a>
                    /
                  <a href="#" @click="deleteUser(category.id)"> <i class="fas fa-trash red"> </i>
                  </a>

                  </td>
                  </tr>


                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

                <div class="card-footer">
                    <pagination :data="categories"
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
<div class="modal fade" id="addNewUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"  v-show="!editeMode" id="exampleModalLabel">اضافة قسم</h5>
          <h5 class="modal-title" v-show="editeMode" id="updateModaleTitle">تعديل بيانات قسم</h5>


          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin:-1rem -1rem -1rem !important">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form @submit.prevent="editeMode ? updateCategory() :createCategory()">
      <div class="modal-body">
        <div class="form-group">
        <input v-model="form.name" type="text" name="name"  placeholder="اسم الصنف "
               class="form-control" :class="{'is-invalid':form.errors.has('name')}" >
            <has-error :form="form" field="name"></has-error>

        </div>


          <div class="form-group">
              <textarea v-model="form.description" name="description"  placeholder="اضافة وصف مختصر (اختياري )" id="bio"
                        class="form-control" :class="{'is-invalid':form.errors.has('description')}" ></textarea>
              <has-error :form="form" field="description"></has-error>

          </div>

        <div class="form-group">
              <select v-model="form.category_id" name="category_id"  placeholder="" id="category_id"
                      class="form-control" :class="{'is-invalid':form.errors.has('category_id')}" >
                  <option value="">اختيار الصنف </option>
                  <option v-for="option in categoriesDrowpDown" :key="option.id" :value="option.id">{{option.name}}</option>
              </select>
              <has-error :form="form" field="category_id"></has-error>

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

    </div>
</v-app>
</template>

<script>
    export default {

        data(){
            return{
                editeMode:false,
                categories:{},
                querySearch:'',
                cat_id_search:'',
                categoriesDrowpDown:[],
                loading:true,
                form :new Form({
                    id:'',
                    name:'',
                    description:'',
                    category_id:'',

                })
            }
        },

        methods:{
            changeActive(id){
                this.$Progress.start()
                axios.get('api/admin/departments/'+id+'/operation')
                .then(({data})=>{
                    if(data.activated)
                    Swal.fire('تفعيل!','تم التفعيل بنجاح','success')
                    else
                    Swal.fire('تعطيل!','تم التعطيل بنجاح','success')
                    Fire.$emit('AfterCreated')
                })
                .catch(()=>{
                    Swal.fire('فشل','حدث خطاء ماء  ','warning')
                    this.$Progress.fail()
                })
            },

            filtterData(){
                this.querySearch='category_id='+this.cat_id_search+'&'

                this.loadCategories()
            },

            updateModal(categoryDate){
                this.editeMode=true
                this.getCategories()
                $('#addNewUserModal').modal('show')
                this.form.reset()
                this.form.fill(categoryDate)
            },

            newModal(){
                this.editeMode=false
                this.getCategories()
                this.form.reset()
                $('#addNewUserModal').modal('show')

            },

            loadCategories(){
                if(this.$gate.isAdminOrAuther()){
                axios.get('api/admin/departments?admin=admin&'+this.querySearch)
                .then(({data})=>{
                    this.categories=data.data
                    this.loading=false
                })}
            },

            updateCategory(id){
                this.$Progress.start()
              this.form.put('api/admin/departments/'+this.form.id)
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
                        this.form.delete('api/admin/departments/'+id).then(()=>{
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
              axios.get('api/admin/departments?admin=admin&page='+page)
              .then(response=>{
                  this.categories=response.data.data
              })
            },
          createCategory(){
              this.querySearch='';
              this.$Progress.start();
              this.form.post('api/admin/departments')
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

          getCategories(){
              if(this.$gate.isAdminOrAuther()){
                  axios.get('api/admin/categories')
                  .then(({data})=> {
                      this.categoriesDrowpDown=data.data
                      }  )
              }
          }

        },

        created() {
            //this.$Progress.start();
            this.loadCategories()
            this.getCategories()

            Fire.$on('AfterCreated',()=>{
                this.loadCategories()
            })

            Fire.$on("Searching",()=>{
                let query=this.$parent.search
                axios.get('api/findCategory?q='+query)
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
