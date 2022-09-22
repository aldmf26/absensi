<div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Karyawan</th>
                <th>Nama Karyawan</th>
                <th>Tanggal</th>
                <th>Jenis Pekerjaan</th>
                <th>Pemakai Jasa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($absensi as $d)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>KAR_{{ $d->id_karyawan }}</td>
                    <td>{{ $d->nama_karyawan }}</td>
                    <td>{{ $d->tanggal }}</td>
                    <td>{{ $d->jenis_pekerjaan }}</td>
                    <td>{{ $d->pemakai }}</td>
                    <td>
                        <a class="btn btn-success" id="edit={{ $d->id }}"
                            data-toggle="modal" data-target="#editAbsensi{{ $d->id }}"><i
                                class="fas fa-edit"></i></a>
                        <form class="d-inline-block" action="{{ route('deleteAbsensi') }}"
                            method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $d->id }}">
                            <button onclick="return confirm('Apakah anda yakin ? ')"
                                class="btn btn-danger"><i class="fas fa-trash"></i></button>
                        </form>

                    </td>
                </tr>
            @endforeach

        </tbody>

    </table>
</div>