@extends('template.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Shift</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Shift</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <section class="col-lg-7 connectedSortable">
                        @include('flash.flash')
                        <div class="card">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Shift</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    <form action="{{ route('addShift') }}" method="post">
                                        @csrf
                                        <tr>
                                            <td></td>
                                            <td><input class="form-control" type="text" placeholder="Shift" name="status">
                                            </td>
                                            <td><input class="form-control" type="text" placeholder="keterangan"
                                                    name="keterangan"></td>
                                            <td><input type="submit" class="btn btn-sm btn-primary" value="Simpan"></td>
                                        </tr>
                                    </form>
                                    @foreach ($shift as $d)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $d->status }}</td>
                                            <td>{{ $d->keterangan }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-success" data-toggle="modal"
                                                    data-target="#editShift{{ $d->id_status }}"><i
                                                        class="fas fa-edit"></i></a>
                                                <form class="d-inline-block" action="{{ route('deleteShift') }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $d->id_status }}">
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
                </div>
            </div>
        </section>
    </div>

    @foreach ($shift as $d)
        <form action="{{ route('editShift') }}" method="post">
            @csrf
            @method('patch')
            <!-- Modal -->
            <div class="modal fade" id="editShift{{ $d->id_status }}" tabindex="-1" role="dialog"
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
                            <label for="">Shift</label>
                            <input type="hidden" name="id" value="{{ $d->id_status }}">
                            <input type="text" name="status" value="{{ $d->status }}" class="form-control">
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
