<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class TestimoniController extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $testimoniModel = new \App\Models\TestimoniModel();
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
            'nama' => $this->request->getVar('nama'),
            'who' => $this->request->getVar('who'),
            'deskripsi' => $this->request->getVar('deskripsi'),
        ];
        $testimoniModel = new \App\Models\TestimoniModel();
        $testimoniModel->save($data);
        $response = [
            'status' => 200,
            'messages' => 'Data berhasil ditambahkan',
            'data' => $data,
        ];
        return $this->respond($response);
    }
}