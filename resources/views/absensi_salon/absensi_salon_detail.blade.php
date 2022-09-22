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
                            $bulan_2 = ['bulan', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            $bulan1 = (int) $bulan;
                        @endphp
                        <h1 class="m-0">Absensi Salon : <span id="ketbul">{{ $bulan_2[$bulan1] }}</span> - <span
                                id="ketah">{{ $tahun_2 }}</span></h1><br>
                        <a class="btn btn-warning mb-3" href="{{ route('absensi_salon', ['id_departemen' => 2]) }}">
                            <i class="fa fa-arrow-left"></i> KEMBALI
                        </a>

                        <div class="row">
                            <div class="col-md-5">
                                <select id="bulan" class="form-control mb-3 " name="bulan">
                                    <option value="">--Pilih Bulan--</option>
                                    <option value="1" {{ (int) date('m') == 1 ? 'selected' : '' }}>Januari</option>
                                    <option value="2" {{ (int) date('m') == 2 ? 'selected' : '' }}>Februari</option>
                                    <option value="3" {{ (int) date('m') == 3 ? 'selected' : '' }}>Maret</option>
                                    <option value="4" {{ (int) date('m') == 4 ? 'selected' : '' }}>April</option>
                                    <option value="5" {{ (int) date('m') == 5 ? 'selected' : '' }}>Mei</option>
                                    <option value="6" {{ (int) date('m') == 6 ? 'selected' : '' }}>Juni</option>
                                    <option value="7" {{ (int) date('m') == 7 ? 'selected' : '' }}>Juli</option>
                                    <option value="8" {{ (int) date('m') == 8 ? 'selected' : '' }}>Agustus</option>
                                    <option value="9" {{ (int) date('m') == 9 ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ (int) date('m') == 10 ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ (int) date('m') == 11 ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ (int) date('m') == 12 ? 'selected' : '' }}>Desember</option>
                                </select>
                            </div>
                            @php
                                $years = range(2025, strftime('%Y', time()));
                            @endphp
                            <div class="col-md-5">
                                <select class="form-control mb-3 " id="tahun" name="tahun">
                                    <option value="">--Pilih Tahun--</option>
                                    <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
                                    @for ($i = date('Y'); $i <= date('Y') + 8; $i++)
                                        <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>

                            </div>

                            <div class="col-md-2">
                                <input type="submit" id="btntes" name="bulanSalon" class="btn btn-primary btn-sm btn-block"
                                    value="Simpan">
                            </div>
                        </div>



                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Absensi Salon</li>

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
                <div id="badan">

                </div>
        </section>
        <!-- right col -->
    </div>
    <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var url = "{{ route('tabelSalon') }}?bulan=" + {{ date('m') }} + "&tahun=" +
                {{ date('Y') }}

            getUrl(url)

            // chane select dbulan dan tahun
            $("#bulan").change(function(e) {
                var bulan = $("#bulan").val();
                var ketbul = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                    'September', 'Oktober', 'November', 'Desember'
                ]
                $("#ketbul").text(ketbul[bulan]);

            });
            $("#tahun").change(function(e) {
                var tahun = $("#tahun").val();
                var bulan = $("#bulan").val();
                $("#ketah").text(tahun);

            });
            // ----------------------------------

            function getUrl(url) {
                $("#badan").load(url, "data", function(response, status, request) {
                    this;
                });
            }

            $("#btntes").click(function(e) {
                var bulan = $("#bulan").val();
                var tahun = $("#tahun").val();
                var url = "{{ route('tabelSalon') }}?bulan=" + bulan + "&tahun=" + tahun
                getUrl(url)
            });

            $(document).on('click', '.btnInput', function() {
                var id_karyawan = $(this).attr('id_karyawan')
                var bulan = $(this).attr('bulan')
                var tahun = $(this).attr('tahun')
                var tanggal = $(this).attr('tanggal')
                var status = $(this).attr('status')
                var url = "{{ route('tabelSalon') }}?bulan=" + bulan + "&tahun=" + tahun

                $.ajax({
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    url: "{{ route('input_salon') }}?id_departemen=2&id_karyawan=" +
                        id_karyawan +
                        "&status=" + status + "&tanggal=" + tanggal,
                    success: function(response) {
                        getUrl(url)
                    }
                });
            })

            $(document).on('click', '.btnDelete', function() {
                var id_absen = $(this).attr('id_absen')
                var bulan = $(this).attr('bulan')
                var tahun = $(this).attr('tahun')
                var status = $(this).attr('status')
                var url = "{{ route('tabelSalon') }}?bulan=" + bulan + "&tahun=" + tahun

                $.ajax({
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    url: "{{ route('delete_salon') }}?id_departemen=3&id_absen=" + id_absen,
                    success: function(response) {
                        getUrl(url)
                    }
                });
            })



        });
    </script>

@endsection
