<style>
    @media (max-width: 767px) {
        #thnama {
            white-space: nowrap;
            position: sticky;
            left: 2000;
            z-index: 999;
        }
    }

    .scrl {
        overflow: auto;
    }

</style>
<a id="download" class="btn btn-sm btn-success mb-3" {{-- {{ route('downloadAbsAgri', ['id_departemen' => 4]) }} --}}
    href="{{ route('downloadAbsAgri', ['id_departemen' => 4, 'bulanDwn' => $bulan, 'tahunDwn' => $tahun_2]) }}">
    <i class="fa fa-download"></i> DOWNLOAD
</a>
<div class="card">
    <table style="z-index: 999999;" class="table table-lg table-striped table-bordered" width="100%">
        <thead class="table-success">
            <tr>
                @php
                    $tgl = getdate();
                    
                    $bulan;
                    $tahun_2;
                    $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun_2);
                    $total = $tanggal;
                @endphp
                <th class="bg-dark" id="thnama" style="white-space: nowrap;
                position: sticky;
                left: 0;
                z-index: 999;">NAMA
                </th>
                @for ($i = 1; $i <= $total; $i++)
                    <th class="text-center bg-dark tdTgl">{{ $i }}</th>
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
                    <td class="bg-dark" id="nama" style="white-space: nowrap;position: sticky;
                    left: 0;
                    margin-left:40%;
                    z-index: 999;">
                        <h5>{{ $d->nama_karyawan }}</h5>
                    </td>
                    @for ($i = 1; $i <= $total; $i++)
                        @php
                            $data = DB::table('absensi_agrilaras')
                                ->select('absensi_agrilaras.*')
                                ->where('id_karyawan', '=', $d->id_karyawan)
                                ->whereDay('tanggal_masuk', '=', $i)
                                ->whereMonth('tanggal_masuk', '=', $bulan)
                                ->whereYear('tanggal_masuk', '=', $tahun_2)
                                ->first();
                            
                        @endphp
                        <?php if($data) { ?>
                        @if ($data->status == 'M')
                            <td class="text-center text-primary bg-white">
                                <a href="javascript:void(0);" onclick="return false;"
                                    class="btnDelete btn btn-block btn-success" status="OFF"
                                    id_absen="{{ $data->id }}" tahun="{{ $tahun_2 }}"
                                    bulan="{{ $bulan }}">
                                    M
                                </a>
                            </td>
                            @php
                                $totalM++;
                            @endphp
                        @else
                            <td class="bg-info">
                                <a href="{{ route('update_agrilaras', [
                                    'id_departemen' => 4,
                                    'id_absen' => $data->id,
                                ]) }}"
                                    class="btn btn-block  btn-info">
                                    OFF
                                </a>
                            </td>
                            @php
                                $totalOff++;
                            @endphp
                        @endif
                        <?php }else { ?>
                        <td class="bg-info tdTgl">
                            <a href="javascript:;" onclick="return confirm('Apakah anda yakin ?');" class="btnInput btn btn-block  btn-info"
                                status="M" id_karyawan="{{ $d->id_karyawan }}" tahun="{{ $tahun_2 }}"
                                bulan="{{ $bulan }}" tanggal="{{ $tahun_2 . '-' . $bulan . '-' . $i }}">
                                OFF
                            </a>
                        </td>
                        @php
                            $totalOff++;
                        @endphp
                        <?php } ?>
                    @endfor
                    @php
                        $to = 1;
                    @endphp
                    <td class="bg-light totalM">{{ $totalM }} </td>
                    <td class="bg-light totalOff">{{ $totalOff }} </td>
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
</div>
<script>
    $(document).ready(function() {
        // $(document).on('click', '#download', function() {
        //     var totalM = $('.totalM').text().split()
        //     var totalOff = $('.totalOff').text()

        //     alert(totalM)
        // })
    })
</script>
