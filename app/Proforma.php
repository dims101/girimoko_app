<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    protected $fillable = [
        'no_proforma','koli','tipe','no_awb'
    ];
}
