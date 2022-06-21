@extends('template.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User Management</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">User Management</li>
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
                        <button type="button" class="btn btn-primary mb-3 ml-4" data-toggle="modal"
                            data-target="#tambahUser">
                            + Tambah User
                        </button>
                        <!-- Modal tambah karyawan-->
                        <form action="{{ route('aksiReg', ['id_departemen' => $id_departemen]) }}" method="post">
                            @csrf
                            <div class="modal fade" id="tambahUser" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="">Nama</label>
                                            <input type="text" placeholder="nama" name="nama" class="form-control">
                                            <label for="">Username</label>
                                            <input type="text" placeholder="username" name="username"
                                                class="form-control"><br>
                                            <select class="form-control" name="jenis" id="">
                                                <option value="">- Jenis User -</option>
                                                <option value="Admin">Admin</option>
                                                <option value="Presiden">Presiden</option>
                                            </select><br>
                                            <label for="">Password</label>
                                            <input type="password" placeholder="*******" name="password"
                                                class="form-control">

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
                        <div class="card">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>jenis</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($login as $d)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $d->nama }}</td>
                                            <td>{{ $d->username }}</td>
                                            <td>{{ $d->jenis }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-info" data-toggle="modal"
                                                    data-target="#viewUser{{ $d->id }}"><i
                                                        class="fas fa-edit"></i></a>
                                                <a class="btn btn-sm btn-warning" data-toggle="modal"
                                                    data-target="#editUser{{ $d->id }}"><i
                                                        class="fas fa-key"></i></a>
                                                <form class="d-inline-block" action="{{ route('deleteUser') }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="id_user" value="{{ $d->id }}">
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
        {{-- @php
      $menu = [
            'Absensi', 'PemakaianJasa', 'jenisPekerjaan', 'Karyawan', 'UserManagement'
      ];
  @endphp --}}
        <!-- Awal Modal edit -->
        @foreach ($login as $d)
            <form action="{{ route('addUser') }}" method="post">
                @csrf


                <div class="modal fade" id="editUser{{ $d->id }}" tabindex="-1" role="dialog"
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
                                <label for="">Nama</label>
                                <input type="hidden" name="id_user" value="{{ $d->id }}">
                                <input type="text" readonly name="username" value="{{ $d->nama }}"
                                    class="form-control"><br>
                                <label for="">Permission :</label><br>
                                <div class="row">
                                    @php
                                        $no = 1;
                                        $laki = DB::table('menu')
                                            ->select('id_menu', 'nama_menu', 'sub_menu', 'id_departemen', 'urutan')
                                            ->where('id_departemen', 1)
                                            ->orderBy('urutan', 'asc')
                                            ->get();
                                        $agri = DB::table('menu')
                                            ->select('id_menu', 'nama_menu', 'sub_menu', 'id_departemen', 'urutan')
                                            ->where('id_departemen', 4)
                                            ->orderBy('urutan', 'asc')
                                            ->get();
                                        $marlef = 'ml-4';
                                        $permisi = DB::table('permisi')
                                            ->select('permisi.id_user')
                                            ->join('menu', 'permisi.id_menu', '=', 'menu.id_menu')
                                            ->join('users', 'permisi.id_user', '=', 'users.id')
                                            ->where('id_user', $d->id)
                                            ->orderBy('id_user')
                                            ->get();
                                    @endphp
                                    <div class="col-md-6">
                                        @foreach ($laki as $l)
                                            @php
                                                $menu_id = DB::table('permisi')
                                                    ->select('id_menu')
                                                    ->where('id_user', $d->id)
                                                    ->where('id_menu', $l->id_menu)
                                                    ->first();
                                                //  dd($menu_id);
                                                if ($l->nama_menu == 'permission') {
                                                    $l->nama_menu = 'users';
                                                }
                                                if ($l->nama_menu == 'DB 1') {
                                                    $l->nama_menu = 'DB';
                                                }
                                                
                                            @endphp
                                            <div class="{{ $l->sub_menu == 1 ? $marlef : '' }}">
                                                <input {{ $l->sub_menu == 4 ? 'disabled checked' : '' }}
                                                    {{ $menu_id ? 'checked' : '' }} type="checkbox"
                                                    value="{{ $l->id_menu }}" name="menu[]"
                                                    id="check{{ $no }}">
                                                <label for="">{{ $l->nama_menu }} <i
                                                        class="{{ $l->sub_menu == 3 ? 'fas fa-home' : '' }}"></i></label><br>
                                                </label>
                                            </div>
                                            @php
                                                $no++;
                                            @endphp
                                        @endforeach
                                    </div>
                                    <div class="col-md-6">
                                        @foreach ($agri as $l)
                                            @php
                                                $menu_id = DB::table('permisi')
                                                    ->select('id_menu')
                                                    ->where('id_user', $d->id)
                                                    ->where('id_menu', $l->id_menu)
                                                    ->first();
                                                //  dd($menu_id);
                                                if ($l->nama_menu == 'permission') {
                                                    $l->nama_menu = 'users';
                                                }
                                                if ($l->nama_menu == 'DB 2') {
                                                    $l->nama_menu = 'DB';
                                                }
                                                
                                            @endphp
                                            <div class="{{ $l->sub_menu == 2 ? $marlef : '' }}">
                                                <input {{ $l->sub_menu == 4 ? 'disabled checked' : '' }}
                                                    {{ $menu_id ? 'checked' : '' }} type="checkbox"
                                                    value="{{ $l->id_menu }}" name="menu[]"
                                                    id="check{{ $no }}">
                                                <label for="">{{ $l->nama_menu }} <i
                                                        class="{{ $l->sub_menu == 3 ? 'fas fa-home' : '' }}"></i></label><br>
                                                </label>
                                            </div>
                                            @php
                                                $no++;
                                            @endphp
                                        @endforeach
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
        @endforeach
        <!-- End Modal edit -->

        <!-- Awal View edit -->
        @foreach ($login as $d)
            <form action="{{ route('editUser') }}" method="post">
                @csrf
                @method('patch')

                <div class="modal fade" id="viewUser{{ $d->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">View Hak Akses</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" value="{{ $d->id }}">
                                <label for="">Nama</label>
                                <input type="text" name="nama" class="form-control" value="{{ $d->nama }}"><br>
                                <label for="">Jenis</label>
                                <select class="form-control" name="jenis" id="">
                                    <option value="Admin">Admin</option>
                                    <option value="Presiden">Presiden</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary  mt-3" data-dismiss="modal">Close</button>
                                <input type="submit" name="simpan" value="Simpan" id="tombol" class="btn btn-primary mt-3">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endforeach
        <!-- End View edit -->

        <script>
            $(document).ready(function() {
                var no = 1
                $("#tombol").click(function() {
                    alert("button");
                });
            });
        </script>
    @endsection
