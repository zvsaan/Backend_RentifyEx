<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'id_product';
    protected $returnType = ProductModel::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'title',
        'city',
        'category',
        'price',
        'desc',
        'photo'
    ];
}