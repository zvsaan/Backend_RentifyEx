<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $returnType = UserModel::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'email',
        'username',
        'password',
        'konfirmasi',
        'photo'
    ];
}