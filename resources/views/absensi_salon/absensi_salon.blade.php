@extends('template.master')
@section('content')
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Absensi Salon</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Absensi Salon</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      
      <!-- /.row -->
      <!-- Main row -->
      <div class="row justify-content-center">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <!-- Button trigger modal -->
          
        <a class="btn btn-primary mb-3" href="{{route('add_edit_salon', ['id_departemen' => 2])}}">
            <i class="fa fa-edit"></i> Add / Edit
        </a>
        <a class="btn btn-info mb-3" href="{{route('detail_salon', ['id_departemen' => 2])}}">
          <i class="fa fa-pen"></i> Detail
      </a>
          <div class="card">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>NAMA</th>
                  <th>M</th>
                  <th>OFF</th>
                </tr>
              </thead> 
              <tbody>
                @php
                    $no = 1;
                    
                    
                @endphp
                @foreach ($karyawan as $d)
                <tr>
                  <td>{{$no++}}</td>
                  <td>{{$d->nama_karyawan}}</td>
                  @foreach ($status as $s)
                  @php
                      $data = DB::table('absensi_salon')->select('absensi_salon.*')->where('id_karyawan',$d->id_karyawan)
                    ->where('tanggal_masuk', date('Y-m-d'))->first();
                   
                  @endphp
                  <td>
                    <?php if($data) {  ?>
                        <?php if($data->status == $s->status) { ?>
                        <a class="btn btn-success" value="{{$s->id_status}}" href="{{route('delete_salon',
                        [
                            'id_departemen' => 2,
                            'id_absen' => $data->id 
                        ])}}">
                        {{$s->status}}
                        </a>     
                        <?php }else {  ?>         
                          <a href="{{route('update_salon', [
                                  'id_departemen' => 2,
                                  'id_absen' => $data->id 
                              ])}}" class="btn btn-block  btn-info">
                                  OFF
                                </a>
                          <?php } ?>
                    <?php } else { ?>
                      <a class="btn btn-outline-success" value="{{$s->id_status}}" href="{{route('input_salon',
                        [
                            'id_departemen' => 2,
                            'id_karyawan' => $d->id_karyawan, 
                            'status' => $s->status,
                            'tanggal' => date('Y-m-d')
                        ])}}">
                        {{$s->status}}
                        </a>
                    <?php } ?>
                    @if ($s->status == 'OFF')
                    @php
                        break
                    @endphp
                    @endif
                  </td>
                  @endforeach
                </tr>
                @endforeach
                
              </tbody>
              
            </table>
          </div>
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $(document).on('click', '.status', function(){
                var id_karyawan = $(this).attr('id_karyawan')
                $('.status').removeClass('btn-outline-success');
                $('.status'+id_karyawan).addClass('btn-success');
            })
        })
    </script>
@endsection