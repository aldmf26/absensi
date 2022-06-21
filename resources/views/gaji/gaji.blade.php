@extends('template.master')
@section('content')
@php
    function tgl_indo($tanggal) {
            $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);
        
        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun
    
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }
@endphp
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0">Gaji Agrilaras {{ tgl_indo(date($tgl1)) }} ~ {{ tgl_indo(date($tgl2)) }}</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <form method="get" action="">
                            
                    
                            <div class="row form-group mt-4">
                                <div class="col-lg-2">
                                    <label for="">Dari</label>
                                    <input required type="date" class="form-control" name="tgl1">
                                </div>
                                <div class="col-lg-2">
                                    <label for="">Sampai</label>
                                    <input type="date" class="form-control" name="tgl2">
                                </div>
                                <div class="col-lg-1">
                                    <label for=""> </label>
                                    <button type="submit" class="btn btn-md btn-primary" style="margin-top: 33px">View</button>
                                </div>
                                <div class="col-lg-2">
                                    <label for=""> </label>
                                    <a href="{{ route('exportGaji', ['tgl1' => $tgl1, 'tgl2' => $tgl2]) }}" target="_blank" style="margin-top: 33px" class="btn btn-md btn-success"><i class="fa fa-file-pdf"></i> Export</a>
                                </div>
                            </div>
                        </form>
            
                    </div>
                </div>
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
                    <section class="col-lg-12 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <!-- Button trigger modal -->
                       
                        <div class="card-body">
                            @include('flash.flash')
                            <table id="example1" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Karyawan</th>

                                        @foreach($shift as $s)
                                            @if ($s->status != 'OFF')
                                                <th>Total {{$s->status}}</th>
                                            @endif
                                        
                                        @endforeach
                                        @foreach($shift as $s)
                                            @if ($s->status != 'OFF')
                                                <th>Gaji {{$s->status}}</th>
                                            @endif
                                        @endforeach
                                        <th>Gaji Bulanan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach($hasil as $h)
                                     <tr>
                                         <td>{{$no++}}</td>
                                         <td>{{$h->nama_karyawan}}</td>
                                         @foreach($shift as $s)
                                            @if ($s->status != 'OFF')
                                                @php
                                                    $status = strtolower($s->status);
                                                    $status = "qty_$status";
                                                @endphp
                                                <td>{{$h->$status == '' ? 0 : $h->$status}}</td>
                                            @endif
                                        
                                        @endforeach
                                        @foreach($shift as $s)
                                        @if ($s->status != 'OFF')
                                            @php
                                                $status = strtolower($s->status);
                                                $status = "ttl_gaji_$status";
                                            @endphp
                                            <td>{{$h->$status == '' ? 0 : number_format($h->$status,0)}}</td>
                                        @endif
                                        
                                    @endforeach
                                    <td>{{ $h->g_bulanan == '' ? 0 : number_format($h->g_bulanan,0) }}</td>
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
        
    @endsection
