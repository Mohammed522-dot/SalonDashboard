<style>
    .widget-user-header{
        background-position: center center;
        background-size: cover;
        height: 250px;
    }
</style>

<template>
    <div class="container">
        <div class="row ">
            <div class="col-md-12 mt-3">
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header text-white" style="background-image: url('http://127.0.0.1:8000/image/logo.jpg')">
                        <h3 class="widget-user-username text-right">Elizabeth Pierce</h3>
                        <h5 class="widget-user-desc text-right">Web Designer</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" :src="'logo.jpg'" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">3,200</h5>
                                    <span class="description-text">المبيعات</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">13,000</h5>
                                    <span class="description-text">عدد الفواتير </span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">35</h5>
                                    <span class="description-text">المنتجات</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">الرسائل</a></li>

                                            <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">اعدادت الحساب</a></li>
                                        </ul>
                                    </div><!-- /.card-header -->
                                    <div class="card-body text-right">
                                        <div class="tab-content">
                                            <div class="tab-pane" id="activity">
                                                <!-- Post -->
                                                <!-- /.post -->

                                                <!-- Post -->
                                                <!-- /.post -->

                                                <!-- Post -->
                                                <!-- /.post -->
                                            </div>
                                            <!-- /.tab-pane -->

                                            <!-- /.tab-pane -->

                                            <div class="tab-pane active" id="settings">
                                                <form class="form-horizontal">
                                                    <div class="form-group row">
                                                        <label for="inputName" class="col-sm-2 col-form-label">الاسم</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" v-model="form.name" class="form-control" id="inputName" placeholder="الاسم">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail" class="col-sm-2 col-form-label">البريد الاكتروني</label>
                                                        <div class="col-sm-10">
                                                            <input type="email" v-model="form.email" class="form-control" id="inputEmail" placeholder="البريد الاكتروني">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputExperience" class="col-sm-2 col-form-label">كلمة المرور</label>
                                                        <div class="col-sm-10">
                                                            <input type="password" v-model="form.password" class="form-control" id="password" placeholder="كلمة المرور">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <!-- <label for="inputSkills" class="col-sm-2 col-form-label">الصورة</label>
                                                        <div class="col-sm-10">
                                                            <input type="file" @change="updateProfile" name="photo" class="form-control" id="inputSkills" placeholder="الصورة">
                                                        </div> -->
                                                    </div>
                                                    <!-- <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button type="submit"  @click.prevent="updateInfo" class="btn btn-danger">Update</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                    </div><!-- /.card-body -->
                                </div>
                                <!-- /.nav-tabs-custom -->
                            </div>

                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                form :new Form({
                    id:'',
                    name:'',
                    email:'',
                    type:'',
                    password:'',
                    photo:''
                })

            }
        },

        mounted() {
            console.log('Component mounted.')
        },

        created(){
            axios.get('api/profile')
            .then(({data})=>{
                console.log(data)
                this.form.fill(data)
            })
        },

        methods:{
            updateInfo(){
                this.$Progress.start()
              this.form.put('api/admin/profile/'+this.form.id)
              .then(()=>{
                  Swal.fire('Updated!','Updated Profile Successfully ','success')
                  Fire.$emit('AfterCreated')
                  this.$Progress.finish()

              })
              .catch(()=>{
                  Swal.fire('Failed','There was Somthing Wrong ','warning')
                  this.$Progress.finish()
              })
            },

            updateProfile(e){
                let file=e.target.files[0];
                console.log((file))
                var reader=new FileReader()
                if(file['size']<2111775) {
                    reader.onloadend = (file) => {
                        // console.log('Result ',reader.result)
                        this.form.photo = reader.result
                    }
                }else{
                    Swal.fire('Failed','The Image Is More Than 10MB','warning')

                }

                reader.readAsDataURL(file)
            },

            getProfilePhoto(){
                let photo=(this.form.photo.length>200) ? this.form.photo:"image/profile/"+this.form.photo
                return photo
            }
        }



    }
</script>
