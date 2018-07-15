@extends('layouts/master')
@section('title','Input Data Sarana & Prasarana')
@section('content')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<body>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <br><br>
                          <b>Edit Kode Barang</b><br><b><h4> SIM-SARPRAS</h4></b>
                    </h1>
                    @include('flash::message')
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <!-- /.row -->            
            <div class="row">
                <div class="col-lg-6">
                    {!! Form::model($code, ['route' => ['kodebarang.update', $code], 'method'=>'patch', 'files' => true]) !!}
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        
                    <div class="form-group @if($errors->has('code')) has-error @endif">
                       <label for="code-field">Kode Barang</label>
                    <input type="text" id="code-field" name="code" class="form-control" value="{{ $code->code }}"/>
                       @if($errors->has("code"))
                        <span class="help-block">{{ $errors->first("code") }}</span>
                       @endif
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">
                            Save
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- /.row -->

        </div>
            <!-- /.container-fluid -->

    </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
</body>

@endsection
