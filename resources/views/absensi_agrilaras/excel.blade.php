<?php
header('Content-type: application/vnd-ms-excel');
header('Content-Disposition: attachmen; filename=Absensi Agri laras.xls');
?>
<!DOCTYPE html>
<html lang="en">

<body>
    @php
        $bulan_2 = ['bulan', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $bulan1 = (int) $bulan;
    @endphp
    <h1>Tanggal : {{ $bulan_2[$bulan1] }} {{ $tahun }}</h1>
    <table align="left" border="1">
        <thead>
            <tr>
                @php
                    $tgl = getdate();
                    
                    $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                    $total = $tanggal;
                @endphp
                <th width="80">ID KARYAWAN</th>
                <th>NAMA</th>
                @for ($i = 1; $i <= $total; $i++)
                    <th>{{ $i }}</th>
                @endfor
                <th>M</th>
                <th>OFF</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
                
            @endphp

            @foreach ($karyawan as $d)
                @php
                    $totalOff = 0;
                    $totalM = 0;
                @endphp
                <tr>
                    <td align="center">{{ $d->id_karyawan }}</td>
                    <td>{{ $d->nama_karyawan }}</td>
                    @for ($i = 1; $i <= $total; $i++)
                        @php
                            $data = DB::table('absensi_agrilaras')
                                ->select('absensi_agrilaras.*')
                                ->where('id_karyawan', '=', $d->id_karyawan)
                                ->whereDay('tanggal_masuk', '=', $i)
                                ->whereMonth('tanggal_masuk', '=', $bulan)
                                ->whereYear('tanggal_masuk', '=', $tahun)
                                ->first();
                            
                        @endphp
                        <?php if($data) { ?>
                        @if ($data->status == 'M')
                            <td align="center" style="color: green;">
                                M
                            </td>
                            @php
                                $totalM++;
                            @endphp
                        @else
                            <td>
                                OFF
                            </td>
                            @php
                                $totalOff++;
                            @endphp
                        @endif
                        <?php }else { ?>
                        <td align="center">
                            OFF
                        </td>
                        @php
                            $totalOff++;
                        @endphp
                        <?php } ?>
                    @endfor
                    @php
                        $to = 1;
                    @endphp
                    <td>{{ $totalM }} </td>
                    <td>{{ $totalOff }} </td>
                </tr>
                @if ($d->id_karyawan == $d->id_karyawan)
                    @php
                        continue;
                    @endphp

                @else
                    @php
                        break;
                    @endphp
                @endif
            @endforeach
        </tbody>

    </table>
</body>

</html>
