<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class SewaController extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $sewaModel = new \App\Models\SewaModel();
        $data = $sewaModel->findAll();

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
            'id_product' => $this->request->getVar('id_product'),
            'id_user' => $this->request->getVar('id_user'),
            'hari' => $this->request->getVar('hari'),
            'tanggal' => $this->request->getVar('tanggal'),
            'harga' => $this->request->getVar('harga'),
            'total' => $this->request->getVar('total'),
        ];

        $productModel = new \App\Models\SewaModel();
        $productModel->save($data);

        $response = [
            'kode' => 200,
            'status' => 'success',
            'messages' => 'Data berhasil ditambahkan',
            'data' => $data,
        ];

        return $this->respond($response);
    }
}
