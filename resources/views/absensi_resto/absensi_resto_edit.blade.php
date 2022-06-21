@extends('template.master')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Absensi Resto</h1><br>
                        <a class="btn btn-warning mb-3" href="{{ route('absensi_resto', ['id_departemen' => 3]) }}">
                            <i class="fa fa-arrow-left"></i> KEMBALI
                        </a>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Absensi Resto</li>

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
                    <section class="col-lg-9 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <!-- Button trigger modal -->
                        @include('flash.flash')
                        <div class="card">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>TANGGAL</th>
                                        <th>NAMA</th>
                                        <th>STATUS</th>
                                        <th>ADMIN</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                        
                                    @endphp
                                    <tr>
                                        <form method="post" action="{{ route('add_resto', ['id_departemen' => 3]) }}">
                                            @csrf
                                            <td></td>
                                            <td><input
                                                    style="border-width: initial; border-style: none none solid; border-color: initial; border-image: initial; --darkreader-inline-border-top: initial; --darkreader-inline-border-right: initial; --darkreader-inline-border-left: initial; --darkreader-inline-border-bottom: initial;"
                                                    class="form-control" type="date" name="tanggal_masuk"
                                                    value="{{ date('Y-m-d') }}" data-darkreader-inline-border-top=""
                                                    data-darkreader-inline-border-right=""
                                                    data-darkreader-inline-border-left=""
                                                    data-darkreader-inline-border-bottom=""></td>
                                            <td>
                                                <select
                                                    style="border-width: initial; border-style: none none solid; border-color: initial; border-image: initial; --darkreader-inline-border-top: initial; --darkreader-inline-border-right: initial; --darkreader-inline-border-left: initial; --darkreader-inline-border-bottom: initial;"
                                                    data-dropdown-css-class="select2-danger"
                                                    class="custom-select select2-danger" name="id_karyawan"
                                                    data-darkreader-inline-border-top=""
                                                    data-darkreader-inline-border-right=""
                                                    data-darkreader-inline-border-left=""
                                                    data-darkreader-inline-border-bottom="">
                                                    <option value=""> -- karyawan --</option>
                                                    @foreach ($karyawan as $s)
                                                        <option value="{{ $s->id_karyawan }}">{{ $s->nama_karyawan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select
                                                    style="border-width: initial; border-style: none none solid; border-color: initial; border-image: initial; --darkreader-inline-border-top: initial; --darkreader-inline-border-right: initial; --darkreader-inline-border-left: initial; --darkreader-inline-border-bottom: initial;"
                                                    data-dropdown-css-class="select2-danger"
                                                    class="custom-select select2-danger" name="status"
                                                    data-darkreader-inline-border-top=""
                                                    data-darkreader-inline-border-right=""
                                                    data-darkreader-inline-border-left=""
                                                    data-darkreader-inline-border-bottom="">
                                                    <option value=""> -- status --</option>
                                                    @foreach ($status as $s)
                                                        <option value="{{ $s->status }}">{{ $s->status }}</option>

                                                    @endforeach
                                                </select>
                                            </td>
                                            <td></td>
                                            <td><input type="submit" value="SIMPAN" class="btn btn-primary"></td>
                                        </form>
                                    </tr>
                                    @foreach ($absensi as $d)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $d->tanggal_masuk }}</td>
                                            <td>{{ $d->nama_karyawan }}</td>
                                            <td>{{ $d->status }}</td>
                                            <td>{{ $d->nama }}</td>
                                            <td>
                                                <a class="btn btn-success" data-toggle="modal"
                                                    data-target="#editAbsen{{ $d->id }}"><i
                                                        class="fas fa-edit"></i></a>
                                                <form class="d-inline-block" action="{{ route('delete_resto') }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="id_absen" value="{{ $d->id }}">
                                                    <button onclick="return confirm('Apakah anda yakin ? ')"
                                                        class="btn btn-danger"><i class="fas fa-trash"></i></button>
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
        @foreach ($absensi as $d)
            <form action="{{ route('edit_resto', ['id_departemen' => 3]) }}" method="post">
                @csrf
                @method('patch')
                <!-- Modal -->
                <div class="modal fade" id="editAbsen{{ $d->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <label for="">TANGGAL</label>
                                <input type="hidden" name="id_absen" value="{{ $d->id }}">
                                <input
                                    style="border-width: initial; border-style: none none solid; border-color: initial; border-image: initial; --darkreader-inline-border-top: initial; --darkreader-inline-border-right: initial; --darkreader-inline-border-left: initial; --darkreader-inline-border-bottom: initial;"
                                    class="form-control" type="date" name="tanggal_masuk" value="{{ $d->tanggal_masuk }}"
                                    data-darkreader-inline-border-top="" data-darkreader-inline-border-right=""
                                    data-darkreader-inline-border-left="" data-darkreader-inline-border-bottom="">
                                <label for="" class="mt-3">Nama Karyawan</label>
                                <select class="form-control" name="id_karyawan" id="">
                                    @foreach ($karyawan as $p)
                                        <option value="{{ $p->id_karyawan }}"
                                            {{ $p->id_karyawan == $d->id_karyawan ? 'selected' : '' }}>
                                            {{ $p->nama_karyawan }}</option>
                                    @endforeach
                                </select>
                                <label for="" class="mt-3">STATUS</label>
                                <select class="form-control" name="status" id="">
                                    @foreach ($status as $p)
                                        <option value="{{ $p->status }}"
                                            {{ $p->status == $d->status ? 'selected' : '' }}>{{ $p->status }}</option>
                                    @endforeach
                                </select>
                                <input type="submit" name="simpan" value="Simpan" id="tombol" class="btn btn-primary mt-3">
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
