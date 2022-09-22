@extends('template.master')
@section('content')
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pemakai Jasa</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Pemakai Jasa</li>
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
        
          <div class="card">
            <table class="table" id="tabel1">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Keterangan</th>
                  <th>Aksi</th>
                </tr>
              </thead> 
              <tbody>
                  @php
                      $no = 1;
                  @endphp
                  @foreach ($input as $i)       
                  <tr>
                    <td>{{$no++}}</td>
                    <td contenteditable="true" class="nama">{{$i->nama}}</td>
                    <td contenteditable="true" class="pekerjaan">{{$i->pekerjaan}}</td>
                    <td><button class="btn btn-danger" id="hapus">-</button></td>
                  </tr>          
                  @endforeach
              </tbody>
            </table>
            <button class="btn btn-success" id="tambah">+</button>
            <button class="btn btn-primary" id="simpan">simpan</button>
          </div>
          
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>

@endsection
@section('script')
<script>
    $(document).ready(function(){
        let baris = 1
        let no = 1;
        $(document).on('click', '#tambah', function(){
            baris = baris + 1
            var html = "<tr id='baris'" +baris+ ">"
                html += "<td>"+no+++"</td>"
            html += "<td contenteditable='true' class='nama'></td>"
            html += "<td contenteditable='true' class='pekerjaan'></td>"
            html += "<td> <button class='btn btn-danger' data-row='baris'"+baris+" id='hapus'>-</button> </td>"
            html += "</tr>"
            
            $('#tabel1').append(html)
        })

        $(document).on('click', '#hapus', function(){
            let hapus = $(this).data('row')
            $('#' + hapus).remove()
        })

        $(document).on('click', '#simpan', function(){
            let nama = []
            let pekerjaan = []
            
            $('.nama').each(function(){
                nama.push($(this).text())
            })
            $('.pekerjaan').each(function(){
                pekerjaan.push($(this).text())
            })

            $.ajax({
                type: "post",
                url: "{{route('simpan')}}",
                data: {
                    nama : nama,
                    pekerjaan : pekerjaan,
                    "_token" : "{{csrf_token()}}"
                },
                success: function (res) {
                    console.log(res);
                }, error: function(e) {
                    console.error(e);
                }
            })
        }) 

    })
</script>
@endsection