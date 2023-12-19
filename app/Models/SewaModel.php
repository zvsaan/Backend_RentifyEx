<?php

namespace App\Models;

use CodeIgniter\Model;

class SewaModel extends Model
{
    protected $table = 'trx_sewa';
    protected $primaryKey = 'id_pembayaran';
    protected $returnType = SewaModel::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_product',
        'id_user',
        'hari',
        'tanggal',
        'harga',
        'total'
    ];
}