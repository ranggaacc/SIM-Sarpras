<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class PengadaanCekEdit extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages() {

        $messages = [


        ];

        $messages["keterangan.required"]= "keterangan barang pada field harus diisi.";
        $messages["keterangan.max"]= "keterangan pada field max 30 karakter.";
        if($this->get('sub_total_edit')!=null){
            foreach ($this->get('nama_barang_edit') as $key => $val) {
                $key2=$key+1;
                $messages["nama_barang_edit.$key.required"] = "nama barang barang baris ke-$key2 pada field harus diisi.";
                $messages["nama_barang_edit.$key.max"] = "nama barang barang baris ke-$key2 tidak boleh lebih dari :max karakter.";
            }
            foreach ($this->get('jenis_edit') as $key => $val) {
                $key2=$key+1;
                $messages["jenis_edit.$key.required"] = "jenis barang baris ke-$key2 pada field harus diisi.";
            }
            foreach ($this->get('merk_edit') as $key => $val) {
                $key2=$key+1;
                $messages["merk_edit.$key.required"] = "merk barang baris ke-$key2 pada field harus diisi.";
            }
            foreach ($this->get('jumlah_edit') as $key => $val) {
                $key2=$key+1;
                $messages["jumlah_edit.$key.required"] = "jumlah barang baris ke-$key2 pada field harus diisi.";
                $messages["jumlah_edit.$key.numeric"] = "jumlah barang baris ke-$key2 pada field harus angka.";
                $messages["jumlah_edit.$key.max"] = "jumlah barang baris ke-$key2 tidak boleh lebih dari 4 digit.";
            }
            foreach ($this->get('perkiraan_edit') as $key => $val) {
                $key2=$key+1;
                $messages["perkiraan_edit.$key.required"] = "perkiraan barang baris ke-$key2 pada field harus diisi.";
                $messages["perkiraan_edit.$key.numeric"] = "jumlah barang baris ke-$key2 pada field harus angka.";
                $messages["perkiraan_edit.$key.max"] = "perkiraan harga barang baris ke-$key2 tidak boleh lebih dari 10 digit.";
            }
            foreach ($this->get('sub_total_edit') as $key => $val) {
                $key2=$key+1;
                $messages["sub_total_edit.$key.required"] = "sub_total barang baris ke-$key2 pada field harus diisi.";
                $messages["sub_total_edit.$key.numeric"] = "sub_total barang baris ke-$key2 pada field harus angka.";
                $messages["sub_total_edit.$key.max"] = "sub_total barang baris ke-$key2 tidak boleh lebih dari 10 digit.";
            }
        }
        $count=count($this->get('sub_total_edit'));

        if($this->get('nama_barang')!=null){
            foreach ($this->get('nama_barang') as $key => $val) {
                $key2=$key+1+$count;
                $messages["nama_barang.$key.required"] = "nama barang barang baris ke-$key2 pada field harus diisi.";
                $messages["nama_barang.$key.max"] = "nama barang barang baris ke-$key2 tidak boleh lebih dari :max karakter.";
            }
            foreach ($this->get('jenis') as $key => $val) {
                $key2=$key+1+$count;
                $messages["jenis.$key.required"] = "jenis barang baris ke-$key2 pada field harus diisi.";
            }
            foreach ($this->get('merk') as $key => $val) {
                $key2=$key+1+$count;
                $messages["merk.$key.required"] = "merk barang baris ke-$key2 pada field harus diisi.";
            }
            foreach ($this->get('jumlah') as $key => $val) {
                $key2=$key+1+$count;
                $messages["jumlah.$key.required"] = "jumlah barang baris ke-$key2 pada field harus diisi.";
                $messages["jumlah.$key.numeric"] = "jumlah barang baris ke-$key2 pada field harus angka.";
                $messages["jumlah.$key.max"] = "jumlah barang baris ke-$key2 tidak boleh lebih dari 4 digit.";
                
            }
            foreach ($this->get('perkiraan') as $key => $val) {
                $key2=$key+1+$count;
                $messages["perkiraan.$key.required"] = "perkiraan barang baris ke-$key2 pada field harus diisi.";
                $messages["perkiraan.$key.numeric"] = "perkiraan barang baris ke-$key2 pada field harus angka.";
                $messages["perkiraan.$key.max"] = "perkiraan barang baris ke-$key2 tidak boleh lebih dari 10 digit.";
            }
            foreach ($this->get('sub_total') as $key => $val) {
                $key2=$key+1+$count;
                $messages["sub_total.$key.required"] = "sub_total barang baris ke-$key2 pada field harus diisi.";
                $messages["sub_total.$key.numeric"] = "sub_total barang baris ke-$key2 pada field harus angka.";
                $messages["sub_total.$key.max"] = "sub_total barang baris ke-$key2 tidak boleh lebih dari 10 digit.";
            }
        }
        return $messages;

    }
  public function rules(){

    $rules = [

                'keterangan' => 'required|max:30',
                'nama_barang_edit.*' => 'required|max:40',
                'jenis_edit*' => 'max:20',
                'merk_edit*' => 'max:20',
                'jumlah_edit*' => 'required|min:1|max:4',
                'perkiraan_edit*' => 'required|min:1|max:10',
                'sub_total_edit*' => 'required|min:1|max:10',
                'nama_barang.*' => 'required|max:40',
                'jenis.*' => 'max:20',
                'merk.*' => 'max:20',
                'jumlah.*' => 'required|min:1|max:4',
                'perkiraan.*' => 'required|min:1|max:10',
                'sub_total.*' => 'required|min:1|max:10',
                'tanggal_pengajuan'=> 'required|date',
 
    ];

    return $rules;

  }
}
