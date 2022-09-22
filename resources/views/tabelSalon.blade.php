<div class="row justify-content-center">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <!-- Button trigger modal -->

        <div class="card">
            <table class="table table-lg table-striped table-bordered table-responsive" width="100%">
                <thead class="table-success">
                    <tr>
                        @php
                            $tgl = getdate();
                            
                            $bulan;
                            $tahun_2;
                            $tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun_2);
                            $total = $tanggal;
                        @endphp
                        <th style="white-space: nowrap;position: sticky;
                        left: 0;
                        z-index: 999;">NAMA</th>
                        @for ($i = 1; $i <= $total; $i++)
                            <th class="text-center">{{ $i }}</th>
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
                            <td class="bg-dark" style="white-space: nowrap;position: sticky;
                            left: 0;
                            z-index: 999;">
                                <h5>{{ $d->nama_karyawan }}</h5>
                            </td>
                            @for ($i = 1; $i <= $total; $i++)
                                @php
                                    $data = DB::table('absensi_salon')
                                        ->select('absensi_salon.*')
                                        ->where('id_karyawan', '=', $d->id_karyawan)
                                        ->whereDay('tanggal_masuk', '=', $i)
                                        ->whereMonth('tanggal_masuk', '=', $bulan)
                                        ->whereYear('tanggal_masuk', '=', $tahun_2)
                                        ->first();
                                    
                                @endphp
                                <?php if($data) { ?>
                                @if ($data->status == 'M')
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btnDelete btn btn-block btn-success"
                                            status="OFF" id_absen="{{ $data->id }}" tahun="{{ $tahun_2 }}"
                                            bulan="{{ $bulan }}">
                                            M
                                        </a>
                                    </td>
                                    @php
                                        $totalM++;
                                    @endphp
                                @else
                                    <td class="bg-info">
                                        <a href="{{ route('update_salon', [
                                            'id_departemen' => 2,
                                            'bulan' => $bulan,
                                            'tahun' => $tahun_2,
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
                                <td class="bg-info">
                                    <a href="javascript:void(0)" class="btnInput btn btn-block  btn-info" status="M"
                                        id_karyawan="{{ $d->id_karyawan }}" tahun="{{ $tahun_2 }}"
                                        bulan="{{ $bulan }}"
                                        tanggal="{{ $tahun_2 . '-' . $bulan . '-' . $i }}">
                                        OFF
                                    </a>
                                </td>
                                @php
                                    $totalOff++;
                                @endphp
                                <?php } ?>
                            @endfor
                            <td class="bg-light">{{ $totalM }}</td>
                            <td class="bg-light">{{ $totalOff }}</td>

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
