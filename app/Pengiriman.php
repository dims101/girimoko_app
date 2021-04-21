<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengirimans';
    protected $fillable = [
        'username', 'tanggal_terima','waktu_terima', 'penerima','foto_awb','no_kendaraan','target_aktual'
    ];
}
