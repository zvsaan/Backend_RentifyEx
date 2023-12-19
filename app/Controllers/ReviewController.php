<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ReviewController extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $testimoniModel = new \App\Models\ReviewModel();
        $data = $testimoniModel->findAll();

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
            'keterangan' => $this->request->getVar('keterangan'),
            'rating' => $this->request->getVar('rating'),
            // 'waktu' => $this->request->getVar('waktu'),
        ];

        $productModel = new \App\Models\ReviewModel();
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
