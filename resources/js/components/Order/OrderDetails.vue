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
          <span class="headline"> تفاصيل الطلب رقم   {{order.id}}</span>
        </v-card-title>
        <v-card-text>


<v-tabs
      v-model="tab"
      background-color="transparent"
      color="basil"
      grow
      @change="test"
    >
      <v-tab
        v-for="item in items"
        :key="item"
      >
        {{ item }}
      </v-tab>

     </v-tabs>

    <v-tabs-items v-model="tab"
    >
      <v-tab-item
        v-for="item in items"
        :key="item"
      >
        <v-card
        v-if="item == 'الادوية'"
          color="basil"
          flat
        >
        <v-card-subtitle>
            الادوية
        </v-card-subtitle>
          <v-card-text>

        <template v-if="item == 'الادوية'">
        <v-simple-table height="300px">
            <template v-slot:default>
            <thead>
                <tr style="text-align: right;">
                <th class="text-left">
                    الاسم
                </th>
                <th class="text-left">
                    الكمية
                </th>
            <th class="text-left">
                    الاجمالي
                </th>
                </tr>
            </thead>
            <tbody>
                <tr
                v-for="item in orderDetails.drugs"
                :key="item.id"
                >
                <td>{{ item.drugs_name }}</td>
                <td>{{ item.pivot.amount }}</td>
                <td>{{ item.price *  item.pivot.amount}}</td>
                </tr>
            </tbody>
            </template>
        </v-simple-table>
            </template>



          </v-card-text>
        </v-card>

    <v-card v-if="item == 'المنتجات'"
              color="basil"
          flat

    >
        <v-card-subtitle>
            المنتجات
        </v-card-subtitle>
        <v-card-text>
        <template v-if="item == 'المنتجات'">
        <v-simple-table height="300px">
            <template v-slot:default>
            <thead>
                <tr style="text-align: right;">
                <th class="text-left">
                    الاسم
                </th>
                <th class="text-left">
                    الكمية
                </th>
            <th class="text-left">
                    الاجمالي
                </th>
                </tr>
            </thead>
            <tbody>
                <tr
                v-for="item in orderDetails.products"
                :key="item.id"
                >
                <td>{{ item.name }}</td>
                <td>{{ item.pivot.amount }}</td>
                <td>{{ item.price *  item.pivot.amount}}</td>
                </tr>
            </tbody>
            </template>
        </v-simple-table>
            </template>

        </v-card-text>
    </v-card>

<v-card v-if="item == 'الروشتات'"
          color="basil"
          flat
>
<v-card-subtitle>
    الروشتات
</v-card-subtitle>

    <v-card-text>
        <template v-if="item == 'الروشتات'">

                <v-container fluid>
          <v-row>
            <v-col
              v-for="item in orderDetails.prescriptions"
              :key="item.id"
              cols="12"
              md="4"
            >
              <v-img
                :src="item.image"
                aspect-ratio="1"
              ></v-img>
            </v-col>
          </v-row>
        </v-container>
        </template>
    </v-card-text>
</v-card>

      </v-tab-item>

      <!-- <v-tab-item>

      </v-tab-item> -->
    </v-tabs-items>

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
          dialog:false,
          tab:null,
          order:{},
          orderDetails:{},
           items: [
          'الادوية', 'المنتجات', 'الروشتات',
        ],
         tabs: null,
        text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        desserts: [
          {
            name: 'Frozen Yogurt',
            calories: 159,
          },
          {
            name: 'Ice cream sandwich',
            calories: 237,
          },
          {
            name: 'Eclair',
            calories: 262,
          },
          {
            name: 'Cupcake',
            calories: 305,
          },
          {
            name: 'Gingerbread',
            calories: 356,
          },
          {
            name: 'Jelly bean',
            calories: 375,
          },
          {
            name: 'Lollipop',
            calories: 392,
          },
          {
            name: 'Honeycomb',
            calories: 408,
          },
          {
            name: 'Donut',
            calories: 452,
          },
          {
            name: 'KitKat',
            calories: 518,
          },
        ],
      }
    },


     methods:{
        closeDialog(){
            this.dialog=!this.dialog
            Fire.$emit('closeOrderDetailsDialog');
        },

        loadDetails(){
      if(this.$gate.isAdminOrAuther()){
                  axios.get('api/admin/orders/'+this.order.id+'/details')
                  .then(({data})=> {
                      console.log(data)
                      this.orderDetails=data
                      console.log('\n '+this.orderDetails)


                      }  )
              }

            // this.orderDetailsID=id
            this.editeMode=true

        },

        test(){
            console.log("ana rastya   "+this.tab)
        }
     },

    created(){
        Fire.$on('showOrderDetailsDialog',(obj)=>{
                this.dialog=obj.orderDialog
                this.order = obj.order
                this.loadDetails();
                // console.log(this.order)
            })
    }
  }
</script>
