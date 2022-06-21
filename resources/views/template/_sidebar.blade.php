<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        <img src="https://1.bp.blogspot.com/-efcrgVn7kNs/X3PuJdVayDI/AAAAAAAAG_s/gtyVvD55QSUJMI_zUF9ripq4VFWhu6bRQCLcBGAsYHQ/s512/EABS.png"
            width="80" alt="AdminLTE Logo" style="opacity: .8">
        <span>HOME</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->



        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open">
                    <ul class="nav nav-treeview">
                        @php
                            $id_user = Auth::user()->id;
                            
                            $data = DB::select(DB::raw(" SELECT a.*,b.id_menu FROM menu AS a LEFT JOIN permisi AS b ON b.id_menu = a.id_menu WHERE b.id_user = $id_user AND a.id_departemen = $id_departemen AND a.sub_menu = 0"));
                            $absen = 'book';
                            $karyawan = 'user';
                            $permisi = 'key';
                        @endphp
                        @foreach ($data as $d)
                            @php
                                if ($d->nama_menu == 'permission') {
                                    $d->nama_menu = 'users';
                                }
                                
                            @endphp
                            @if ($d->nama_menu == 'DB 2')
                                @php
                                    continue;
                                @endphp
                            @endif
                            <li class="nav-item">
                                <a href="{{ route($d->rot, ['id_departemen' => $d->id_departemen]) }}"
                                    class="nav-link {{ Request::is($d->nama_menu) ? 'active' : '' }}">
                                    <i class="fas fa-{{ $d->icon }} nav-icon"></i>
                                    <p>{{ strtoupper($d->nama_menu) }}</p>
                                </a>
                            </li>
                        @endforeach
                        <?php if($id_departemen == 1) { ?>
                        {{-- MENU DB --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    DB
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @php
                                    $sub_navbar = DB::table('permisi')
                                        ->join('menu', 'permisi.id_menu', '=', 'menu.id_menu')
                                        ->where('sub_menu', 1)
                                        ->where('permisi.id_user', $id_user)
                                        ->get();
                                @endphp
                                @foreach ($sub_navbar as $sn)
                                    <li class="nav-item">
                                        <a href="{{ route($sn->rot, ['id_departemen' => 1]) }}"
                                            class="nav-link {{ Request::is($sn->nama_menu) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ strtoupper($sn->nama_menu) }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        {{-- end menu db --}}
                        <?php }elseif($id_departemen == 4) { ?>
                        {{-- MENU DB --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <p>
                                    DB
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @php
                                    $sub_navbar = DB::table('permisi')
                                        ->join('menu', 'permisi.id_menu', '=', 'menu.id_menu')
                                        ->where('sub_menu', 2)
                                        ->where('permisi.id_user', $id_user)
                                        ->get();
                                @endphp
                                @foreach ($sub_navbar as $sn)
                                    <li class="nav-item">
                                        <a href="{{ route($sn->nama_menu, ['id_departemen' => 1]) }}"
                                            class="nav-link {{ Request::is($sn->nama_menu) ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ strtoupper($sn->nama_menu) }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        {{-- end menu db --}}
                        <?php }else { ?>
                        <?php } ?>
                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
