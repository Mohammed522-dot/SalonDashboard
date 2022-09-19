<template>
<v-app>
  <v-container class="grey lighten-5">
<div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{data.product}}</h3>

                <p>عدد المنتجات</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{data.salon}}<sup style="font-size: 20px">%</sup></h3>

                <p>عدد الصالونات</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{data.drugs_count}}</h3>

                <p>عدد الخدمات</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{data.orderCount}}</h3>

                <p>عدد الطلبات</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>


  </v-container>
</v-app>
</template>



<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },

        data(){
           return{
               data:{},
           }
        },
        methods:{
            loadDashboard(){
            axios.get('api/admin/dashboard')
                .then(({data})=>{
                    this.data=data.data
                    console.log(data)
                })
            }
        },

    created(){
        this.loadDashboard()
    }
}
</script>
