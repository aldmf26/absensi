@include('template._header')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="ml-2 mb-3">Form Register</h3>
                    <div class="col-lg-12">
                        @include('flash.flash')
                        <form action="{{route('aksiReg')}}" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" name="nama" required class="form-control" placeholder="masukkan nama">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-users"></span>
                                  </div>
                                </div>
                              </div>
                            <div class="input-group mb-3">
                                <input type="text" name="username" required class="form-control" placeholder="masukkan username">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                  </div>
                                </div>
                              </div>
                              <div class="input-group mb-3">
                                <input type="password" name="password" required class="form-control" placeholder="masukkan password">
                                <div class="input-group-append">
                                  <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                  </div>
                                </div>
                              </div>
                            <input type="submit" name="simpan" value="Simpan" class="btn btn-primary btn-block mt-3">
                            
                        </form><br>
                        <a class="mt-3 ml-1" href="{{route('login')}}">Kembali</a>
                    </div>
                </div>
            </div>
         </div>
    </div>  
</div>

