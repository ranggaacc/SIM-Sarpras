@if(Auth::user()->user_si[0]->id_role=='2')
    <li class="active">
        <a href="/user"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
    </li>
{{--     <li class="">
        <a href="/kodebarang"><i class="fa fa-fw fa-book"></i> Daftar Kode Barang</a>
    </li> --}}
{{--     <li class="">
        <a href="/inventaris/create"><i class="fa fa-fw fa-edit"></i> Input Data Sarana & Prasarana</a>
    </li> --}}
    <li class="">
        <a href="/inventaris"><i class="fa fa-fw fa-table"></i> Daftar Sarana & Prasarana</a>
    </li>
    <li class="">
        <a href="/pengadaan"><i class="fa fa-fw fa-book"></i> Pengadaan Sarpras</a>
    </li>

@elseif(Auth::user()->user_si[0]->id_role=='3')
    <li class="active">
        <a href="/user"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
    </li>
    <li>
    <a href="#"><i class="fa fa-pie-chart"></i> Daftar Sarpras Unit<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li class="">
                <a href="/exe/{{'UKBB'}}">Sarpras Unit UKBB</a>
            </li>
            <li class="">
                <a href="/exe/{{'LPSB'}}">Sarpras Unit LPSB</a>
            </li>
            <li class="">
                <a href="/exe/{{'UKHP'}}">Sarpras Unit UKHP</a>
            </li>
            <li class="">
                <a href="/exe/{{'UPPW'}}">Sarpras Unit UPPW</a>
            </li>
            <li class="">
                <a href="/exe/{{'UIH'}}">Sarpras Unit UIH</a>
            </li>
            <li class="">
                <a href="/exe/{{'SEKRET'}}">Sarpras Sekretariat</a>
            </li>
        </ul>
    </li>
@elseif(Auth::user()->user_si[0]->id_role=='4')
    <li class="active">
        <a href="/peminjaman"><i class="fa fa-fw fa-edit"></i> Peminjaman Ruangan</a>
    </li>
{{--     <li class="">
        <a href="/peminjaman/peminjaman_index"><i class="fa fa-fw fa-book"></i> Daftar Ruangan</a>
    </li> --}}
@elseif(Auth::user()->user_si[0]->id_role=='1')
    <li class="active">
        <a href="/user"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
    </li>
    <li class="">
        <a href="/userdata"><i class="fa fa-fw fa-users"></i> Pengguna SIM-SARPRAS</a>
    </li>
    <li class="">
        <a href="/pengadaanadmin"><i class="fa fa-fw fa-edit"></i> Pengadaan Sarpras</a>
    </li>
    <li class="">
        <a href="/peminjamanadmin"><i class="fa fa-fw fa-edit"></i> Peminjaman Ruangan</a>
    </li>
{{--     <li class="">
        <a href="/kodebarang"><i class="fa fa-fw fa-book"></i> Daftar Kode Barang</a>
    </li> --}}
    <li class="">
        <a href="/ruangan"><i class="fa fa-fw fa-book"></i> Daftar Ruangan Biofarmaka</a>
    </li>
    <li class="">
        <a href="/sekretariat"><i class="fa fa-fw fa-book"></i> Sarpras Sekretariat</a>
    </li>
    <li>
        <a href="#"><i class="fa fa-list"></i> Daftar Sarpras Unit<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li class="active">
                <a href="/TabelInventarisAdmin/{{'UKBB'}}"><i class=""></i> Sarpras Unit UKBB</a>
            </li>
            <li class="active">
                <a href="/TabelInventarisAdmin/{{'LPSB'}}"><i class=""></i> Sarpras Unit LPSB</a>
            </li>
            <li class="active">
                <a href="/TabelInventarisAdmin/{{'UKHP'}}"><i class=""></i> Sarpras Unit UKHP</a>
            </li>
            <li class="active">
                <a href="/TabelInventarisAdmin/{{'UPPW'}}"><i class=""></i> Sarpras Unit UPPW</a>
            </li>
            <li class="active">
                <a href="/TabelInventarisAdmin/{{'UIH'}}"><i class=""></i> Sarpras Unit UIH</a>
            </li>
            <li class="active">
                {{-- <a href="/excelAdminAll"><i class="fa fa-fw fa-download"></i> Unduh Data Sarpras</a> --}}
                <a href="/sarprasall"><i class="fh"></i> Sarpras Semua Unit</a>
            </li>
        </ul>
    </li>

@endif