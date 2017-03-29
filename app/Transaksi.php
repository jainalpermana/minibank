<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    //
     protected $fillable = ['nasabah_id', 'jumlah', 'jenis_transaksi','user_id'];

function nasabah()
{
	return $this->belongsTo('App\Nasabah');
}
}
