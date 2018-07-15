@component('mail::message')
<center><h1>Pengajuan Pengadaan Sarana dan Prasarana</h1></center>

<div class="row">
    <div class="col-md-12">
        <div class="thumbnail"> 
          <div class="caption">
            <p style="font-family:roboto; color:grey;">Nama Pegawai&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $nama }}</p>
            <p style="font-family:roboto; color:grey;">Tanggal Pengajuan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $tanggal_pengajuan }}</p>
            <p style="font-family:roboto; color:grey;">Keterangan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $keterangan }}</p>

          </div>
        </div>

    </div>
</div>

<div class="panel-failed center">
    <center><h3 style="color: #a94442">Pengajuan Ditolak</h3></center>
</div>

<br>
<br>
<b>Terimakasih,</b>
<br>
@endcomponent
