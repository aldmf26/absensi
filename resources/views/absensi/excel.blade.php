<?php
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachmen; filename=Absensi Anak Laki.xls');
?>
<!DOCTYPE html>
<html lang="en">

<body>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Karyawan</th>
                <th>Nama Karyawan</th>
                <th>Tanggal</th>
                <th>Jenis Pekerjaan</th>
                <th>Pemakai Jasa</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($absensi as $d)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $d->id_karyawan }}</td>
                    <td>{{ $d->nama_karyawan }}</td>
                    <td>{{ $d->tanggal }}</td>
                    <td>{{ $d->jenis_pekerjaan }}</td>
                    <td>{{ $d->pemakai }}</td>
                    <td>{{ $d->keterangan }}</td>
                </tr>
            @endforeach

        </tbody>

    </table>
</body>

</html>
