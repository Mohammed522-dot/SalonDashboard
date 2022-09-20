
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->

<html lang="en" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>wow</title>

  <!-- Font Awesome Icons -->
  <link href='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css' rel='stylesheet' />
  <link rel="stylesheet" href="css/admin.css">

</head>
<body class="hold-transition sidebar-mini" >
<div class="wrapper"  id="app" >

  <!-- Navbar  -->
  <nav class=" main-header navbar navbar-expand navbar-white navbar-light" style="margin-right: 250px;margin-left: 0px">
      <!-- style="margin-right: 250px"> -->
    <!-- Left navbar links -->
    <ul class="navbar-nav mr-auto">
    <li class="nav-item rtl" >
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      </ul>
    <!-- <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul> -->


    <!-- Right navbar links -->

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" >
    <!-- Brand Logo -->
    <a href="dashboard" class="brand-link">
      <img src="logo.jpg" alt="Dashboard Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Wow</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="image/profile/{{Auth::user()->photo}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
            {{Auth::user()->name}}
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu" data-accordion="false" style="text-align: right">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->



        <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt blue" ></i>
              <p>
                لوحة التحكم
              </p>
            </router-link>
          </li>

          @can('isAdmin')

          <li class="nav-item">
            <router-link to="/users" class="nav-link ">
              <i class="fas fa-users nav-icon blue"></i>
              <p>ادارة المستخدمين</p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/medicinesections" class="nav-link">
              <i class="nav-icon fas fa-clinic-medical blue"></i>
              <p>
               ادارة اقسام الادوية
              </p>
            </router-link>
          </li>


          <li class="nav-item">
            <router-link to="/categories" class="nav-link">
              <i class="nav-icon fas fa-laptop-medical blue"></i>
              <p>
                ادارة الاقسام
              </p>
            </router-link>
          </li>


          <li class="nav-item">
            <router-link to="/subcategories" class="nav-link">
              <i class="nav-icon fas fa-book-medical blue"></i>
              <p>
                ادارة الاقسام الفرعية
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/companies" class="nav-link">
              <i class="nav-icon fas fa-band-aid blue"></i>
              <p>
                ادارة  الصالونات
              </p>
            </router-link>
          </li>

          <!-- <li class="nav-item">
            <router-link to="/offers" class="nav-link">
              <i class="nav-icon fas fa-ad blue"></i>
              <p>
                ادارة  العروض
              </p>
            </router-link>
          </li> -->
          <!-- <li class="nav-item">
            <router-link to="/products" class="nav-link">
              <i class="nav-icon fas fa-toilet-paper blue"></i>
              <p>
                ادارة المنتجات
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/drugs" class="nav-link">
              <i class="nav-icon fas fa-capsules blue"></i>
              <p>
                ادارة  الخدمات
              </p>
            </router-link>
          </li> -->
       @endcan

       @can('isAdminAndUser')

       <li class="nav-item">
            <router-link to="/services" class="nav-link">
              <i class="nav-icon fas fa-capsules blue"></i>
              <p>
                ادارة  الخدمات
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/products" class="nav-link">
              <i class="nav-icon fas fa-toilet-paper blue"></i>
              <p>
                ادارة المنتجات
              </p>
            </router-link>
          </li>
            <!-- <li class="nav-item active treeview">
              <router-link to="/reporting" class="nav-link">
                <i class="nav-icon fas fa-receipt blue"></i>
                <p>
                  الطلبات ( {{ $data['orders_count'] }} )
                </p>
              </router-link>
            </li> -->

            <li class="nav-item active treeview">
              <router-link to="/booking" class="nav-link">
                <i class="nav-icon fas fa-receipt blue"></i>
                <p>
                  الحجوزات ( {{ $data['booking_count'] }} )
                </p>
              </router-link>
            </li>

            @endcan



          <li class="nav-item">
            <router-link to="/profile" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt blue"></i>
              <p>
                البروفايل
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/developer" class="nav-link">
                <i class="nav-icon fas fa-cogs orange"></i>
                <p>
                    Developer
                </p>
            </router-link>
        </li>

            <li class="nav-item">
                   <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-power-off red"></i>
                            <p> تسجيل الخروج</p>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                        </form>
                      </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper " style="margin-right: 250px;margin-left: 10px">
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <router-view></router-view>

      <vue-progress-bar></vue-progress-bar>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020-2021 <a href="https://adminlte.io">PrimaryKey</a>.</strong> All rights Ana.
  </footer>
</div>
<!-- ./wrapper -->

@auth
    <script>
        window.user=@json(auth()->user());
        </script>
@endauth
@push('scripts-or-whatever')
<script>

$.widget.bridge('uibutton', $.ui.button);
    setTimeout(function(){
        // $, jQuery, Vue is all ready to use now
        $(document).ready(function(){ // code here })
    }, 100)
    </script>
    @endpush
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js'></script>
    <script src="js/app.js"></script>
</body>
</html>

    