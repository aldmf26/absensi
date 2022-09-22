
<table class="table" id="tb_absen">

    <thead>
        <tr>
            <th>No</th>
            <th>Nama Karyawan</th>
            @foreach ($shift as $s)
                <th>{{ $s->status }}</th>
            @endforeach
        </tr>
    </thead>
    <input type="hidden" value="{{ $tgl }}" id="tgl">
    <tbody>
        <?php $i = 1;
        foreach ($tb_karyawan as $t) : ?>

        <?php
        $absen = DB::table('absensi_agrilaras')
            ->where('id_karyawan', $t->id_karyawan)
            ->where('tanggal_masuk', $tgl)
            ->first();
        ?>
        <tr>
            @if (empty($absen))
                <td>{{ $i++ }}</td>
                <td>
                    {{ $t->nama_karyawan }}
                </td>
                @foreach ($shift as $s)
                <td>
                    <a href="javascript:void(0)" class="btn save btn-secondary" ket="{{ $s->status }}"
                        id_karyawan="{{ $t->id_karyawan }}">{{ $s->status }}</a>
                </td>
                @endforeach
            @else
                <td>{{ $i++ }}</td>
                <td>
                    {{ $t->nama_karyawan }}
                </td>
                @foreach ($shift as $h)
                <td>
                    @if ($absen->status == $h->status)
                        <a href="javascript:void(0)" class="btn btn-info btn-del" id_absen="<?= $absen->id ?>">{{ $h->status }}</a>
                    @else
                    <a href="javascript:void(0)" id_absen_edit="<?= $absen->id ?>" ket2="{{ $h->status }}"
                        class="btn btn-secondary btn-edit">{{ $h->status }}</a>
                    @endif
                </td>
                @endforeach
            @endif
            
        </tr>
        <?php endforeach ?>
 
    </tbody>

</table>

    {{-- datatable --}}
    <script src="{{ asset('adminlte') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script>
    $("#tb_absen").DataTable({
        "lengthChange": false,
        "autoWidth": false,
        "stateSave": true,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>
