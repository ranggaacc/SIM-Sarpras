<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class PengadaanCek extends FormRequest
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

        $messages["keterangan.required"]= "keterangan pada field harus diisi.";
        $messages["keterangan.max"]= "keterangan pada field max 30 karakter.";
        if($this->get('sub_total')!=null){

            foreach ($this->get('nama_barang') as $key => $val) {
                $key2=$key+1;
                $messages["nama_barang.$key.required"] = "nama barang barang baris ke-$key2 pada field harus diisi.";
                $messages["nama_barang.$key.max"] = "nama barang barang baris ke-$key2 tidak boleh lebih dari :max karakter.";
            }
            foreach ($this->get('jenis') as $key => $val) {
                $key2=$key+1;
                $messages["jenis.$key.required"] = "jenis barang baris ke-$key2 pada field harus diisi.";
            }
            foreach ($this->get('merk') as $key => $val) {
                $key2=$key+1;
                $messages["merk.$key.required"] = "merk barang baris ke-$key2 pada field harus diisi.";
            }
            foreach ($this->get('jumlah') as $key => $val) {
                $key2=$key+1;
                $messages["jumlah.$key.required"] = "jumlah barang baris ke-$key2 pada field harus diisi.";
                $messages["jumlah.$key.numeric"] = "jumlah barang baris ke-$key2 pada field harus angka.";
                $messages["jumlah.$key.digits"] = "jumlah barang baris ke-$key2 tidak boleh lebih dari 4 digit.";
                $messages["jumlah.$key.min"] = "jumlah barang baris ke-$key2 tidak boleh kurang dari 1.";
            }
            foreach ($this->get('perkiraan') as $key => $val) {
                $key2=$key+1;
                $messages["perkiraan.$key.required"] = "perkiraan barang baris ke-$key2 pada field harus diisi.";
                $messages["perkiraan.$key.numeric"] = "jumlah barang baris ke-$key2 pada field harus angka.";
                $messages["perkiraan.$key.digits"] = "perkiraan barang baris ke-$key2 tidak boleh lebih dari 10 digit.";
                $messages["perkiraan.$key.min"] = "perkiraan barang baris ke-$key2 tidak boleh kurang dari 1.";

            }
            foreach ($this->get('sub_total') as $key => $val) {
                $key2=$key+1;
                $messages["sub_total.$key.required"] = "sub_total barang baris ke-$key2 pada field harus diisi.";
                $messages["sub_total.$key.numeric"] = "jumlah barang baris ke-$key2 pada field harus angka.";
                $messages["sub_total.$key.digits"] = "sub_total barang baris ke-$key2 tidak boleh lebih dari 10 digit.";
                $messages["sub_total.$key.min"] = "sub_total barang baris ke-$key2 tidak boleh kurang dari 1.";
            }
        }
        return $messages;

    }
  public function rules(){

    $rules = [
                'id_pegawai' => 'required',
                'pengaju' => 'required',
                'keterangan' => 'required|max:30',
                'jenis.*' => 'required|max:20',
                'nama_barang.*' => 'required|max:40',
                'merk.*' => 'required|max:20',
                'jumlah.*' => 'required|min:1|max:4',
                'perkiraan.*' => 'required|min:1|max:10',
                'sub_total.*' => 'required|min:1|max:10',
                'tanggal_pengajuan'=> 'required|date',
 
    ];

    return $rules;

  }
}
