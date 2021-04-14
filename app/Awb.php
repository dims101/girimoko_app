<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Awb extends Model
{
    protected $fillable = [
        'no_awb', 'no_ds','kode_dealer', 'tanggal_ds','status','keterangan','id_pengiriman'
    ];
}
