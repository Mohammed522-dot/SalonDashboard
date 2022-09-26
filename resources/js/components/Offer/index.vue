<template>
<v-app>

    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuther()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">جدول العروض</h3>

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
                      <th>اسم العرض </th>
                      <th>الوصف </th>
                      <th> حالة العرض </th>
                      <th>زمن البداية</th>
                      <th>زمن النهاية</th>
                      <th>سعر العرض</th>
                      <th>لسعر الاصلي</th>
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

                  <tr v-for="category in offers.data " :key="category.id">
                  <td>{{category.id}}</td>
                  <td>{{category.name}}</td>
                  <td>{{category.description}}</td>
                  <td>
                        <v-chip
                        class="ma-2"
                        :color="!category.active ? 'red' :'green'"
                        label
                        @click="changeActive(category.id)"
                        outlined
                        >
                       {{category.active | activeText}}
                        </v-chip>

                        </td>
                  <td> {{category.strDate | myDate}} </td>
                  <td> {{category.endDate | myDate}} </td>
                      <td>

                        <div class="text-xl-h4 font-weight-black green--text">
                           {{category.price}}
                            </div>
                     </td>

                      <td  class="text-decoration-line-through text-xl-h4 font-weight-black red--text">
                          {{category.drug ? category.drug.price : category.product ? category.product.price  :0}}
                          </td>
                      <td>
                  <a href="#" > <i class="fas fa-edit" @click="updateModal(category)"> </i>
                  </a>
                  <a href="#" @click="deleteUser(category.id)"> <i class="fas fa-trash red"> </i>
                  </a>
                  </td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

                <div class="card-footer">
                    <pagination :data="offers"
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
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"  v-show="!editeMode" id="exampleModalLabel">اضافة عرض</h5>
          <h5 class="modal-title" v-show="editeMode" id="updateModaleTitle">تعديل بيانات عرض</h5>


          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin:-1rem -1rem -1rem !important">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form @submit.prevent="editeMode ? updateCategory() :createCategory()">
      <div class="modal-body">
        <div class="form-group">
        <input v-model="form.name" type="text" name="name"  placeholder="اسم العرض"
               class="form-control" :class="{'is-invalid':form.errors.has('name')}" >
            <has-error :form="form" field="name"></has-error>
        </div>



          <div class="form-group">
              <textarea v-model="form.description" name="description"  placeholder="اضافة وصف مختصر (اختياري )" id="bio"
                        class="form-control" :class="{'is-invalid':form.errors.has('description')}" ></textarea>
              <has-error :form="form" field="description"></has-error>

          </div>

        <div class="form-group">
        <input v-model="form.price" type="number" name="name"  placeholder="سعر العرض "
               class="form-control" :class="{'is-invalid':form.errors.has('price')}" >
            <has-error :form="form" field="price"></has-error>
        </div>

        <div class="row no-gutters border">

        <div class="col-md-3 pa-2 ml-auto border-1">
            يبع العرض ل
        </div>
        <div class="w-100"></div>
        <div class="col-md-6">
         <label class="col-md-3 ml-md-auto"> دواء </label>
        <input   type="radio" name="offerType"  v-model="form.offerType"
              v-b-toggle.drugs-collapse.product-collapse
             value="دواء"
             @click="getMedicanSection"
               class="col-md-3 align-self-end" :class="{'is-invalid':form.errors.has('offerType')}" >
            <has-error :form="form" field="offerType"></has-error>
        </div>


        <div class=" col-md-6">
            <label class="col-md-3"> منتج </label>
        <input value="منتج"  type="radio" name="offerType"  v-model="form.offerType"
        v-b-toggle.product-collapse.drugs-collabse
        @click="getCategories"
               class="col-md-3 align-self-end" :class="{'is-invalid':form.errors.has('offerType')}" >
            <has-error :form="form" field="offerType"></has-error>
        </div>
        </div>

        <div class="w-100"></div>
         <b-collapse id="product-collapse">
            <div class="row">
            <div class="form-group col-md-4">
              <select  v-model="cat_id" name="cat"  placeholder="" id="cat"
                    @change="getSubCategories"
                      class="form-control" :class="{'is-invalid':form.errors.has(`cat`)}" >
                  <option value="">اختيار القسم الرئيسي </option>
                  <option v-for="option in catList" :key="option.id" :value="option.id">{{option.name}}</option>
              </select>
              <has-error :form="form" :field="`cat`"></has-error>
            </div>

            <div class="form-group col-md-4">
              <select v-model="subCat_id"  name="subCat"  placeholder="" id="subCat"
              @change="getProducts"
                      class="form-control" :class="{'is-invalid':form.errors.has(`subCat`)}" >
                  <option value="">اختيار القسم الفرعي </option>
                  <option v-for="option in subCatList" :key="option.id" :value="option.id">{{option.name}}</option>
              </select>
              <has-error :form="form" :field="`subCat`"></has-error>
            </div>
            <div class="form-group col-md-4">
              <select v-model="form.product_id" name="product_id"  placeholder="" id="product_id"
                      class="form-control" :class="{'is-invalid':form.errors.has(`product_id`)}" >
                  <option value="">اختيار المنتج </option>
                  <option v-for="option in productList" :key="option.id" :value="option.id">{{option.name}}</option>
              </select>
              <has-error :form="form" :field="`product_id`"></has-error>
            </div>
      </div>
        </b-collapse>
         <b-collapse id="drugs-collapse">
            <div class="row">

            <div class="form-group col-md-6">
              <select  name="midicanSection"  v-model="medican_id" id="midicanSection"
              @change="getDrugs"
                      class="form-control" :class="{'is-llinvalid':form.errors.has(`midicanSection`)}" >
                  <option value="">اختيار قسم الدواء </option>
                  <option v-for="option in midicanSectionList" :key="option.id" :value="option.id">{{option.name}}</option>
              </select>
              <has-error :form="form" :field="`midicanSection`"></has-error>
            </div>
            <div class="form-group col-md-6">
              <select v-model="form.drug_id" name="product_id"  placeholder="" id="drug_id"
                      class="form-control" :class="{'is-invalid':form.errors.has(`drug_id`)}" >
                  <option value="">اختيار الدواء </option>
                  <option v-for="option in drugList" :key="option.id" :value="option.id">{{option.drugs_name}}</option>
              </select>
              <has-error :form="form" :field="`drug_id`"></has-error>
            </div>
      </div>
        </b-collapse>


        <!-- <div class="form-group">
             <label for="inputSkills" class="col-sm-2 col-form-label">الصورة</label>
                 <div class="col-sm-10">
                    <input type="file" @change="uploadIcon" name="icon" class="form-control" id="inputSkills" placeholder="الصورة">
                </div>
        </div> -->



        <div >
            <v-divider></v-divider>
 <v-row>
    <v-col
      cols="12"
      sm="6"
      md="6"
    >
      <v-menu
        v-model="menu2"
        :close-on-content-click="false"
        :nudge-right="40"
        transition="scale-transition"
        offset-y
        min-width="auto"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
            v-model="form.date"
            label="Picker without buttons"
            prepend-icon="mdi-calendar"
            readonly
            v-bind="attrs"
            v-on="on"
          ></v-text-field>
        </template>
        <v-date-picker
          v-model="form.date"
          @input="menu2 = false"
        ></v-date-picker>
      </v-menu>
    </v-col>

    <v-col
      cols="12"
      sm="6"
      md="6"
    >
      <v-menu
        ref="menu"
        v-model="endmenu"
        :close-on-content-click="false"
        :return-value.sync="form.enddate"
        transition="scale-transition"
        offset-y
        min-width="auto"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-text-field
            v-model="form.enddate"
            label="نهاية العرض"
            prepend-icon="mdi-calendar"
            readonly
            v-bind="attrs"
            v-on="on"
          ></v-text-field>
        </template>
        <v-date-picker
          v-model="form.enddate"
          no-title
          scrollable
        >
          <v-spacer></v-spacer>
          <v-btn
            text
            color="primary"
            @click="endmenu = false"
          >
            خروج
          </v-btn>
          <v-btn
            text
            color="primary"
            @click="$refs.menu.save(form.enddate)"
          >
            تم
          </v-btn>
        </v-date-picker>
      </v-menu>

    </v-col>


 </v-row>
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
                cat_id:'',
                subCat_id:'',
                editeMode:false,
                loading:true,
                offers:{},
                productList:[],
                medican_id:'',
                catList:[],
                midicanSectionList:[],
                subCatList:[],
                drugList:[],
                form :new Form({
                    id:'',
                    name:'',
                    description:'',
                    icon:'',
                    drug_id:'',
                    product_id:'',
                    date: new Date().toISOString().substr(0, 10),
                    enddate: new Date().toISOString().substr(0, 10),
                    offerType:'دواء',
                }),
              picker: new Date().toISOString().substr(0, 10),
              date: new Date().toISOString().substr(0, 10),
              enddate: new Date().toISOString().substr(0, 10),
              menu: false,
              menu2: false,
              endmodal: false,
              endmenu: false,

            }
        },


    // watch: {
    //   menu (val) {
    //     val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    //   },
    // },

    methods:{
            changeActive(id){
                this.$Progress.start()
                axios.get('api/admin/offers/'+id+'/operation')
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

    //   save (date) {
    //     this.$refs.menu.save(date)
    //   },


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

            loadOffers(){
                if(this.$gate.isAdminOrAuther()){
                axios.get('api/admin/offers?admin=admin')
                .then(({data})=>{
                    this.offers=data.data
                    this.loading=false
                })}
            },

            updateCategory(id){
                this.$Progress.start()
              this.form.put('api/admin/offers/'+this.form.id)
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
                        this.form.delete('api/admin/offers/'+id).then(()=>{
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
              axios.get('api/admin/offers?admin=admin&page='+page)
              .then(response=>{
                  this.orders=response.data.data
              })
            },
          createCategory(){
              this.$Progress.start();
              this.form.post('api/admin/offers')
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
              this.drugList=[]
              this.form.drug_id=''
              console.log("getCategories")
              if(this.$gate.isAdminOrAuther()){
                  axios.get('api/admin/categories')
                  .then(({data})=> {
                      this.catList=data.data
                      }  )
              }
          },

          getSubCategories(){
            this.drugList=[]
              this.form.drug_id=''
              if(this.$gate.isAdminOrAuther()){
                  axios.get('api/admin/categories/'+this.cat_id+'/departments')
                  .then(({data})=> {
                      this.subCatList=data.data
                      }  )
              }
          },


          getProducts(){
                this.drugList=[]
              this.form.drug_id=''
              if(this.$gate.isAdminOrAuther()){
                  axios.get('api/admin/departments/'+this.subCat_id+'/products')
                  .then(({data})=> {
                      this.productList=data.data
                      }  )
              }
          },


        getMedicanSection(){
            this.productList=[]
                this.form.product_id=''

              if(this.$gate.isAdminOrAuther()){
                  axios.get('api/admin/medicinesections/')
                  .then(({data})=> {
                      this.midicanSectionList=data.data
                      }  )
              }
          },


                    getDrugs(){
              if(this.$gate.isAdminOrAuther()){
                  axios.get('api/admin/medicinesections/'+this.medican_id+'/drugs')
                  .then(({data})=> {
                      this.drugList=data.data
                      }  )
              }
          },
        // uploadIcon(e){
        //         let file=e.target.files[0];
        //         console.log((file))
        //         var reader=new FileReader()
        //         if(file['size']<2111775) {
        //             reader.onloadend = (file) => {
        //                 console.log('Result ',reader.result)
        //                 this.form.icon = reader.result
        //             }
        //         }else{
        //             Swal.fire('Failed','The Image Is More Than 10MB','warning')

        //         }

        //         reader.readAsDataURL(file)
        //     },

            // getIcon(){
            //     let photo=(this.form.icon.length>200) ? this.form.icon:"icon/offers/"+this.form.icon
            //     return photo
            // }
        },

        created() {
            //this.$Progress.start();
            this.loadOffers()

            Fire.$on('AfterCreated',()=>{
                this.loadOffers()
            })

            Fire.$on("Searching",()=>{
                let query=this.$parent.search
                axios.get('api/offers?q='+query)
                .then((data)=>{
                    this.offers=data.data
                })
                .catch(()=>{

                })
            })

            // setInterval(()=>this.loadOffers(),3000)
            //this.$Progress.finish();
        },
        //
        // mounted() {
        //console.log('Component mounted.')
        // }
    }
</script>
