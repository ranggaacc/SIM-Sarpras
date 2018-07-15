@extends('layouts/master')
@section('title','Input Data Sarana & Prasarana')
@section('content')
<link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet" />
<script src="{{asset('plugins/select2/jquery.min.js')}}"></script>
<script src="{{asset('plugins/select2/select2.min.js')}}"></script>
<body>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <br><br>
                          @if($unit->nama=='UIH')
                          <b>Input Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Informasi & Humas)</h4></b>
                          @elseif($unit->nama=='UKBB')
                          <b>Input Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Konservasi Budidaya Biofarmaka)</h4></b>
                          @elseif($unit->nama=='UKHP')
                          <b>Input Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Kandang Hewan Percobaan)</h4></b>
                          @elseif($unit->nama=='UPPW')
                          <b>Input Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Unit Pilot Plant & Workshop)</h4></b>
                          @elseif($unit->nama=='LPSB')
                          <b>Input Sarana & Prasarana</b><br><b><h4> {{ $unit->nama }} (Laboratorium PSB)</h4></b>
                          @endif
                    </h1>
                    <!-- /Flash Message --> 
                    @include('flash::message')
                </div>
            </div>
            <!-- /.row -->            
            <div class="row" id="jumlah">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">

                    {!! Form::open(['route' => 'inventaris.store', 'files' => true]) !!}
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        <div class="form-group @if($errors->has('kode_barang')) has-error @endif">
                           <label for="kode_barang-field">KODE BARANG</label>
                           <select class="kodeInventaris form-control" name="kode_barang" type="text" required></select>
                           @if($errors->has("kode_barang"))
                            <span class="help-block">{{ $errors->first("kode_barang") }}</span>
                           @endif
                        </div>
                        <p class="help-block">Contoh: 3.05.02.01.003 Kursi Besi</p> 
                        <div class="form-group @if($errors->has('nama_barang')) has-error @endif">
                           <label for="nama_barang-field">NAMA BARANG</label>
                           <input class="form-control" name="nama_barang">
                           @if($errors->has("nama_barang"))
                            <span class="help-block">{{ $errors->first("nama_barang") }}</span>
                           @endif
                        </div>
                        <p class="help-block">Contoh: kursi besi</p>
                        <div class="form-group @if($errors->has('merk_barang')) has-error @endif">
                           <label for="merk_barang-field">MERK BARANG</label>
                           <input class="form-control" name="merk_barang">
                           @if($errors->has("merk_barang"))
                            <span class="help-block">{{ $errors->first("merk_barang") }}</span>
                           @endif
                        </div>
                        <p class="help-block">Contoh: Panasonic</p>
                        <div class="form-group @if($errors->has('tahun_barang')) has-error @endif">
                           <label for="tahun_barang-field">TAHUN PEMBUATAN/PEMBELIAN</label>
                           <input type="datetime" id="tahun_barang" maxlength="20" name="tahun_barang" class="timepicker form-control" required/>
                           @if($errors->has("tahun_barang"))
                            <span class="help-block">{{ $errors->first("tahun_barang") }}</span>
                           @endif
                        </div>

                        <p class="help-block">Contoh: 2004</p>
                        <div class="form-group @if($errors->has('harga_satuan')) has-error @endif">
                           <label for="harga_satuan-field">HARGA SATUAN(Rp.)</label>
                           <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" min="0">
                           @if($errors->has("harga_satuan"))
                            <span class="help-block">{{ $errors->first("harga_satuan") }}</span>
                           @endif
                        </div>
                        <p class="help-block">Contoh: 40000</p>
                        <div class="form-group @if($errors->has('jumlah_barang')) has-error @endif">
                           <label for="jumlah_barang-field">JUMLAH BARANG</label>
                           <input type="number" class="form-control" required="true" id="jumlah_barang" name="jumlah_barang" min="0">
                           @if($errors->has("jumlah_barang"))
                            <span class="help-block">{{ $errors->first("jumlah_barang") }}</span>
                           @endif
                        </div>
                        <p class="help-block">Contoh: 4</p>
                        <div class="form-group @if($errors->has('satuan')) has-error @endif">
                           <label for="satuan-field">SATUAN</label>
                          <select class="form-control" name="satuan" required>
                            <option value="buah">BUAH</option>
                            <option value="set">SET</option>
                          </select>
                           @if($errors->has("satuan"))
                            <span class="help-block">{{ $errors->first("satuan") }}</span>
                           @endif
                        </div>
                        <p class="help-block">Contoh: buah atau set</p>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group @if($errors->has('jumlah_harga')) has-error @endif">
                           <label for="jumlah_harga-field">JUMLAH HARGA(Rp.)</label>
                           <input type="number" class="jumlah_harga form-control" required="true" id="jumlah_harga" name="jumlah_harga" min="0" readonly>
                           @if($errors->has("jumlah_harga"))
                            <span class="help-block">{{ $errors->first("jumlah_harga") }}</span>
                           @endif
                        </div>
                        <p class="help-block">Contoh: 4000000</p>
                        <div class="form-group @if($errors->has('sumber_dana')) has-error @endif">
                           <label for="sumber_dana-field">SUMBER DANA</label>
                           <input type="text" class="form-control" id="sumber_dana" name="sumber_dana">
                           @if($errors->has("sumber_dana"))
                            <span class="help-block">{{ $errors->first("sumber_dana") }}</span>
                           @endif
                        </div>
                        <p class="help-block">Contoh: DM</p>
                        <label>KONDISI BARANG</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group @if($errors->has('b')) has-error @endif">
                                   <label for="b-field">B</label>
                                   <input type="number" class="form-control" required="true" id="b" name="b" value="0" min="0">
                                   @if($errors->has("b"))
                                    <span class="help-block">{{ $errors->first("b") }}</span>
                                   @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group @if($errors->has('rr')) has-error @endif">
                                   <label for="rr-field">RR</label>
                                   <input type="number" class="form-control" required="true" id="rr" name="rr" value="0" min="0">
                                   @if($errors->has("rr"))
                                    <span class="help-block">{{ $errors->first("rr") }}</span>
                                   @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group @if($errors->has('rb')) has-error @endif">
                                   <label for="rb-field">RB</label>
                                   <input type="number" class="form-control" required="true" id="rb" name="rb" value="0" min="0">
                                   @if($errors->has("rb"))
                                    <span class="help-block">{{ $errors->first("rb") }}</span>
                                   @endif
                                </div>
                            </div>
                        </div>
                        <p class="help-block">B : BARU, RR : RUSAK RINGAN, RB : RUSAK BERAT</p>
                        <p class="help-block">isi 0 jika tidak ada</p>
                        <div class="form-group @if($errors->has('ket')) has-error @endif">
                           <label for="keterangan-field">keterangan</label>
                           <textarea id="keterangan" class="form-control" name="keterangan"></textarea>
                           @if($errors->has("keterangan"))
                            <span class="help-block">{{ $errors->first("keterangan") }}</span>
                           @endif
                        </div>
                        <div class="form-group @if($errors->has('lokasi')) has-error @endif">
                           <label for="lokasi-field">LOKASI</label>
                            <select name="lokasi" id="lokasi" class="form-control" required>
                                @foreach($lokasi as $key)
                                    <option value="{{ $key->kode_ruang }}">{{ $key->nama_ruang }} - kode ({{ $key->kode_ruang }})</option>
                                @endforeach
                            </select>
                           @if($errors->has("lokasi"))
                            <span class="help-block">{{ $errors->first("lokasi") }}</span>
                           @endif
                        </div>
                        <div class="form-group @if($errors->has('image')) has-error @endif">
                           <label>Input Gambar <strong style="color:red">*optional</strong></label>
                           <input type="file" name="image" accept="image/*"  onchange="tampilkanPreview(this,'preview')" value=""/>
                           @if($errors->has("image"))
                            <span class="help-block">{{ $errors->first("image") }}</span>
                           @endif
                        </div>
                        <img id="preview" width="220px"/>
                        
                        <input type="hidden" name="roles_id" value="{{Auth::user()->roles}}" >
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                            <a class="btn btn-link pull-left" href="{{ route('user.index') }}"><i class="glyphicon glyphicon-backward"></i>  Kembali</a>
                        </div>
                    {!! Form::close() !!}
                  </div>
              </div>
            </div>
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
<script>
        $(document).ready(function(){
            $('#lokasi').select2({
                placeholder: "pilih lokasi atau ruangan",
                allowClear: true
            });
        });
</script>
<script type="text/javascript">

      $('.kodeInventaris').select2({
        placeholder: 'Select an item',
        ajax: {
          url: "{{ route('autocomplete2') }}",
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {

                    
                    return {
                        text: item.kode_barang+' - '+item.nama_barang+' - '+item.id,
                        id: item.id
                    }
                })
            };
          },
          cache: true
        }
      });
</script>
{{-- <script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1');
    document.getElementById("tanggal-field").valueAsDate = new Date();
    
  });
</script> --}}
</body>
@endsection
