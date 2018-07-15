@extends('layouts/master')
@section('title','Dashboard Eksekutif')
@section('content')
<body>

        <div id="page-wrapper">
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <br><br>
                            <b>Sarana & Prasarana</b>
                            <h4>
                            @if($unit->nama=='UIH')
                            <b>Dashboard Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Informasi & Humas)</h4></b>
                            @elseif($unit->nama=='UKBB')
                            <b>Dashboard Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Konservasi Budidaya Biofarmaka)</h4></b>
                            @elseif($unit->nama=='UKHP')
                            <b>Dashboard Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Kandang Hewan Percobaan)</h4></b>
                            @elseif($unit->nama=='UPPW')
                            <b>Dashboard Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Pilot Plant & Workshop)</h4></b>
                            @elseif($unit->nama=='LPSB')
                            <b>Dashboard Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Laboratorium PSB)</h4></b>
                            @else
                            <b>Dashboard Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Sekretariat)</h4></b>
                            @endif
                            </h4>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                @if($inventaris>0)
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-blue">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$inventaris}}</div>
                                    <div>Total Jenis Inventaris</div>
                                </div>
                            </div>
                        </div>
                        <a href="/jenis/{{ $nama_unit }}" role="button">
                            <div class="panel-footer">
                                <span class="pull-left">Lihat Selengkapnya</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-5x"><img src="{{asset('image/sarpras.png')}}" width="65"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$jumlahinventarisB}}</div>
                                    <div>Kondisi Baru</div>
                                    {{-- <br> --}}
                                </div>
                            </div>
                        </div>
                        <a href="/panel2/{{ $nama_unit }}">
                            <div class="panel-footer">
                                <span class="pull-left">Lihat Selengkapnya</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-5x"><img src="{{asset('image/sarpras.png')}}" width="65"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$jumlahinventarisRR}}</div>
                                    <div>Kondisi Rusak Ringan</div>
                                </div>
                            </div>
                        </div>
                        <a href="/panel3/{{ $nama_unit }}">
                            <div class="panel-footer">
                                <span class="pull-left">Lihat Selengkapnya</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-5x"><img src="{{asset('image/sarpras.png')}}" width="65"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$jumlahinventarisRB}}</div>
                                    <div>Kondisi Rusak Berat</div>
                                </div>
                            </div>
                        </div>
                        <a href="/panel4/{{ $nama_unit }}">
                            <div class="panel-footer">
                                <span class="pull-left">Lihat Selengkapnya</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart"></i> Chart Inventaris Berdasarkan Tahun

                            </div>
                            <div class="panel-body">
                                {!! Charts::assets() !!}
                                <center>
                                    {!! $chartinventaris->render() !!}
                                </center>
                            </div>
                        </div>
                    </div>
                <!-- /.row -->
                
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart"></i> Chart Kondisi Inventaris

                            </div>
                            <div class="panel-body">
                                {!! Charts::assets() !!}
                                <center>
                                    {!! $chartinventaris2->render() !!}
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="list3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-info col-lg-12">
                                 Arahkan <b>Pointer</b> <img src="{{asset('image/cursor.png')}}" width="35"> ke <b>
                                Bar Chart</b> untuk melihat <b>detail !</b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-success col-lg-12">
                                <b>Keterangan :</b>
                                   <ul>
                                      <li><b>B</b> &nbsp : Baru</li>
                                      <li><b>RR</b>: Rusak Ringan</li>
                                      <li><b>RB</b>: Rusak Berat</li>
                                   </ul>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        <!-- /#page-wrapper -->
            @else 
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif
    </div>



</body>
@endsection