@extends('template.master')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        @php
                            if ($id_departemen == 1) {
                                $menu = 'ANAK LAKI';
                            } elseif ($id_departemen == 2) {
                                $menu = 'SALON';
                            } elseif ($id_departemen == 3) {
                                $menu = 'RESTO';
                            } elseif ($id_departemen == 4) {
                                $menu = 'AGRI LARAS';
                            }
                        @endphp
                        <li class="breadcrumb-item">
                            <h1>DASHBOARD <span
                                    class="text-success border border-success rounded p-2">{{ @$menu }}</span></h1>
                        </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
