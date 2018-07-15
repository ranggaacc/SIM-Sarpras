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
                          <b>Upload File CSV Kode Barang</b><br><b><h4> SIM-SARPRAS</h4></b>
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
                    {!! Form::open(['route' => 'kodebarang.store', 'files' => true]) !!}
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        <div class="form-group">
                            <label>Input File CSV</label>
                            <input type="file" name="file" value=""/>
                        </div>
                        <img id="preview" width="220px"/>
                        <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">
                                    Upload
                                </button>
                                <a class="btn btn-link pull-left" href="{{ route('kodebarang.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
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

{{-- <script type="text/javascript">
    var path = "{{ route('autocomplete') }}";
    $('input.typeahead').typeahead({
        source:  function (query, process) {
            return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        }
    });
</script> --}}
<script type="text/javascript">

      $('.itemName').select2({
        placeholder: 'Select an item',
        ajax: {
          url: "{{ route('autocomplete2') }}",
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.code,
                        id: item.code
                    }
                })
            };
          },
          cache: true
        }
      });

</script>
</body>

@endsection
