@extends('template.master')
@section('content')
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Jenis Pekerjaan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Jenis Pekerjaan</li>
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
          <form action="{{route('addJenis')}}" method="post">
            @csrf
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahJenisPekerjaan">
          + Tambah Jenis Pekerjaan
        </button>

        <!-- Modal -->
        <div class="modal fade" id="tambahJenisPekerjaan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Pekerjaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <label for="">Jenis Pekerjaan</label>
                <input type="text" name="jenis_pekerjaan" class="form-control">
                <label for="">Keterangan</label>
                <input type="text" name="keterangan" class="form-control">
                <input type="submit" name="simpan" value="Simpan" id="tombol"  class="btn btn-primary mt-3">
          <button type="button" class="btn btn-secondary  mt-3" data-dismiss="modal">Close</button>
              </div>
              <div class="modal-footer">
              </div>
            </div>
          </div>
        </div>
      </form>
          <div class="card">
            <table class="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Jenis Pekerjaan</th>
                  <th>Keterangan</th>
                  <th>Aksi</th>
                </tr>
              </thead> 
              <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($jenis as $d)
                <tr>
                  <td>{{$no++}}</td>
                  <td>{{$d->jenis_pekerjaan}}</td>
                  <td>{{$d->keterangan}}</td>
                  <td>
                    <a class="btn btn-sm btn-success" data-toggle="modal" data-target="#editJenisPekerjaan{{$d->id}}"><i class="fas fa-edit"></i></a>
                    <form class="d-inline-block" action="{{route('deleteJenis')}}" method="post">
                      @csrf
                      <input type="hidden" name="id_jenis_pekerjaan" value="{{$d->id}}">
                     <button onclick="return confirm('Apakah anda yakin ? ')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button> 
                    </form>
                    
                  </td>
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
  @foreach ($jenis as $d)
  <form action="{{route('editJenis')}}" method="post">
    @csrf
    @method('patch')
<!-- Modal -->
<div class="modal fade" id="editJenisPekerjaan{{$d->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="">Jenis Pekerjaan</label>
        <input type="hidden" name="id_jenis_pekerjaan" value="{{$d->id}}">
        <input type="text" name="jenis_pekerjaan" value="{{$d->jenis_pekerjaan}}" class="form-control">
        <label for="">Keterangan</label>
        <input type="text" name="keterangan" value="{{$d->keterangan}}" class="form-control">
        <input type="submit" name="simpan" value="Simpan" id="tombol"  class="btn btn-primary mt-3">
          <button type="button" class="btn btn-secondary  mt-3" data-dismiss="modal">Close</button>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
</form>
@endforeach
@endsection