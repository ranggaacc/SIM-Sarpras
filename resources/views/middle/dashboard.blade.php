@extends('layouts/master')
@section('title','Dashboard')
@section('content')
<body>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <br><br>
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
                        @endif
                    </h1>
                </div>
            </div>
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
                        <a href="user/{{Auth::user()->pegawai->id_unit}}" role="button">
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
                        <a href="/panel/panel2">
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
                        <a href="/panel/panel3">
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
                        <a href="/panel/panel4">
                            <div class="panel-footer">
                                <span class="pull-left">Lihat Selengkapnya</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            @if($inventaris>0)
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart"></i> Chart Inventaris

                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                            {!! Charts::assets() !!}
                            <center>
                                {!! $chartinventaris->render() !!}
                            </center>
                            </div>
                            <br>
                            <div id="list3">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="alert alert-info col-lg-12">
                                             Arahkan <b>Pointer</b> <img src="{{asset('image/cursor.png')}}" width="35"> ke <b>Bar Chart</b> untuk melihat <b>detail !</b>
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
                        <!-- /.panel-body -->
                    </div>
                </div>
              </div>
              @else 
                  <div class="row">
                      <div class="col-lg-12">
                          <h3 class="text-center alert alert-info">Belum ada data</h3>
                      </div>
                  </div>
              @endif
            </div>
        </div>

{{--             <!-- Modal Detail JENIS SARPRAS-->
              <div class="modal fade in" id="ModalInventaris1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" value="">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header hidden-print">
                                <button type="button" class="close" data-dismiss="modal">
                                       <span aria-hidden="true">&times;</span>
                                       <span class="sr-only">Close</span>
                                </button>
                            </div>
                            
                            <!-- Modal Body -->
                              <div class="modal-body">  
                                <div class="panel panel-lg-default">
                                  <div class="table-responsive">        
                                    <table class="table table-striped">
                                          <tr style="background-color: white">
                                            <td colspan="2" align="center" ><h5 style="font-family:roboto; color:black;">JENIS INVENTARIS</h5></td>
                                          </tr>
                                          @foreach($inventarisgetall as $inventaris)
                                          <tr>
                                            <td align="left"><b>{{$y++.'.'}}</b></td>
                                            <td align="left"><b>{{$inventaris->nama_barang}}</b></td>
                                          </tr>
                                          @endforeach
                                    </table>
                                    </div>
                                  </div>              
                              </div>
                            <div class="modal-footer">
                        </div>
                    </div>
                </div>
              </div>
            <!-- Modal Detail KONDISI BARU-->
              <div class="modal fade in" id="ModalInventaris2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" value="">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header hidden-print">
                                <button type="button" class="close" data-dismiss="modal">
                                       <span aria-hidden="true">&times;</span>
                                       <span class="sr-only">Close</span>
                                </button>
                            </div>
                            
                            <!-- Modal Body -->
                              <div class="modal-body">  
                                <div class="panel panel-lg-default">
                                  <div class="table-responsive">        
                                    <table class="table table-striped">
                                          <tr style="background-color: white">
                                            <td><h5 style="font-family:roboto; color:black;">NO.</h5></td>
                                            <td><h5 style="font-family:roboto; color:black;">JENIS INVENTARIS</h5></td>
                                            <td><h5 style="font-family:roboto; color:black;">JUMLAH BARU</h5></td>
                                            <td><h5 style="font-family:roboto; color:black;">TAHUN PEMBELIAN</h5></td>
                                          </tr>
                                          @foreach($inventarispanel2 as $inventaris)
                                          <tr>
                                            <td align="left"><b>{{$y2++.'.'}}</b></td>
                                            <td align="left"><b>{{$inventaris->nama_barang}}</b></td>
                                            <td align="left"><b>{{$inventaris->B}}</b></td>
                                            <td align="left"><b>{{$inventaris->tahun_barang}}</b></td>

                                          </tr>
                                          @endforeach
                                    </table>
                                    </div>
                                  </div>              
                              </div>
                            <div class="modal-footer">
                        </div>
                    </div>
                </div>
              </div>
        <!-- Modal Detail KONDISI RUSAK RINGAN-->
              <div class="modal fade in" id="ModalInventaris3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" value="">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header hidden-print">
                                <button type="button" class="close" data-dismiss="modal">
                                       <span aria-hidden="true">&times;</span>
                                       <span class="sr-only">Close</span>
                                </button>
                            </div>
                            
                            <!-- Modal Body -->
                              <div class="modal-body">  
                                <div class="panel panel-lg-default">
                                  <div class="table-responsive">        
                                    <table class="table table-striped">
                                          <tr style="background-color: white">
                                            <td><h5 style="font-family:roboto; color:black;">NO.</h5></td>
                                            <td><h5 style="font-family:roboto; color:black;">JENIS INVENTARIS</h5></td>
                                            <td><h5 style="font-family:roboto; color:black;">JUMLAH RUSAK RINGAN</h5></td>
                                            <td><h5 style="font-family:roboto; color:black;">TAHUN PEMBELIAN</h5></td>
                                          </tr>
                                          @foreach($inventarispanel3 as $inventaris)
                                          <tr>
                                            <td align="left"><b>{{$y3++.'.'}}</b></td>
                                            <td align="left"><b>{{$inventaris->nama_barang}}</b></td>
                                            <td align="left"><b>{{$inventaris->RR}}</b></td>
                                            <td align="left"><b>{{$inventaris->tahun_barang}}</b></td>
                                          </tr>
                                          @endforeach
                                    </table>
                                    </div>
                                  </div>              
                              </div>
                            <div class="modal-footer">
                        </div>
                    </div>
                </div>
              </div>
        <!-- Modal Detail KONDISI RUSAK BERAT-->
              <div class="modal fade in" id="ModalInventaris4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" value="">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header hidden-print">
                                <button type="button" class="close" data-dismiss="modal">
                                       <span aria-hidden="true">&times;</span>
                                       <span class="sr-only">Close</span>
                                </button>
                            </div>
                            
                            <!-- Modal Body -->
                              <div class="modal-body">  
                                <div class="panel panel-lg-default">
                                  <div class="table-responsive">        
                                    <table class="table table-striped">
                                          <tr style="background-color: white">
                                            <td><h5 style="font-family:roboto; color:black;">NO.</h5></td>
                                            <td><h5 style="font-family:roboto; color:black;">JENIS INVENTARIS</h5></td>
                                            <td><h5 style="font-family:roboto; color:black;">JUMLAH RUSAK BERAT</h5></td>
                                            <td><h5 style="font-family:roboto; color:black;">TAHUN PEMBELIAN</h5></td>
                                          </tr>
                                          @foreach($inventarispanel4 as $inventaris)
                                          <tr>
                                            <td align="left"><b>{{$y4++.'.'}}</b></td>
                                            <td align="left"><b>{{$inventaris->nama_barang}}</b></td>
                                            <td align="left"><b>{{$inventaris->RR}}</b></td>
                                            <td align="left"><b>{{$inventaris->tahun_barang}}</b></td>
                                          </tr>
                                          @endforeach
                                    </table>
                                    </div>
                                  </div>              
                              </div>
                            <div class="modal-footer">
                        </div>
                    </div>
                </div>
              </div> --}}

</div>
</body>
@endsection