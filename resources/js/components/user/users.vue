<template>
<v-app>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuther()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">جدول المستخدمين</h3>

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
                      <th>اسم المستخدم </th>
                      <th>البريد للدخول</th>
                      <th>النوع</th>
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

                  <tr v-for="user in users.data " :key="user.id">
                  <td>{{user.id}}</td>
                  <td>{{user.name}}</td>
                  <td>{{user.email}}</td>
                  <td><span class="tag tag-success">{{user.role | upText}}</span></td>
                      <td>{{user.created | myDate}}</td>
                      <td>
                  <a href="#" > <i class="fas fa-edit" @click="updateModal(user)"> </i>
                  </a>
                    /
                  <a href="#" @click="deleteUser(user.id)"> <i class="fas fa-trash red"> </i>
                  </a>

                  </td>
                  </tr>


                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

                <div class="card-footer">
                    <pagination :data="users"
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
        <h5 class="modal-title"  v-show="!editeMode" id="exampleModalLabel">اضافة مستخدم</h5>
          <h5 class="modal-title" v-show="editeMode" id="updateModaleTitle">تعديل بيانات مستخدم</h5>


          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin:-1rem -1rem -1rem !important">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form @submit.prevent="editeMode ? updateUser() :createUser()">
      <div class="modal-body">
        <div class="form-group">
        <input v-model="form.name" type="text" name="name"  placeholder="اسم المستخدم "
               class="form-control" :class="{'is-invalid':form.errors.has('name')}" >
            <has-error :form="form" field="name"></has-error>

        </div>

          <div class="form-group">
              <input v-model="form.email" type="text" name="email"  placeholder="البريد الالكتروني"
                     class="form-control" :class="{'is-invalid':form.errors.has('email')}" >
              <has-error :form="form" field="email"></has-error>

          </div>

          <div class="form-group">
              <textarea v-model="form.bio" name="bio"  placeholder="اضافة وصف مختصر (اختياري )" id="bio"
                        class="form-control" :class="{'is-invalid':form.errors.has('bio')}" ></textarea>
              <has-error :form="form" field="bio"></has-error>

          </div>

          <div class="form-group">
              <select v-model="form.role" name="type"  placeholder="نوع المستخدم  (اختياري ) " id="role"
                        class="form-control" :class="{'is-invalid':form.errors.has('role')}" >
              <option value="">صلاحية ونوع المستخدم </option>
                  <option value="admin">Admin</option>
                  <option value="user">User</option>
                  <!-- <option value="author">Auther</option> -->
              </select>
              <has-error :form="form" field="role"></has-error>

          </div>

          <div class="form-group">
              <input v-model="form.password" type="password" name="password"  placeholder="كلمة السر "
                     class="form-control" :class="{'is-invalid':form.errors.has('password')}" >
              <has-error :form="form" field="password"></has-error>

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
                users:{},
                loading:true,
                form :new Form({
                    id:'',
                    name:'',
                    email:'',
                    password:'',
                    role:'',
                    bio:'',
                    photo:''
                })
            }
        },

        methods:{

            updateModal(userData){
                this.editeMode=true
                $('#addNewUserModal').modal('show')
                this.form.reset()
                this.form.fill(userData)
            },

            newModal(){
                this.editeMode=false
                this.form.reset()
                $('#addNewUserModal').modal('show')

            },

            loadUsers(){
                if(this.$gate.isAdminOrAuther()){
                axios.get('api/admin/users')
                .then(({data})=>{
                    this.users=data
                    this.loading=false

                }).catch((e)=>{
                    console.log(e)
                })

                }
            },

            updateUser(id){
                this.$Progress.start()
              this.form.put('api/admin/users/'+this.form.id)
                .then(()=>{
                    $('#addNewUserModal').modal('hide')
                    Swal.fire('تعديل!','تم تعديل البيانات بنجاح  ','success')
                    Fire.$emit('AfterCreated')
                    this.$Progress.finish()
                })
                .catch(()=>{
                    Swal.fire('فشل',' خطاء في العديل  ','warning')
                    this.$Progress.fail()
                })
            },

            deleteUser(id){
                Swal.fire({
                    title: 'هل انت ماكد؟',
                    text: "انك ريد حذف بيانات هذا المستخدم !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText:' لا | خروج ',
                    confirmButtonText: 'نعم, امسحه !'
                }).then((result) => {
                    if (result.value) {
                        // send ajax requestto delete
                        this.form.delete('api/admin/users/'+id).then(()=>{
                            Swal.fire(
                                'حذق!',
                                'تم الحذف بنجاح .',
                                'success'
                            )

                            Fire.$emit('AfterCreated')

                        })
                    }
                })
                .catch(()=>{
                    Swal.fire('فشل','هناك خطاء ماء ','warning')
                })

            },

            getResults(page=1){
              axios.get('api/admin/users?page='+page)
              .then(response=>{
                  this.users=response.data
              })
            },
          createUser(){
              this.$Progress.start();
              this.form.post('api/admin/users')
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

          }
        },

        created() {
            //this.$Progress.start();
            this.loadUsers()

            Fire.$on('AfterCreated',()=>{
                this.loadUsers()
            })

            Fire.$on("Searching",()=>{
                let query=this.$parent.search
                axios.get('api/admin/findUser?q='+query)
                .then((data)=>{
                    this.users=data.data
                })
                .catch(()=>{

                })
            })

            // setInterval(()=>this.loadUsers(),3000)
            //this.$Progress.finish();
        },
        //
        mounted() {
            console.log(this.$gate.user)
            console.log('Component mounted.')
        }
    }
</script>
