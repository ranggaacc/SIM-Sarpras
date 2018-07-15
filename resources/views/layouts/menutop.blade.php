{{-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button> --}}
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/user">SIM-SARPRAS</a><img src="{{asset('images/logoipb.png')}}" style="margin-top: 5px;width: 42px;">
</div>
<ul class="nav navbar-top-links navbar-right">
    <li></li>
    <li>
    <body onload="startTime()">
        &nbsp&nbsp<i class="fa fa-clock-o" style="color:white;">&nbsp</i>
        <c id="waktu" style="color:white; font-family:roboto; font-style:normal;"></c>
    </li>
    <li>
        &nbsp&nbsp&nbsp&nbsp<i class='fa fa-calendar' style='color:white;'>&nbsp</i>
        <?php
            echo "<c id='time' style='color:white; font-family:roboto; font-style:normal;'>".date('F jS\, Y ')."</c>";
        ?>
    </li>
{{--         @if(Auth::user()->user_si[0]->id_role=='1')
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">       
                    <i class="fa fa-bell fa-fw"></i> {{ count($notifs) }}<b class="caret"></b> 
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li class="divider"></li>
                    @foreach($notifs as $notif)
                        <li>
                            <a href="/pengadaanadmin/{{Hashids::encode($notif->id)}}">
                                <div>
                                    <i class="fa fa-fw fa-book"></i> Pengajuan Pengadaan unit {{ $notif->unit }}
                                    <br>
                                    <div class="text-muted small">tanggal pengajuan {{ date('j F Y', strtotime($notif->tanggal_pengajuan))}}
                                    </div>
                                    <div class="text-muted small" style="color: orange;">Menunggu persetujuan
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                    @endforeach               
                </ul>
            </li>
        @endif
        @if(Auth::user()->user_si[0]->id_role=='2')
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">       
                    <i class="fa fa-bell fa-fw"></i> {{ count($notif2s) }}<b class="caret"></b> 
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li class="divider"></li>
                    @foreach($notif2s as $notif)
                        <li>
                            <a href="{{route('pengadaan.index')}}">
                                <div>
                                    <i class="fa fa-fw fa-book"></i> Pengajuan Pengadaan oleh {{ $notif->pengaju }}
                                    <br>
                                    <div class="text-muted small">tanggal pengajuan {{ date('j F Y', strtotime($notif->tanggal_pengajuan))}}
                                    </div>
                                    @if($notif->approvement=='1')
                                    <div class="text-muted small" style="color: green">
                                        Telah disetujui
                                    </div>
                                    @elseif($notif->approvement=='2')
                                    <div class="text-muted small" style="color: red">
                                        Ditolak
                                    </div>
                                    @endif
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                    @endforeach               
                </ul>
            </li>
        @endif
        @if(Auth::user()->id_pegawai==null)
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">       
                    <i class="fa fa-bell fa-fw"></i> {{ count($notif2s) }}<b class="caret"></b> 
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li class="divider"></li>
                    @foreach($notif2s as $notif)
                        <li>
                            <a href="{{route('pengadaan.index')}}">
                                <div>
                                    <i class="fa fa-fw fa-book"></i> Pengajuan Pengadaan oleh 
                                    <br>
                                    <div class="text-muted small">tanggal pengajuan 
                                    </div>
                                    @if($notif->approvement=='1')
                                    <div class="text-muted small" style="color: green">
                                        Telah disetujui
                                    </div>
                                    @elseif($notif->approvement=='2')
                                    <div class="text-muted small" style="color: red">
                                        Ditolak
                                    </div>
                                    @endif
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                    @endforeach               
                </ul>
            </li>
        @endif --}}
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i> {{ Auth::user()->name }} <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            @if(Auth::user()->id_pegawai!=0)
            <li>
                <a href="/editprofil/{{Hashids::encode(Auth::user()->id,10)}}" class=""><i class="fa fa-gear fa-fw"></i> Edit Password</a>
                <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out fa-fw"></i> Keluar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> 
                    {{ csrf_field() }}
                </form>

            </li>
            @else
            <li>
                <a href="/editprofilpeminjam/{{Hashids::encode(Auth::user()->id,10)}}" class=""><i class="fa fa-gear fa-fw"></i> Edit Profil</a>
                <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out fa-fw"></i> Keluar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> 
                    {{ csrf_field() }}
                </form>

            </li>
            @endif
        </ul>
    </li>
</ul>