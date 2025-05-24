<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiMasuk extends Model
{
    protected $fillable = [
    'nama_barang',
    'jumlah',
    'tanggal',
    'Atas_Nama',
    'bukti_pembayaran',
];

}
