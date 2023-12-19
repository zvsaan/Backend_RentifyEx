<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'id_reviews';
    protected $returnType = ReviewModel::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_product',
        'id_user',
        'keterangan',
        'rating'
        // 'waktu'
    ];
}