<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    
    
  </ul>
  @php
      @$nama = Auth::user()->nama;
  @endphp
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Navbar Search -->
    <h5 class="mt-2">Selamat Datang : <span class="btn btn-outline-success"> {{ $nama }}</span></h5>
    
    
    <li class="nav-item d-none d-sm-inline-block">
      <a href="{{route('aksiLogout')}}" class="nav-link btn btn-md btn-danger mt-2 ml-2" >Logout</a>
  </li>
    
    
  </ul>
</nav>
<!-- /.navbar -->