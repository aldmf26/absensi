@include('template._header')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <center>
                    <img class="text-center" src="https://1.bp.blogspot.com/-efcrgVn7kNs/X3PuJdVayDI/AAAAAAAAG_s/gtyVvD55QSUJMI_zUF9ripq4VFWhu6bRQCLcBGAsYHQ/s512/EABS.png" width="150" alt="AdminLTE Logo"  style="opacity: .8">
                </center>
           
                    <div class="col-lg-12">
                        @include('flash.flash')
                        <form action="{{route('aksiLogin')}}" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" autofocus name="username" required class="form-control" placeholder="masukkan username">
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
                            <input type="submit" name="simpan" value="Login" class="btn btn-primary btn-block mt-3">
                            
                        </form><br>
                    </div>
                </div>
            </div>
         </div>
    </div>  
</div>

