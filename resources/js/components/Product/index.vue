<template>
<v-app>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuther()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">جدول المنتجات</h3>

                <div class="card-tools">
                <div class="row no-gutters-0 pa-2">
                 <div class="col">
                  <button class="btn btn-primary" data-toggle="modal" @click="newModal()">اضافة <i class="fas fa-user-plus"></i></button>
                </div>
                 <div class="col">
                    <select v-model="cat_id_search"
                    @change="getSubCategories()"
                        class="form-control">
                        <option value=""> كل الاقسام </option>
                        <option v-for="option in mainCategories" :key="option.id" :value="option.id">{{option.name}}</option>
                    </select>
                </div>

                 <div class="col">
                    <select v-model="subcat_id_search"
                    @change="filtterData()"
                        class="form-control">
                        <option value="">  كل الاقسام الفرعية</option>
                        <option v-for="option in subCategoriesDrowpDown" :key="option.id" :value="option.id">{{option.name}}</option>
                    </select>
                </div>

                </div> <!-- end Row-->
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>الرقم</th>
                      <th>اسم المنتج </th>
                      <th>الوصف </th>
                      <th>السعر </th>
                      <th>العدد </th>
                      <th> يتبع لقسم </th>
                      <th>التفعيل</th>

                        <th>الصورة</th>
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
                        <v-chip
                        class="ma-2 text-light"
                        color="green"
                        >
                        {{category.price}}
                        </v-chip>
                      </td>
                  <td>{{category.count}}</td>
                  <td>
                      <div v-if="category.departments.length <= 0">
                              <v-alert v-if="category.departments.length <= 0" type="error"
                                color="#b71c1c"
                                class="subtitle-2 text-center"
                                dense
                                outlined
                              >
                                لاينتمي الي اي قسم
                            </v-alert>
                      </div>
                <!-- <template>
                <v-row justify="center">
                    <v-dialog
                    v-model="dialog"
                    persistent
                    max-width="290"
                    >
 -->

                    <!-- <template v-slot:activator="{ on , attrs }"> -->

                    <!-- <v-chip
                    class="ma-2"
                    color="green"
                    outlined
                        v-bind="attrs"
                        v-on="on"
                    @click="showCat(category)"
                    >
                    اضافة لقسم جديد
                                        </v-chip>
                    </template>

                    <v-card>
                        <v-card-title class="headline">
                        الرجاء اختيار الفسم ؟
                        </v-card-title>
                        <v-card-text>
                        <v-row
                            align="center"
                            justify="start"
                        >
                            <v-col
                            v-for="(selection, i) in selections"
                            :key="selection.id"
                            class="shrink"
                            >
                            <v-chip
                                :disabled="loadingCategories"
                                close
                                @click:close="selected.splice(i, 1)"
                            >
                                <v-icon
                                left
                                v-text="selection.name"
                                ></v-icon>
                                {{ selection.name }}
                            </v-chip>
                            </v-col>
                        </v-row>

                       <v-divider v-if="!allSelected"></v-divider>

    <v-list>
      <template v-for="item in subCategoriesDrowpDown">
        <v-list-item
          v-if="!selected.includes(item)"
          :key="item.id"
          :disabled="loadingCategories"
          @click="selected.push(item)"
        >
          <v-list-item-avatar>
            <v-icon
              :disabled="loadingCategories"
              v-text="'mdi-dialpad'"
            ></v-icon>
          </v-list-item-avatar>
          <v-list-item-title v-text="item.name"></v-list-item-title>
        </v-list-item>
      </template>
    </v-list>

    <v-divider></v-divider>

                        </v-card-text>
                        <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="green darken-1"
                            text
                            @click="dialog = false"
                        >
                            خروج
                        </v-btn>
                        <v-btn
                            color="green darken-1"
                            text
                            @click="next"
                            :disabled="!selected.length"
                            :loading="loadingCategories"
                        >
                            موافقة
                        </v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-dialog>
                </v-row>
                </template> -->

                      <div class="text-center"
                        v-for="depts in category.departments "
                        :key="depts.id"
                      >
    <v-chip
      class="ma-2"
      close
      color="green"
      outlined
      @click:close="categories.departments.splice(categories.departments.indexOf(depts),1)"
    >
                        {{depts.name}}
    </v-chip>



                      </div>

                  </td>

                 <td>
                        <v-switch
                        @change="changeActive(category.id)"
                        :color="category.active? '#3f51b5' : '#b71c1c'"
                        :success="category.active? true:false"
                        hide-details
                        :input-value="category.active"
                        ></v-switch>
                  </td>

                  <td>
                    <div class="widget-user-image">
                        <img class="img-circle"  height="60" :src="'icon/Products/'+category.image" alt="User Avatar">
                    </div>

                    </td>
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
        <h5 class="modal-title"  v-show="!editeMode" id="exampleModalLabel">اضافة منتج</h5>
          <h5 class="modal-title" v-show="editeMode" id="updateModaleTitle">تعديل بيانات منتج</h5>


          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin:-1rem -1rem -1rem !important">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form @submit.prevent="editeMode ? updateCategory() :createCategory()">
      <div class="modal-body">
        <div class="form-group">
        <input v-model="form.name" type="text" name="name"  placeholder="اسم المنتج "
               class="form-control" :class="{'is-invalid':form.errors.has('name')}" >
            <has-error :form="form" field="name"></has-error>

        </div>


          <div class="form-group">
              <textarea v-model="form.description" name="description"  placeholder="اضافة وصف مختصر (اختياري )" id="bio"
                        class="form-control" :class="{'is-invalid':form.errors.has('description')}" ></textarea>
              <has-error :form="form" field="description"></has-error>

          </div>

        <div class="form-group">
        <input v-model="form.price" type="number" name="price"  placeholder="سعر المنتج"
               class="form-control" :class="{'is-invalid':form.errors.has('price')}" >
            <has-error :form="form" field="price"></has-error>

        </div>
        <div class="form-group">
        <input v-model="form.count" type="number" name="count"  placeholder="العدد"
               class="form-control" :class="{'is-invalid':form.errors.has('count')}" >
            <has-error :form="form" field="count"></has-error>
        </div>

        <div class="form-group">
              <select v-model="cat_id_search" name="category_id"
               @change="getSubCategories"
               placeholder="" id="category_id"
                      class="form-control" :class="{'is-invalid':form.errors.has('category_id')}" >
                  <option value="">اختيار القسم الرئيسي </option>
                  <option v-for="option in mainCategories" :key="option.id" :value="option.id">{{option.name}}</option>
              </select>
              <has-error :form="form" field="category_id"></has-error>
          </div>

        <div class="form-group">


        <v-select
          v-model="form.subCategorie_id"
          :items="subCategoriesDrowpDown"
          item-text="name"
          item-value="id"
          :menu-props="{ maxHeight: '400' }"
          label="القسم الفرعي"
          multiple
          hint="الرجاء اختيار قسم علي الاقل"
          persistent-hint
        ></v-select>
              <!-- <select v-model="form.subcategory_id" name="category_id"  placeholder="" id="category_id"
                      class="form-control" :class="{'is-invalid':form.errors.has('category_id')}" >
                  <option value="">اختيار القسم الفرعي علي الاقل واحد </option>
                  <option v-for="option in subCategoriesDrowpDown" :key="option.id" :value="option.id">{{option.name}}</option>
              </select> -->
              <has-error :form="form" field="category_id"></has-error>
          </div>



        <!-- <div class="form-group">
              <select v-model="form.category_id" name="category_id"  placeholder="" id="category_id"
                      class="form-control" :class="{'is-invalid':form.errors.has('category_id')}" >
                  <option value="">اختيار الصنف </option>
                  <option v-for="option in categories" :key="option.id" :value="option.id">{{option.name}}</option>
              </select>
              <has-error :form="form" field="category_id"></has-error>

          </div> -->

        <div class="form-group">
             <label for="inputSkills" class="col-sm-2 col-form-label">الصورة</label>
                 <div class="col-sm-10">
                    <input type="file" @change="uploadIcon" name="icon" class="form-control" id="inputSkills" placeholder="الصورة">
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

    </div>
