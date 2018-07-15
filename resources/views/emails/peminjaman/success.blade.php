@component('mail::message')
<center><h1>Pengajuan Peminjaman Ruangan Biofarmaka</h1></center>

<div class="row">
    <div class="col-md-12">
        <div class="thumbnail"> 
          <div class="caption">
            <p style="font-family:roboto; color:grey;">Nama Peminjam&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $nama }}</p>
            <p style="font-family:roboto; color:grey;">Tanggal Pengajuan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $tanggal_pengajuan }}</p>
            <p style="font-family:roboto; color:grey;">Keterangan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $keterangan }}</p>

          </div>
        </div>

    </div>
</div>


<div class="panel-success center">
    <center><h3 style="color: #3c763d">Pengajuan Telah Disetujui</h3></center>
</div>

<br>
<b>Silahkan datang ke <i>front-office</i> Biofarmaka
<br>
Terimakasih,
<br>
</b>
@endcomponent
