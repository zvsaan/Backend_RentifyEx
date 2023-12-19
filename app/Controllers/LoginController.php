<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Models\AdminModel;

class LoginController extends BaseController
{
    use ResponseTrait;

    protected $format = 'json';

    public function user()
    {
        $userModel = new UserModel();

        $data = [
            'username' => $this->request->getVar('username'),
            'password' => $this->request->getVar('password'),
        ];

        $user = $userModel->where('username', $data['username'])->first();

        if (!$user || $data['password'] != $user->password) {
            // return $this->failUnauthorized('Login Failed, Invalid username or password');
            return $this->respond  ([
                'code' => 200,
                'status'=> 'failed',
                'messages' => 'Akun tidak terdaftar, silahkan buat akun',
                'values' => []
            ]);
        }
        
        return $this->respond([
            'code' => 200,
            'status'=> 'success',
            'message' => 'Login successful',
            'values' => [$user]
        ]);
        
    }
}