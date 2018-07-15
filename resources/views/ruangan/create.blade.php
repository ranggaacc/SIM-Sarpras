@extends('layouts/master')
@section('title','Input Data Ruangan')
@section('content')
<link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet"/>
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
                          <b>Input Ruangan Baru</b><br><b><h4> SIM-SARPRAS</h4></b>
                    </h1>
                    @include('flash::message')
                </div>
            </div>
            <!-- /.row -->            
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                    {!! Form::open(['route' => 'ruangan.store', 'files' => true]) !!}
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

                    <div class="form-group @if($errors->has('unit')) has-error @endif">
                        <label for="unit-field">Unit</label>
                        <input type="text" id="unit-field" name="unit" class="form-control" value="{{ old("unit") }}" required/>
                       @if($errors->has("unit"))
                        <span class="help-block">{{ $errors->first("unit") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: LPPM</p>
                    <div class="form-group @if($errors->has('bagian')) has-error @endif">
                        <label for="bagian-field">Bagian</label>
                        <input type="text" id="bagian-field" name="bagian" class="form-control" value="{{ old("bagian") }}" required/>
                       @if($errors->has("bagian"))
                        <span class="help-block">{{ $errors->first("bagian") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: PUSAT STUDI BIOFARMAKA</p>
                    <div class="form-group @if($errors->has('gedung')) has-error @endif">
                        <label for="gedung-field">Gedung</label>
                        <input type="text" id="gedung-field" name="gedung" class="form-control" value="{{ old("gedung") }}" required/>
                       @if($errors->has("gedung"))
                        <span class="help-block">{{ $errors->first("gedung") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: PSB TAMAN KENCANA</p>
                    <div class="form-group @if($errors->has('nama_ruang')) has-error @endif">
                        <label for="nama_ruang-field">Nama ruang</label>
                        <input type="text" id="nama_ruang-field" name="nama_ruang" class="form-control" value="{{ old("nama_ruang") }}" required/>
                       @if($errors->has("nama_ruang"))
                        <span class="help-block">{{ $errors->first("nama_ruang") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: RUANG KEPALA PUSAT</p>   
                    <div class="form-group @if($errors->has('kode_ruang')) has-error @endif">
                        <label for="kode_ruang-field">Kode ruang</label>
                        <input type="text" id="kode_ruang-field" name="kode_ruang" class="form-control" value="{{ old("kode_ruang") }}" required/>
                       @if($errors->has("kode_ruang"))
                        <span class="help-block">{{ $errors->first("kode_ruang") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: RKP</p>  
                    <div class="form-group @if($errors->has('wing')) has-error @endif">
                        <label for="wing-field">Wing</label>
                        <input type="text" id="wing-field" name="wing" class="form-control" value="{{ old("wing") }}" />
                       @if($errors->has("wing"))
                        <span class="help-block">{{ $errors->first("wing") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: 1</p>     
                    <div class="form-group @if($errors->has('level')) has-error @endif">
                        <label for="level-field">Level</label>
                        <input type="number" id="level-field" name="level" class="form-control" value="{{ old("level") }}" />
                       @if($errors->has("level"))
                        <span class="help-block">{{ $errors->first("level") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: 2</p>   
                </div>
                <div class="col-md-6">   
                    <div class="form-group @if($errors->has('kapasitas')) has-error @endif">
                        <label for="kapasitas-field">Kapasitas</label>
                        <input type="number" min="0" id="kapasitas-field" name="kapasitas" class="form-control" value="{{ old("kapasitas") }}" required/>
                       @if($errors->has("kapasitas"))
                        <span class="help-block">{{ $errors->first("kapasitas") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: 20</p>      
                    <div class="form-group @if($errors->has('panjang')) has-error @endif">
                        <label for="panjang-field">Panjang</label>
                        <input type="number" step="0.01" min="0" id="panjang" name="panjang" class="form-control" value="{{ old("panjang") }}" required/>
                       @if($errors->has("panjang"))
                        <span class="help-block">{{ $errors->first("panjang") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: 2.3</p>   
                    <div class="form-group @if($errors->has('lebar')) has-error @endif">
                        <label for="lebar-field">Lebar</label>
                        <input type="number" step="0.01" min="0" id="lebar" name="lebar" class="form-control" value="{{ old("lebar") }}" required/>
                       @if($errors->has("lebar"))
                        <span class="help-block">{{ $errors->first("lebar") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: 2.3</p>   
                    <div class="form-group @if($errors->has('luas')) has-error @endif">
                        <label for="luas-field">Luas</label>
                        <input type="number" step="0.01" min="0" id="luas" name="luas" class="form-control" value="{{ old("luas") }}" readonly/>
                       @if($errors->has("luas"))
                        <span class="help-block">{{ $errors->first("luas") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: 2.3</p> 
                    <div class="form-group @if($errors->has('lokasi')) has-error @endif">
                        <label for="lokasi-field">Lokasi</label>
                        <input type="text" id="lokasi-field" name="lokasi" class="form-control" value="{{ old("lokasi") }}" required/>
                       @if($errors->has("lokasi"))
                        <span class="help-block">{{ $errors->first("lokasi") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: TAMAN KENCANA</p>
                    <div class="form-group @if($errors->has('peminjaman')) has-error @endif">
                       <label for="peminjaman-field">Peminjaman</label>
                      <select class="form-control" name="peminjaman" required>
                        <option value="buah">Dapat Dipinjam</option>
                        <option value="set">Tidak Dapat Dipinjam</option>
                      </select>
                       @if($errors->has("peminjaman"))
                        <span class="help-block">{{ $errors->first("peminjaman") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: Dapat Dipinjam atau Tidak Dapat</p> 
                    <div class="form-group @if($errors->has('keterangan')) has-error @endif">
                        <label for="keterangan-field">Keterangan</label>
                        <textarea type="text" id="keterangan-field" name="keterangan" class="form-control" value="{{ old("keterangan") }}" required/></textarea>
                       @if($errors->has("keterangan"))
                        <span class="help-block">{{ $errors->first("keterangan") }}</span>
                       @endif
                    </div>
                    <p class="help-block">Contoh: RUANG KANTOR ADMINISTRASI</p>  
                    <div class="form-group @if($errors->has('image')) has-error @endif">
                       <label>Input Gambar <strong style="color:red">*optional</strong></label>
                       <input type="file" name="image" accept="image/*"  onchange="tampilkanPreview(this,'preview')" value=""/>
                       @if($errors->has("image"))
                        <span class="help-block">{{ $errors->first("image") }}</span>
                       @endif
                    </div>
                    <img id="preview" width="220px"/>                            
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            Tambah
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

<script>
        $(document).ready(function(){
            $('#users').select2({
                placeholder: "Pilih pegawai",
                allowClear: true
            });
        });
</script>
<script>
        $(document).ready(function(){
            $('#roles').select2({
                placeholder: "Pilih pegawai",
                allowClear: true
            });
        });
</script>
</body>

@endsection
