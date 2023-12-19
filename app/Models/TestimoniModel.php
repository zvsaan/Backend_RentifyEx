<?php

namespace App\Models;

use CodeIgniter\Model;

class TestimoniModel extends Model
{
    protected $table = 'testimoni';
    protected $primaryKey = 'id';
    protected $returnType = TestimoniModel::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nama',
        'who',
        'deskripsi'
    ];
}