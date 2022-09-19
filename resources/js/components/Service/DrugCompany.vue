<template>
<v-app>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600px"
    >
    <v-card>
        <v-card-title>
          <span class="headline">شركات الدواء {{drugsItem.drugs_name}}</span>
        </v-card-title>
        <v-card-text>
          <v-container>

            <v-row>
            <template
              v-if="drugCompanies.length > 0 "
              >
              <v-col
                v-for="(company,index) in drugCompanies"
                :key="index"
                cols="12"
              >
               <v-row>

              <v-col
                cols="12"
                sm="6"
                md="4"
              >
               <v-text-field
                  :label="company.name"
                  disabled
                ></v-text-field>
                <!-- <v-col
                md=3
                >
                <a href="#" @click="deleteCompany(company)"> <i class="fas fa-trash red"> </i>
                  </a>
                </v-col> -->
               </v-col>
              <v-col
                cols="12"
                sm="6"
                md="4"
              >
                <v-text-field
                  label="سعر الدواء"
                  v-model="drugCompanies[index].pivot.price"

                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="4"
              >
                <v-text-field
                  label="الكمية"
                  v-model="drugCompanies[index].pivot.amount"
                  persistent-hint
                  required
                ></v-text-field>
              </v-col>
               </v-row>

              </v-col>
            </template>
              <v-divider></v-divider>

            <template
              v-if="newDrugCompanies.length > 0"
              >
              <v-col
                v-for="(company,index) in newDrugCompanies"
                :key="index"
                cols="12"
              >
               <v-row>
              <v-col
                cols="12"
                sm="6"
                md="4"

              >
                 <v-select
                  :items="allcompany"
                  item-text="name"
                  item-value="id"
                  v-model="newDrugCompanies[index].companies_id"
                  label="اسم الشركة "
                  required
                  :loading="loadingDrwopCompany"
                ></v-select>

                <!-- <v-col
                md=3
                >
                <a href="#" @click="deleteCompany(company)"> <i class="fas fa-trash red"> </i>
                  </a>
                </v-col> -->

               </v-col>
              <v-col
                cols="12"
                sm="6"
                md="4"
              >
                <v-text-field
                  label="سعر الدواء"
                  v-model="newDrugCompanies[index].price"
                  :value="company.exists"
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="4"
              >
                <v-text-field
                  label="الكمية"
                  v-model="newDrugCompanies[index].amount"
                  persistent-hint
                  required
                ></v-text-field>
              </v-col>
               </v-row>
              </v-col>
            </template>

              <v-divider></v-divider>
              <v-col
              class="ml-auto"
              cols="3"
              >
              <v-icon
              color="#2196F3"
              @click="addnewCompanies"
              >
                  mdi-plus-thick
              </v-icon>
              </v-col>
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="closeDialog"
          >
            خروج
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="next"
            :loading="loadingSaveCompany"
          >
            حفظ
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</v-app>
</template>



<script>
  export default {

    data () {
      return {
        dialog: false,
        drugsItemCompany:{},
        drugCompanies:[],
        newDrugCompanies:[],
        allcompany:[{}],
        loadingDrwopCompany:true,
        loadingSaveCompany:false,

      }
    },
    // props:['dialog','drugs'],

    computed:{
        drugsItem:function (val) {
        return this.drugsItemCompany || {}
    },

    },

    methods:{
        closeDialog(){
            this.dialog=!this.dialog
            this.newDrugCompanies=[]
            this.drugCompanies=[]

            Fire.$emit('closeDialogCompalny');
        },

        loadDrugCompaies(){
                    if(this.$gate.isAdminOrAuther()){
                    axios.get('api/admin/drugs/'+this.drugsItem.id+'/companies')
                    .then(({data})=>{
                        this.drugCompanies=data.data
                        this.loadingDrwopCompany=false
                        console.log(data.data)
                    })}
        },


        loadCompany(){
                    if(this.$gate.isAdminOrAuther()){
                    axios.get('api/admin/companies')
                    .then(({data})=>{
                        this.allcompany=data.data
                        this.loadingDrwopCompany=false
                        console.log(data.data)
                    })}
        },

        addnewCompanies(){
            this.newDrugCompanies.push({
                companies_id:'',
                    price:'0',
                    amount:'0'
            });
            this.loadCompany(),
            this.drugCompanies=[];
        },

        deleteCompany(item){
            this.newDrugCompanies.splice(this.newDrugCompanies.indexOf(item),1)
                // Swal.fire({
                //     title: 'هل انت ماكد ؟',
                //     text: "بانك تريد الحذف الان !",
                //     icon: 'warning',
                //     showCancelButton: true,
                //     confirmButtonColor: '#3085d6',
                //     cancelButtonColor: '#d33',
                //     confirmButtonText: 'نعم, امسحه!'
                // }).then((result) => {
                //     if (result.value) {
                //         // send ajax requestto delete
                //         this.form.delete('api/admin/drugs/'+id+'/companies',{data:{item}}).then(()=>{
                //             Swal.fire(
                //                 'Deleted!',
                //                 'تم المسح بنجاح ',
                //                 'success'
                //             )

                //             Fire.$emit('AfterCreated')

                //         })
                //     }
                // })
                // .catch(()=>{
                //     Swal.fire('Failed','There was Somthing Wrong ','warning')
                // })
        },

        next () {
        this.loadingSaveCompany = true
            let companyList=this.drugCompanies.length > 0 ?this.drugCompanies : this.newDrugCompanies

            axios.post('api/admin/drugs/'+this.drugsItem.id+'/companies',
            {
                newDrugCompanies:this.newDrugCompanies
            }

            )
              .then(response=>{
                 Fire.$emit('AfterCreated');
              })

        setTimeout(() => {
        //   this.search = ''
        //   this.selected = []
          this.loadingSaveCompany = false
          this.closeDialog()
        }, 2000)

      },

    },

    created(){
        Fire.$on('showCompanyDialog',(obj)=>{
                this.dialog=obj.companyDialog
                this.drugsItemCompany = obj.drugItem
                this.loadDrugCompaies();
            })
    }

  }
</script>
