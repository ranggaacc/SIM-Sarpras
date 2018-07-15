@extends('layouts/master')
@section('title','Ubah Data Sarana & Prasarana')
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
                      <br>
                      <br>
                      <b>Sarana & Prasarana</b><br><b><h4> Sekretariat</h4></b>
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
            <div class="row" id="jumlah">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    {!! Form::model($inventaris, ['route' => ['sekretariat.update', $inventaris->id], 'method'=>'patch', 'files' => true]) !!}
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        <div class="form-group @if($errors->has('kode_barang')) has-error @endif">
                           <label for="kode_barang-field">KODE BARANG</label>
                           <input class="hidden form-control" name="previous_kode" value="{{$kode_barang->id}}">
                           <br>
                           <select class="itemName form-control" name="kode_barang" type="text" data-placeholder="{{$kode_barang->kode_barang}} {{$kode_barang->nama_barang}}" value="{{$kode_barang->id}}"></select>
                           @if($errors->has("kode_barang"))
                            <span class="help-block">{{ $errors->first("kode_barang") }}</span>
                           @endif
                        </div>
                        <p class="help-block">Contoh: 3.05.02.01.003 <strong>[SPASI]</strong> Kursi Besi</p> 
                        <div class="form-group @if($errors->has('nama_barang')) has-error @endif">
                           <label for="nama_barang-field">NAMA BARANG</label>
                           <input class="form-control" required="true" name="nama_barang" value="{{$inventaris->nama_barang}}">
                           @if($errors->has("nama_barang"))
                            <span class="help-block">{{ $errors->first("nama_barang") }}</span>
                           @endif
                        </div>
                        <p class="help-block">Contoh: Kursi</p>
                        <div class="form-group @if($errors->has('merk_barang')) has-error @endif">
                           <label for="merk_barang-field">MERK BARANG</label>
                           <input class="form-control" name="merk_barang" value="{{$inventaris->merk_barang}}">
                           @if($errors->has("merk_barang"))
                            <span class="help-block">{{ $errors->first("merk_barang") }}</span>
                           @endif
                        </div>
                        <p class="help-block">Contoh: Panasonic</p>
                        <div class="form-group @if($errors->has('tahun_barang')) has-error @endif">
                           <label for="tahun_barang-field">TAHUN PEMBUATAN/PEMBELIAN</label>
                           <input type="datetime" id="tahun_barang" class="form-control" required="true" name="tahun_barang" value="{{$inventaris->tahun_barang}}" min="0">
                           @if($errors->has("tahun_barang"))
                            <span class="help-block">{{ $errors->first("tahun_barang") }}</span>
                           @endif
                        </div>
                        <p class="help-block">Contoh: 2004</p>
                        <div class="form-group @if($errors->has('harga_satuan')) has-error @endif">
                           <label for="harga_satuan-field">HARGA SATUAN(Rp.)</label>
                           <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" value="{{$inventaris->harga_satuan}}" min="0">
                           @if($errors->has("harga_satuan"))
                            <span class="help-block">{{ $errors->first("harga_satuan") }}</span>
                           @endif
                        </div>
                        <p class="help-block">Contoh: 40000</p>
                        <div class="form-group @if($errors->has('jumlah_barang')) has-error @endif">
                           <label for="jumlah_barang-field">JUMLAH BARANG</label>
                           <input type="number" class="form-control" required="true" id="jumlah_barang" name="jumlah_barang" value="{{$inventaris->jumlah_barang}}" min="0">
                           @if($errors->has("jumlah_barang"))
                            <span class="help-block">{{ $errors->first("jumlah_barang") }}</span>
                           @endif
                        </div>
                        <p class="help-block">Contoh: 4</p>
                        <div class="form-group @if($errors->has('satuan')) has-error @endif">
                           <label for="satuan-field">SATUAN</label>
                          <select class="form-control" name="satuan" value="">
                            <option value="buah" @if($inventaris->satuan == 'buah') selected="true" @endif>BUAH</option>
                            <option value="set" @if($inventaris->satuan == 'set') selected="true" @endif>SET</option>
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
                           <input type="number" class="form-control" id="jumlah_harga" name="jumlah_harga" value="{{$inventaris->jumlah_harga}}" min="0" readonly>
                           @if($errors->has("jumlah_harga"))
                            <span class="help-block">{{ $errors->first("jumlah_harga") }}</span>
                           @endif
                        </div>
                        <p class="help-block">Contoh: 4000000</p>
                        <div class="form-group @if($errors->has('sumber_dana')) has-error @endif">
                           <label for="sumber_dana-field">SUMBER DANA</label>
                           <input type="text" class="form-control" id="sumber_dana" name="sumber_dana" value="{{$inventaris->sumber_dana}}">
                           @if($errors->has("sumber_dana"))
                            <span class="help-block">{{ $errors->first("sumber_dana") }}</span>
                           @endif
                        </div>
                        <p class="help-block">Contoh: DM</p>
                        <label>KONDISI BARANG</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group @if($errors->has('b')) has-error @endif">
                                   <label for="B-field">B</label>
                                   <input type="number" class="form-control" required="true" id="b" name="b" value="{{$inventaris->B}}" min="0">
                                   @if($errors->has("b"))
                                    <span class="help-block">{{ $errors->first("b") }}</span>
                                   @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group @if($errors->has('rr')) has-error @endif">
                                   <label for="rr-field">RR</label>
                                   <input type="number" class="form-control" required="true" id="rr" name="rr" value="{{$inventaris->RR}}" min="0">
                                   @if($errors->has("rr"))
                                    <span class="help-block">{{ $errors->first("rr") }}</span>
                                   @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group @if($errors->has('rb')) has-error @endif">
                                   <label for="rb-field">RB</label>
                                   <input type="number" class="form-control" required="true" id="rb" name="rb" value="{{$inventaris->RB}}" min="0">
                                   @if($errors->has("rb"))
                                    <span class="help-block">{{ $errors->first("rb") }}</span>
                                   @endif
                                </div>
                            </div>
                        </div>
                        <p class="help-block">B : BARU, RR : RUSAK RINGAN, RB : RUSAK BERAT</p>
                        <p class="help-block">isi 0 jika tidak ada</p>
                        <div class="form-group @if($errors->has('keterangan')) has-error @endif">
                           <label for="keterangan-field">KETERANGAN</label>
                           <textarea id="keterangan" class="form-control" name="keterangan" value="{{$inventaris->keterangan}}">{{$inventaris->keterangan}}</textarea>
                           @if($errors->has("keterangan"))
                            <span class="help-block">{{ $errors->first("keterangan") }}</span>
                           @endif
                        </div>
                        <div class="form-group @if($errors->has('lokasi')) has-error @endif">
                           <label for="lokasi-field">LOKASI</label>
                            <select name="lokasi" id="lokasi" class="form-control"  data-placeholder="{{ $lokasi_sekarang->nama_ruang }} - kode ({{ $lokasi_sekarang->kode_ruang }})" required>
                                @foreach($lokasi as $key)
                                    <option value="{{ $key->kode_ruang }}" @if($inventaris->lokasi == $key->kode_ruang ) selected="true" @endif>{{ $key->nama_ruang }} - kode ({{ $key->kode_ruang }})</option>
                                @endforeach
                            </select>
                           @if($errors->has("lokasi"))
                            <span class="help-block">{{ $errors->first("lokasi") }}</span>
                           @endif
                        </div>
                        
                            <div class="form-group">
                                <label>Input Gambar <strong style="color:red">*optional</strong></label>
                                <input type="file" name="image" accept="image/*"  onchange="tampilkanPreview(this,'preview')" value="{{$inventaris->gambar}}">
                            </div>
                            @if($inventaris->gambar !=null)
                            <img src="{{asset('imageInventaris/' .$inventaris->gambar) }}" id="preview" width="220px" />
                            @else
                                <img class="img-rounded img-responsive" src="{{asset('image/noimage.png') }}" id="preview" width="220px">
                            @endif
                           {{--  <img id="preview" width="220px"/> --}}   
                        <input type="hidden" name="roles_id" value="{{Auth::user()->roles}}" >
                        <!-- Modal Footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                                <a class="btn btn-link pull-left" href="{{ route('inventaris.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
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
{{-- <script type="text/javascript">ss
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
                        text: item.kode+' - '+item.nama_barang,
                        id: item.id
                    }
                })
            };
          },
          cache: true
        }
      });

</script> --}}

{{-- <script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1');
    document.getElementById("tanggal-field").valueAsDate = new Date();
    
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
</body>
@endsection
