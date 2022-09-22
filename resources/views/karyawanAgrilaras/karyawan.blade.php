@extends('template.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Karyawan Agrilaras</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Karyawan</li>
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
                    <section class="col-lg-12 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <!-- Button trigger modal -->

                        <button type="button" class="btn btn-primary mb-3 ml-4" data-toggle="modal"
                            data-target="#tambahKaryawan">
                            + Tambah Karyawan
                        </button>
                        <!--<a href="{{ route('excelKaryawanAgrilaras') }}" class="btn btn-success mb-3"><i-->
                        <!--        class="fas fa-print"></i>-->
                        <!--    Export To Excel</a>-->
                        <button type="button" class="btn btn-info mb-3" data-toggle="modal"
                            data-target="#importKaryawan"><i class="fas fa-book"></i>
                            Export / Import Excel
                        </button>
                        {{-- modal import excel karyawan --}}
                        <!-- Modal -->
                        <form action="{{ route('importKaryawan') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal fade" id="importKaryawan" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content ">
                                        <div class="modal-header btn-costume">
                                            <h5 class="modal-title text-dark" id="exampleModalLabel">Import Gaji</h5>
                                            <button type="button" class="close text-dark" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <table>
                                                    <tr>
                                                        <td width="100" class="pl-2">
                                                            <img width="80px" src="{{ asset('adminlte') }}/images/1.png"
                                                                alt="">
                                                        </td>
                                                        <td>
                                                            <span style="font-size: 20px;"><b> Download Excel
                                                                    template</b></span><br>
                                                            File ini memiliki kolom header dan isi yang sesuai dengan data
                                                            karyawan
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('excelKaryawanAgrilaras') }}"
                                                                class="btn btn-primary btn-sm"><i
                                                                    class="fa fa-download"></i> DOWNLOAD TEMPLATE</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <hr>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="100" class="pl-2">
                                                            <img width="80px" src="{{ asset('adminlte') }}/images/2.png"
                                                                alt="">
                                                        </td>
                                                        <td>
                                                            <span style="font-size: 20px;"><b> Upload Excel
                                                                    template</b></span><br>
                                                            Setelah mengubah, silahkan upload file.
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="id_departemen"
                                                                value="{{ $id_departemen }}">
                                                            <input type="file" name="file" class="form-control">
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                            <div class="row">
                                                <div class="col-12">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Edit / Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        {{-- akhir modal import excel karyawan --}}
                        <form action="{{ route('addKaryawan', ['id_departemen' => $id_departemen]) }}" method="post">
                            @csrf
                            <!-- Modal tambah karyawan-->
                            <div class="modal fade" id="tambahKaryawan" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Karyawan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row form-group">
                                                <div class="col-lg-12">
                                                    <label for="">Nama Karyawan</label>
                                                    <input type="text" name="nama_karyawan" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-lg-12">
                                                    <label for="">Posisi</label>
                                                    <input type="text" name="posisi" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-lg-12">
                                                    <label for="">Tanggal Masuk</label>
                                                    <input type="date" name="tanggal_masuk" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <label for="">Departemen</label>
                                                @foreach ($departemen as $d)
                                                    <input type="hidden" value="{{ $d->id_departemen }}"
                                                        name="id_departemen">
                                                    <input type="text" class="form-control" readonly
                                                        value="{{ $d->nama_departemen }}">
                                                @endforeach
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-lg-3">
                                                    <label for="">Rp M</label>
                                                    <input required type="number" min="0" name="rp_m"
                                                        class="form-control">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="">Rp E</label>
                                                    <input type="number" min="0" name="rp_e"
                                                        class="form-control">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="">Rp SP</label>
                                                    <input type="number" min="0" name="rp_sp"
                                                        class="form-control">
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="">Rp Bulanan</label>
                                                    <input type="number" min="0" name="g_bulanan"
                                                        class="form-control">
                                                </div>

                                            </div>



                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" name="simpan" value="Simpan" id="tombol"
                                                class="btn btn-primary mt-3">
                                            <button type="button" class="btn btn-secondary  mt-3"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        {{-- akhir modal tambah karyawan --}}
                        </form>
                        <div class="card-body">
                            @include('flash.flash')
                            <table id="example1" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Id Karyawan</th>
                                        <th>Nama Karyawan</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Posisi</th>
                                        <th>Departemen</th>
                                        <th>Rp M</th>
                                        <th>Rp E</th>
                                        <th>Rp SP</th>
                                        <th>Bulanan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($karyawan as $d)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $d->id_karyawan }}</td>
                                            <td>{{ $d->nama_karyawan }}</td>
                                            <td>{{ $d->tanggal_masuk }}</td>
                                            <td>{{ $d->posisi }}</td>
                                            <td>{{ $d->nama_departemen }}</td>
                                            <td>{{ $d->rp_m }}</td>
                                            <td>{{ $d->rp_e == '' ? '0' : $d->rp_e }}</td>
                                            <td>{{ $d->rp_sp == '' ? '0' : $d->rp_sp }}</td>
                                            <td>{{ $d->g_bulanan == '' ? '0' : $d->g_bulanan }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-success" data-toggle="modal"
                                                    data-target="#editKaryawan{{ $d->id_karyawan }}"><i
                                                        class="fas fa-edit"></i></a>
                                                <form class="d-inline-block"
                                                    action="{{ route('deleteKaryawan', ['id_departemen' => $d->id_departemen]) }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="id_karyawan"
                                                        value="{{ $d->id_karyawan }}">
                                                    <button onclick="return confirm('Apakah anda yakin ? ')"
                                                        class="btn btn-sm btn-danger"><i
                                                            class="fas fa-trash"></i></button>
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
        @foreach ($karyawan as $d)
            <form action="{{ route('editKaryawan', ['id_departemen' => $id_departemen]) }}" method="post">
                @csrf
                @method('patch')
                <!-- Modal -->
                <div class="modal fade" id="editKaryawan{{ $d->id_karyawan }}" tabindex="-1" role="dialog"
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
                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <label for="">Nama Karyawan</label>
                                        <input type="hidden" name="id_karyawan" value="{{ $d->id_karyawan }}">
                                        <input type="text" name="nama_karyawan" value="{{ $d->nama_karyawan }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <label for="">Posisi</label>
                                        <input type="text" name="posisi" value="{{ $d->posisi }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <label for="">Tanggal Masuk</label>
                                        <input type="date" name="tanggal_masuk" value="{{ $d->tanggal_masuk }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    @php
                                        $ada = DB::table('tb_gaji')
                                            ->where('id_karyawan', $d->id_karyawan)
                                            ->first();
                                    @endphp
                                    @if ($ada)
                                        <div class="col-lg-3">
                                            <label for="">Rp M</label>
                                            <input value="{{ $ada->rp_m }}" type="number" min="0"
                                                name="rp_m" class="form-control">
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="">Rp E</label>
                                            <input value="{{ $ada->rp_e }}" type="number" min="0"
                                                name="rp_e" class="form-control">
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="">Rp SP</label>
                                            <input value="{{ $ada->rp_sp }}" type="number" min="0"
                                                name="rp_sp" class="form-control">
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="">Rp Bulanan</label>
                                            <input value="{{ $ada->g_bulanan }}" type="number" min="0"
                                                name="g_bulanan" class="form-control">
                                        </div>
                                    @else
                                        <div class="col-lg-3">
                                            <label for="">Rp M</label>
                                            <input type="number" min="0" name="rp_m" class="form-control">
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="">Rp E</label>
                                            <input type="number" min="0" name="rp_e" class="form-control">
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="">Rp SP</label>
                                            <input type="number" min="0" name="rp_sp" class="form-control">
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="">Rp Bulanan</label>
                                            <input type="number" min="0" name="g_bulanan" class="form-control">
                                        </div>
                                    @endif


                                </div>




                            </div>
                            <div class="modal-footer">
                                <input type="submit" name="simpan" value="Simpan" id="tombol"
                                    class="btn btn-primary mt-3">
                                <button type="button" class="btn btn-secondary  mt-3"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endforeach
    @endsection
