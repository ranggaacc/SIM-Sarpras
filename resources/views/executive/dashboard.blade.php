@extends('layouts/master')
@section('title','Sarana Prasarana Biofarmaka')
@section('content')
<body>

        <div id="page-wrapper">
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <br><br>
                            <b>Sarana & Prasarana</b><br><b><h4>PS Biofarmaka IPB</h4></b>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart"></i> Chart Inventaris Tiap Unit

                            </div>
                            <div class="panel-body">
                                {!! Charts::assets() !!}
                                <center>
                                    {!! $chartexecutive->render() !!}
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart"></i> Chart Kondisi Inventaris

                            </div>
                            <div class="panel-body">
                                {!! Charts::assets() !!}
                                <center>
                                    {!! $chartexecutive2->render() !!}
                                </center>
                            </div>
                        </div>
                    </div>
                </div>                                
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
        <!-- /#page-wrapper -->

    </div>



</body>
@endsection