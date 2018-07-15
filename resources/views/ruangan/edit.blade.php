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
                          <b>Edit Profil Pengguna</b><br><b><h4> SIM-SARPRAS</h4></b>
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
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                    {!! Form::model($ruangan, ['route' => ['ruangan.update', $ruangan], 'method'=>'patch', 'files' => true]) !!}
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                  <div class="form-group @if($errors->has('unit')) has-error @endif">
                        <label for="unit-field">Unit</label>
                        <input type="text" id="unit-field" name="unit" class="form-control" value="{{ old("unit",$ruangan->unit) }}" required/>
                       @if($errors->has("unit"))
                        <span class="help-block">{{ $errors->first("unit") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: LPPM</p>
                    <div class="form-group @if($errors->has('bagian')) has-error @endif">
                        <label for="bagian-field">Bagian</label>
                        <input type="text" id="bagian-field" name="bagian" class="form-control" value="{{ old("bagian",$ruangan->bagian) }}" required/>
                       @if($errors->has("bagian"))
                        <span class="help-block">{{ $errors->first("bagian") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: PUSAT STUDI BIOFARMAKA</p>
                    <div class="form-group @if($errors->has('gedung')) has-error @endif">
                        <label for="gedung-field">Gedung</label>
                        <input type="text" id="gedung-field" name="gedung" class="form-control" value="{{ old("gedung",$ruangan->gedung) }}" required/>
                       @if($errors->has("gedung"))
                        <span class="help-block">{{ $errors->first("gedung") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: PSB TAMAN KENCANA</p>
                    <div class="form-group @if($errors->has('nama_ruang')) has-error @endif">
                        <label for="nama_ruang-field">Nama ruang</label>
                        <input type="text" id="nama_ruang-field" name="nama_ruang" class="form-control" value="{{ old("nama_ruang",$ruangan->nama_ruang) }}" required/>
                       @if($errors->has("nama_ruang"))
                        <span class="help-block">{{ $errors->first("nama_ruang") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: RUANG KEPALA PUSAT</p>   
                    <div class="form-group @if($errors->has('kode_ruang')) has-error @endif">
                        <label for="kode_ruang-field">Kode ruang</label>
                        <input type="text" id="kode_ruang-field" name="kode_ruang" class="form-control" value="{{ old("kode_ruang",$ruangan->kode_ruang) }}" required/>
                       @if($errors->has("kode_ruang"))
                        <span class="help-block">{{ $errors->first("kode_ruang") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: RKP</p>  
                    <div class="form-group @if($errors->has('wing')) has-error @endif">
                        <label for="wing-field">Wing</label>
                        <input type="text" id="wing-field" name="wing" class="form-control" value="{{ old("wing",$ruangan->wing) }}" />
                       @if($errors->has("wing"))
                        <span class="help-block">{{ $errors->first("wing") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: 1</p>     
                    <div class="form-group @if($errors->has('level')) has-error @endif">
                        <label for="level-field">Level</label>
                        <input type="number" id="level-field" name="level" class="form-control" value="{{ old("level",$ruangan->level) }}" />
                       @if($errors->has("level"))
                        <span class="help-block">{{ $errors->first("level") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: 2</p>   
                </div>
                <div class="col-md-6">   
                    <div class="form-group @if($errors->has('kapasitas')) has-error @endif">
                        <label for="kapasitas-field">Kapasitas</label>
                        <input type="number" min="0" id="kapasitas-field" name="kapasitas" class="form-control" value="{{ old("kapasitas",$ruangan->kapasitas) }}" required/>
                       @if($errors->has("kapasitas"))
                        <span class="help-block">{{ $errors->first("kapasitas") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: 20</p>      
                    <div class="form-group @if($errors->has('panjang')) has-error @endif">
                        <label for="panjang-field">Panjang</label>
                        <input type="number" step="0.01" min="0" id="panjang" name="panjang" class="form-control" value="{{ old("panjang",$ruangan->panjang) }}" required/>
                       @if($errors->has("panjang"))
                        <span class="help-block">{{ $errors->first("panjang") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: 2.3</p>   
                    <div class="form-group @if($errors->has('lebar')) has-error @endif">
                        <label for="lebar-field">Lebar</label>
                        <input type="number" step="0.01" min="0" id="lebar" name="lebar" class="form-control" value="{{ old("lebar",$ruangan->lebar) }}" required/>
                       @if($errors->has("lebar"))
                        <span class="help-block">{{ $errors->first("lebar") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: 2.3</p>   
                    <div class="form-group @if($errors->has('luas')) has-error @endif">
                        <label for="luas-field">Luas</label>
                        <input type="number" step="0.01" min="0" id="luas" name="luas" class="form-control" value="{{ old("luas",$ruangan->luas) }}" readonly/>
                       @if($errors->has("luas"))
                        <span class="help-block">{{ $errors->first("luas") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: 2.3</p> 
                    <div class="form-group @if($errors->has('lokasi')) has-error @endif">
                        <label for="lokasi-field">Lokasi</label>
                        <input type="text" id="lokasi-field" name="lokasi" class="form-control" value="{{ old("lokasi",$ruangan->lokasi) }}" required/>
                       @if($errors->has("lokasi"))
                        <span class="help-block">{{ $errors->first("lokasi") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: TAMAN KENCANA</p>
                    <div class="form-group @if($errors->has('peminjaman')) has-error @endif">
                       <label for="peminjaman-field">Peminjaman</label>
                      <select class="form-control" name="peminjaman" value="">
                        <option value="1" @if($ruangan->status_peminjaman == '1') selected="true" @endif>Dapat Dipinjam</option>
                        <option value="0" @if($ruangan->status_peminjaman == '0') selected="true" @endif>Tidak Dapat Dipinjam</option>
                      </select>
                       @if($errors->has("peminjaman"))
                        <span class="help-block">{{ $errors->first("peminjaman") }}</span>
                       @endif
                    </div> 
                    <p class="help-block">Contoh: Dapat Dipinjam atau Tidak Dapat</p> 
                    <div class="form-group @if($errors->has('keterangan')) has-error @endif">
                        <label for="keterangan-field">Keterangan</label>
                        <textarea type="text" id="keterangan-field" name="keterangan" class="form-control" value="{{ old("keterangan",$ruangan->keterangan) }}" required/>{{ $ruangan->keterangan }}</textarea>
                       @if($errors->has("keterangan"))
                        <span class="help-block">{{ $errors->first("keterangan") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: RUANG KANTOR ADMINISTRASI</p>  
                    <div class="form-group @if($errors->has('image')) has-error @endif">
                       <label>Input Gambar <strong style="color:red">*optional</strong></label>
                       <input type="file" name="image" accept="image/*"  onchange="tampilkanPreview(this,'preview')" value="{{ $ruangan->gambar }}"/>
                       @if($errors->has("image"))
                        <span class="help-block">{{ $errors->first("image") }}</span>
                       @endif
                    </div>
                    @if($ruangan->gambar !=null)
                    <img src="{{asset('imageRuangan/' .$ruangan->gambar) }}" id="preview" width="220px" />
                    @else
                        <img class="img-rounded img-responsive" src="{{asset('image/noimage.png') }}" id="preview" width="220px">
                    @endif                          
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                        <a class="btn btn-link pull-left" href="{{ route('ruangan.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                    {!! Form::close() !!}
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
