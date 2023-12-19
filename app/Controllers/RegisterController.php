<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class RegisterController extends ResourceController
{
    protected $format = 'json';

    public function index($id = null)
    {
        $userModel = new \App\Models\UserModel();

        if ($id === null) {
            $data = $userModel->findAll();
        } else {
            $data = $userModel->find($id);
        }

        if (!empty($data)) {
            $response = [
                'status' => 'success',
                'message' => 'Data retrieved successfully',
                'data' => [$data]
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => ($id === null) ? 'No data found' : 'Data with the specified ID not found',
                'data' => []
            ];
        }

        return $this->respond($response);
    }

    public function insert()
    {
        $userModel = new \App\Models\UserModel();
        $data = $userModel->findAll();

        if (!empty($data)) {
            $response = [
                'status' => 'success',
                'message' => 'Data retrieved successfully',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'No data found',
                'data' => []
            ];
        }

        return $this->respond($response);
    }

    public function create()
    {

        $data = [
            'email' => $this->request->getVar('email'),
            'username' => $this->request->getVar('username'),
            'password' => $this->request->getVar('password'),
            'konfirmasi' => $this->request->getVar('konfirmasi'),
        ];

        $userModel = new \App\Models\UserModel();
        $userModel->save($data);

        $response = [
            'status' => 200,
            'messages' => 'Data berhasil ditambahkan',
            'data' => $data,
        ];

        return $this->respond($response);
    }

    // function untuk mengedit data
    public function update($id = null)
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($id);
        if ($user) {
            $data = [
                'email' => $this->request->getVar('email'),
                'username' => $this->request->getVar('username'),
                'password' => $this->request->getVar('password'),
            ];
            $proses = $userModel->update($id, $data);
            if ($proses) {
                $response = [
                    'status' => 200,
                    'messages' => 'Data berhasil diubah',
                    'data' => $data,
                ];
            } else {
                $response = [
                    'status' => 500,
                    'messages' => 'Gagal diubah',
                ];
            }
            return $this->respond($response);
        }
        return $this->failNotFound('Data tidak ditemukan');
    }    

    // function untuk menghapus data
    public function delete($id = null)
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($id);
        if ($user) {
            $proses = $userModel->delete($id);
            if ($proses) {
                $response = [
                    'status' => 200,
                    'messages' => 'Data berhasil dihapus',
                ];
            } else {
                $response = [
                    'status' => 200,
                    'messages' => 'Gagal menghapus data',
                ];
            }
            return $this->respond($response);
        } else {
            return $this->failNotFound('Data tidak ditemukan');
        }
    }
}
