@component('mail::message')
<center><h1>Pengajuan Pengadaan Barang</h1></center>

Dear Administrator,
Terdapat pengajuan pengadaan barang yang menunggu persetujuan anda

<b>Silahkan login ke SIM-Sarpras 
Terimakasih,
@component('mail::button', ['url' => $url])
Login
@endcomponent

</b>
@endcomponent