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
                        <form action="{{ route('addPemakai') }}" method="post">
                            @csrf
                            <button type="button" class="btn btn-primary mb-3" data-toggle="modal"
                                data-target="#tambahPemakai">
                                + Tambah Pemakai Jasa
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="tambahPemakai" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah Pemakai Jasa</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="">pemakai Jasa</label>
                                            <input type="text" name="pemakai" class="form-control">
                                            <label for="">Keterangan</label>
                                            <input type="text" name="keterangan" class="form-control">
                                            <input type="submit" name="simpan" value="Simpan" id="tombol"
                                                class="btn btn-primary mt-3">
                                            <button type="button" class="btn btn-secondary  mt-3"
                                                data-dismiss="modal">Close</button>
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
                                        <th>Pemakai Jasa</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($pemakai_jasa as $d)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $d->pemakai }}</td>
                                            <td>{{ $d->keterangan }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-success" data-toggle="modal"
                                                    data-target="#editPemakai{{ $d->id_pemakai }}"><i
                                                        class="fas fa-edit"></i></a>
                                                <form class="d-inline-block" action="{{ route('deletePemakai') }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $d->id_pemakai }}">
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
        @foreach ($pemakai_jasa as $d)
            <form action="{{ route('editPemakai') }}" method="post">
                @csrf
                @method('patch')
                <!-- Modal -->
                <div class="modal fade" id="editPemakai{{ $d->id_pemakai }}" tabindex="-1" role="dialog"
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
                                <label for="">pemakai Jasa</label>
                                <input type="hidden" name="id" value="{{ $d->id_pemakai }}">
                                <input type="text" name="pemakai" value="{{ $d->pemakai }}" class="form-control">
                                <label for="">Keterangan</label>
                                <input type="text" name="keterangan" value="{{ $d->keterangan }}" class="form-control">
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
