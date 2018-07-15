@component('mail::message')
<center><h1>Pengajuan Peminjaman Ruangan Biofarmaka</h1></center>

Dear Administrator,
Terdapat pengajuan peminjaman ruangan yang menunggu persetujuan anda

<b>Silahkan login ke SIM-Sarpras
Terimakasih, 
@component('mail::button', ['url' => $url])
Login
@endcomponent

{{-- @component('mail::button', ['invoice' => $invoice])
View Invoice
@endcomponent --}}


</b>
@endcomponent