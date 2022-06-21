@extends('template.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">
                    <div class="col-sm-6">
                        @php
                            function tgl_indo($tanggal)
                            {
                                $bulan = [
                                    1 => 'Januari',
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
                                    'Desember',
                                ];
                                $pecahkan = explode('-', $tanggal);
                            
                                // variabel pecahkan 0 = tanggal
                                // variabel pecahkan 1 = bulan
                                // variabel pecahkan 2 = tahun
                            
                                return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
                            }
                        @endphp
                        <h1 class="m-0 text-nowrap">Absensi Anak Laki : {{ tgl_indo($dari) }} -
                            {{ tgl_indo($sampai) }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Absensi Anak Laki</li>
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
                        <form action="" method="get">
                            <div class="row ml-3">
                                <div class="col-sm-3">
                                    <input type="date" required class="form-control" id="dari" name="tglDari">
                                </div>
                                <span class="ml-2 mr-2 mt-2">-</span>
                                <div class="col-sm-3">
                                    <input type="date" required class="form-control" id="sampai" name="tglSampai">
                                </div>
                                <div class="col-sm-2 mt-2">
                                    <button class="btn btn-sm btn-info" id="btnFilter" type="submit">view</button>
                                </div>
                            </div>
                        </form><br>
                        <form action="{{ route('addAbsensi') }}" method="post">
                            @csrf
                            <button type="button" class="btn btn-primary mb-3 ml-4" data-toggle="modal"
                                data-target="#tambahAbsensi">
                                + Tambah Absensi
                            </button>
                            <a href="{{ route('excel') }}" class="btn btn-success mb-3"><i class="fas fa-file-excel"></i>
                                Export All</a>
                            <button type="button" class="btn btn-success mb-3" data-toggle="modal"
                                data-target="#exportPertanggal"><i class="fas fa-file-excel"></i>
                                Export Pertanggal
                            </button>
                            <button type="button" class="btn btn-danger mb-3" data-toggle="modal"
                                data-target="#hapusPertanggal"><i class="fa fa-trash"></i>
                                Hapus Pertanggal
                            </button>
                            <br>

                            <style>
                                .modal-lg-max {
                                    max-width: 900px;
                                }

                            </style>

                            <!-- Modal -->
                            <div class="modal fade" id="tambahAbsensi" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Absensi</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <label for="">Tanggal</label>
                                                    <input required type="date" name="tanggal" class="form-control mb-3">
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group" data-select2-id="93">
                                                        <label>Karyawan</label>
                                                        <select required name="id_karyawan[]"
                                                            class="select2 select2-hidden-accessible" multiple=""
                                                            data-placeholder="Select a State" style="width: 100%;"
                                                            data-select2-id="7" tabindex="-1" aria-hidden="true">
                                                            @foreach ($karyawan as $d)
                                                                <option value="{{ $d->id_karyawan }}">
                                                                    {{ strtoupper($d->nama_karyawan) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <label for="">Pemakai Jasa</label>
                                                    <select class="form-control" name="id_pemakai" id="">
                                                        @foreach ($pemakai as $d)
                                                            <option value="{{ $d->id_pemakai }}">{{ $d->pemakai }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-3">
                                                    <label for="">Jenis Pekerjaan</label>
                                                    <select class="form-control mb-3" name="id_jenis" id="">
                                                        @foreach ($jenis_pekerjaan as $d)
                                                            <option value="{{ $d->id }}">
                                                                {{ $d->jenis_pekerjaan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                <div class="col-3">
                                                    <label for="">Keterangan / Waktu</label>
                                                    <input type="text" placeholder="keterangan / waktu" name="keterangan"
                                                        class="form-control mb-3">
                                                </div>
                                                <div id="detail_absensi">

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
                            </div>
                        </form>
                        {{-- modal export pertanggal --}}
                        <form action="{{ route('exportPertanggal') }}">
                            <div class="modal fade" id="exportPertanggal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md-6" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Export Pertanggal</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <label for="">Dari</label>
                                                    <input required type="date" name="dari" class="form-control mb-3">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Sampai</label>
                                                    <input required type="date" name="sampai" class="form-control mb-3">
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
                            </div>
                        </form>

                        {{-- end export pertanggal --}}
                        {{-- modal hapus pertanggal --}}
                        <form action="{{ route('hapusPertanggal') }}">
                            <div class="modal fade" id="hapusPertanggal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md-6" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Hapus Pertanggal</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <label for="">Dari</label>
                                                    <input required type="date" name="dari" class="form-control mb-3">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="">Sampai</label>
                                                    <input required type="date" name="sampai" class="form-control mb-3">
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
                            </div>
                        </form>
                        {{-- end hapus pertanggal --}}

                        @include('flash.flash')
                        <div class="card-body">
                            <table id="example3" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Karyawan</th>
                                        <th>Nama Karyawan</th>
                                        <th>Tanggal</th>
                                        <th>Jenis Pekerjaan</th>
                                        <th>Pemakai Jasa</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($absensi as $d)
                                        <tr align="center">
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $d->id_karyawan }}</td>
                                            <td>{{ $d->nama_karyawan }}</td>
                                            <td>{{ $d->tanggal }}</td>
                                            <td>{{ strtolower($d->jenis_pekerjaan) }}</td>
                                            <td>{{ $d->pemakai }}</td>
                                            <td>{{ $d->keterangan }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-success" id="edit={{ $d->id }}"
                                                    data-toggle="modal" data-target="#editAbsensi{{ $d->id }}"><i
                                                        class="fas fa-edit"></i></a>
                                                <form class="d-inline-block"
                                                    action="{{ route('deleteAbsensi', ['tglDari' => $dari, 'tglSampai' => $sampai]) }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $d->id }}">
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
        @foreach ($absensi as $d)
            <form action="{{ route('editAbsensi', ['tglDari' => $dari, 'tglSampai' => $sampai]) }}" method="post">
                @csrf
                @method('patch')
                <!-- Modal -->
                <div class="modal fade" id="editAbsensi{{ $d->id }}" tabindex="-1" role="dialog"
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
                                <input type="hidden" name="id" value="{{ $d->id }}">
                                <label for="">Nama Karyawan</label>
                                <select class="form-control" name="id_karyawan" id="">
                                    @foreach ($karyawan as $p)
                                        <option value="{{ $p->id_karyawan }}"
                                            {{ $p->id_karyawan == $d->id_karyawan ? 'selected' : '' }}>
                                            {{ $p->nama_karyawan }}</option>
                                    @endforeach
                                </select>
                                <label for="">Tanggal</label>
                                <input type="date" value="{{ $d->tanggal }}" name="tanggal" class="form-control mb-3">
                                <label for="">Jenis Pekerjaan</label>
                                <select class="form-control" name="id_jenis" id="">
                                    @foreach ($jenis_pekerjaan as $p)
                                        <option value="{{ $p->id }}"
                                            {{ $p->id == $d->id_jenis_pekerjaan ? 'selected' : '' }}>
                                            {{ $p->jenis_pekerjaan }}</option>
                                    @endforeach
                                </select>
                                <label for="">Pemakai Jasa</label>
                                <select class="form-control" name="id_pemakai" id="">
                                    @foreach ($pemakai as $p)
                                        <option value="{{ $p->id_pemakai }}"
                                            {{ $p->id_pemakai == $d->id_pemakai ? 'selected' : '' }}>
                                            {{ $p->pemakai }}</option>
                                    @endforeach
                                </select>
                                <label for="">Keterangan</label>
                                <input type="text" value="{{ $d->keterangan }}" name="keterangan" class="form-control mb-3">
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
    @section('script')
        <script>
            $(document).ready(function() {

                $('.select2').select2()
                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })

                var count_absensi = 1;
                $(function() {
                    $("#progressbar").progressbar({
                        value: 37
                    });
                });

            })
        </script>
    @endsection
@endsection