</v-app>
</template>

<script>
    export default {

        data(){
            return{
                editeMode:false,
                cat_id_search:'',
                subcat_id_search:'',
                subCategorie_id:[],
                querySearch:'',
                categories:{},
                loading:true,
                loadingCategories:false,
                subCategoriesDrowpDown:[],
                mainCategories:[],
                dialog:false,
                productUpdate:{},
                selected:[],
                form :new Form({
                    id:'',
                    name:'',
                    subCategorie_id:[],
                    description:'',
                    price:0,
                    count:0,
                    image:'',
                })
            }
        },

        methods:{
            changeActive(id){
                this.$Progress.start()
                axios.get('api/admin/products/'+id+'/operation')
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
            this.loading=true
            if(this.subcat_id_search == '')
            {
                this.loadCategories()
                this.loading=false
                return
            }
            if(this.$gate.isAdminOrAuther()){
                axios.get('api/admin/departments/'+this.subcat_id_search+'/products')
                .then(({data})=>{
                    this.categories=data
                    this.loading=false
                })
                .catch(()=>{
                    this.loadCategories()
                    this.loading=false

                })
                }
            },
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

            loadCategories(){
                if(this.$gate.isAdminOrAuther()){
                axios.get('api/admin/products?admin=admin&'+this.querySearch)
                .then(({data})=>{
                    this.categories=data.data
                    this.loading=false
                })}
            },

            updateCategory(id){
                this.$Progress.start()
              this.form.put('api/admin/products/'+this.form.id)
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
                        this.form.delete('api/admin/products/'+id).then(()=>{
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
              axios.get('api/admin/products?admin=admin&page='+page)
              .then(response=>{
                  this.categories=response.data.data
              })
            },
          createCategory(){
              this.$Progress.start();
              this.form.post('api/admin/products')
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
                      this.mainCategories=data.data
                      }  )
              }
          },

          getSubCategories(){
              this.subCategoriesDrowpDown=[]
              if(this.$gate.isAdminOrAuther()){
                  axios.get('api/admin/categories/'+this.cat_id_search+'/departments')
                  .then(({data})=> {
                      this.subCategoriesDrowpDown=data.data
                      }  )
              }
          },


         uploadIcon(e){
                let file=e.target.files[0];
                var reader=new FileReader()
                if(file['size']<2111775) {
                    reader.onloadend = (file) => {
                        this.form.image = reader.result
                    }
                }else{
                    Swal.fire('Failed','The Image Is More Than 10MB','warning')

                }

                reader.readAsDataURL(file)
            },

            getIcon(){
                let photo=(this.form.image.length>200) ? this.form.image:"icon/Products/"+this.form.image
                return photo
            },

showCat(cat){
    this.productUpdate = cat
    this.getSubCategories()
},

     next () {
        this.loadingCategories = true

            axios.post('api/admin/products/'+this.productUpdate.id+'/subcategories',
            {
                sub_categories: this.selected
            }

            )
              .then(response=>{
                 Fire.$emit('AfterCreated');
                 this.dialog = false
              })

        setTimeout(() => {
        //   this.search = ''
          this.selected = []
          this.loadingCategories = false
        }, 2000)

      },

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
                axios.get('api/products?q='+query)
                .then((data)=>{
                    this.categories=data.data
                })
                .catch(()=>{

                })
            })

            // setInterval(()=>this.loadCategories(),3000)
            //this.$Progress.finish();
        },

    watch: {
      selected () {
        // this.search = ''
      },
    },

        computed:{
        selections () {
        const selections = []

        for (const selection of this.selected) {
          selections.push(selection)
        }

        return selections
      },


    allSelected () {
        return this.selected.length === this.subCategoriesDrowpDown.length
      },

        }
        //
        // mounted() {
        //console.log('Component mounted.')
        // }
    }
</script>
