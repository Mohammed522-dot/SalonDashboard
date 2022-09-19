<template>
<v-app>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuther()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">جدول الاسم العلمي </h3>

                <div class="card-tools">
                  <button class="btn btn-primary" data-toggle="modal" @click="newModal()">اضافة <i class="fas fa-user-plus"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr style="text-align: center;">
                      <th>الرقم</th>
                      <th>الاسم </th>
                      <th>الوصف </th>
                      <th> عدد الادوية </th>
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
                  <tbody style="text-align: center;">
                   <td style="text-align: center;" v-if="loading" colspan="6"> انتظر جاري التحميل ...... </td>
                  <tr v-for="category in nameScinces.data " :key="category.id">
                  <td>{{category.id}}</td>
                  <td>{{category.name}}</td>
                  <td style="width: 10px;">{{category.description}}</td>

                  <td>{{category.drugs_count}}</td>
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
                    <pagination :data="nameScinces"
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
        <input v-model="form.name" type="text" name="name"  placeholder="الاسم العلمي"
               class="form-control" :class="{'is-invalid':form.errors.has('name')}" >
            <has-error :form="form" field="name"></has-error>

        </div>


          <div class="form-group">
              <textarea v-model="form.description" name="description"  placeholder="اضافة وصف مختصر (اختياري )" id="bio"
                        class="form-control" :class="{'is-invalid':form.errors.has('description')}" ></textarea>
              <has-error :form="form" field="description"></has-error>

          </div>


          <!-- <div class="form-group">
              <select v-model="form.type" name="type"  placeholder="نوع المستخدم  (اختياري ) " id="type"
                        class="form-control" :class="{'is-invalid':form.errors.has('type')}" >
              <option value="">صلاحية ونوع المستخدم </option>
                  <option value="admin">Admin</option>
                  <option value="user">User</option>
                  <option value="author">Auther</option>
              </select>
              <has-error :form="form" field="type"></has-error>

          </div> -->



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
                loading:true,
                nameScinces:[],
                form :new Form({
                    id:'',
                    name:'',
                    description:'',

                })
            }
        },

        methods:{

            updateModal(categoryDate){
                this.editeMode=true
                $('#addNewUserModal').modal('show')
                this.form.reset()
                this.form.fill(categoryDate)
            },

            newModal(){
                this.editeMode=false
                this.form.reset()
                $('#addNewUserModal').modal('show')

            },

            loadnameScinces(){
                if(this.$gate.isAdminOrAuther()){
                axios.get('api/admin/nameScinces')
                .then(({data})=>{
                    this.nameScinces=data
                    this.loading=false
                })}
            },

            updateCategory(id){
                this.$Progress.start()
              this.form.put('api/admin/nameScinces/'+this.form.id)
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
                        this.form.delete('api/admin/nameScinces/'+id).then(()=>{
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
              axios.get('api/admin/nameScinces?page='+page)
              .then(response=>{
                  this.nameScinces=response.data
              })
            },
          createCategory(){
              this.$Progress.start();
              this.form.post('api/admin/nameScinces')
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

        uploadIcon(e){
                let file=e.target.files[0];
                console.log((file))
                var reader=new FileReader()
                if(file['size']<2111775) {
                    reader.onloadend = (file) => {
                        console.log('Result ',reader.result)
                        this.form.icon = reader.result
                    }
                }else{
                    Swal.fire('Failed','The Image Is More Than 10MB','warning')

                }

                reader.readAsDataURL(file)
            },

            getIcon(){
                let photo=(this.form.icon.length>200) ? this.form.icon:"icon/Medicinesections/"+this.form.icon
                return photo
            }
        },

        created() {
            //this.$Progress.start();
            this.loadnameScinces()

            Fire.$on('AfterCreated',()=>{
                this.loadnameScinces()
            })

            Fire.$on("Searching",()=>{
                let query=this.$parent.search
                axios.get('api/findCategory?q='+query)
                .then((data)=>{
                    this.nameScinces=data.data
                })
                .catch(()=>{

                })
            })

            // setInterval(()=>this.loadnameScinces(),3000)
            //this.$Progress.finish();
        },
        //
        // mounted() {
        //console.log('Component mounted.')
        // }
    }
</script>
