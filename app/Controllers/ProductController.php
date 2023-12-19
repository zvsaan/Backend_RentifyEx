<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ProductController extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $productModel = new \App\Models\ProductModel();
        $data = $productModel
        ->select('product.*, reviews.rating, reviews.id_user, reviews.id_reviews, reviews.keterangan, reviews.waktu, user.username')
            ->join('reviews', 'product.id_product = reviews.id_product', 'left')
            ->join('user', 'reviews.id_user = user.id', 'left')
            ->findAll();
    
        // Kelompokkan hasil berdasarkan ID produk
        $groupedResult = [];
        foreach ($data as $row) {
            $productId = $row->id_product; // Ganti dengan kunci yang sesuai, misalnya 'id_product'
        
            if (!isset($groupedResult[$productId])) {
                $groupedResult[$productId] = (object) [
                    'id_product' => $row->id_product,
                    'title' => $row->title, 
                    'city' => $row->city, 
                    'category' => $row->category, 
                    'price' => $row->price, 
                    'desc' => $row->desc, 
                    'photo' => $row->photo,
                    'reviews' => [],
                ];
            }
        
            // Tambahkan data ulasan ke dalam kelompok yang sesuai
            if (!empty($row->id_reviews)) {
                $groupedResult[$productId]->reviews[] = (object) [
                    'id_reviews' => $row->id_reviews,
                    'id_user' => $row->id_user,
                    'username' => $row->username,
                    'keterangan' => $row->keterangan,
                    'rating' => $row->rating,
                    'waktu' => $row->waktu,
                ];
            }
        }
        
    
        $response = [
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => array_values($groupedResult),
        ];
    
        return $this->respond($response);
    }

    public function byId($id)
    {
        $productModel = new \App\Models\ProductModel();
        $data = $productModel
            ->select('product.*, reviews.rating, reviews.id_user, reviews.id_reviews, reviews.keterangan, reviews.waktu, user.username')
            ->join('reviews', 'product.id_product = reviews.id_product', 'left')
            ->join('user', 'reviews.id_user = user.id', 'left')
            ->where('product.id_product', $id)
            ->findAll();

        if (empty($data)) {
            $response = [
                'status' => 'error',
                'message' => 'No data found for the specified product ID',
                'data' => null,
            ];

            return $this->respond($response, 404);
        }

        // Kelompokkan hasil berdasarkan ID produk
        $groupedResult = [];
        foreach ($data as $row) {
            $productId = $row->id_product;

            if (!isset($groupedResult[$productId])) {
                $groupedResult[$productId] = (object) [
                    'id_product' => $row->id_product,
                    'title' => $row->title,
                    'city' => $row->city,
                    'category' => $row->category,
                    'price' => $row->price,
                    'desc' => $row->desc,
                    'photo' => $row->photo,
                    'reviews' => [],
                ];
            }

            // Tambahkan data ulasan ke dalam kelompok yang sesuai
            if (!empty($row->id_reviews)) {
                $groupedResult[$productId]->reviews[] = (object) [
                    'id_reviews' => $row->id_reviews,
                    'id_user' => $row->id_user,
                    'username' => $row->username,
                    'keterangan' => $row->keterangan,
                    'rating' => $row->rating,
                    'waktu' => $row->waktu,
                ];
            }
        }

        $response = [
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => array_values($groupedResult),
        ];

        return $this->respond($response);
    }
    

    public function create()
    {
        $data = [
            'title' => $this->request->getVar('title'),
            'city' => $this->request->getVar('city'),
            'category' => $this->request->getVar('category'),
            'price' => $this->request->getVar('price'),
            'desc' => $this->request->getVar('desc'),
        ];

        $photo = $this->request->getFile('photo');

        if ($photo->isValid() && !$photo->hasMoved()) {
            // Generate a unique name for the file
            $newName = $photo->getRandomName();
            $photo->move(WRITEPATH . 'uploads', $newName);
            $data['photo'] = $newName;
        } else {
            $response = [
                'status' => 500,
                'messages' => 'File upload failed',
            ];
            return $this->respond($response);
        }

        $productModel = new \App\Models\ProductModel();
        $proses = $productModel->save($data);

        if ($proses) {
            $response = [
                'status' => 200,
                'messages' => 'Data berhasil ditambahkan',
                'data' => $data,
            ];
        } else {
            $response = [
                'status' => 500,
                'messages' => 'Gagal menambahkan data',
            ];
        }

        return $this->respond($response);
    }

    // function untuk mengedit data
    public function update($id = null)
    {
        $productModel = new \App\Models\ProductModel();
        $product = $productModel->find($id);

        if ($product) {
            $data = [
                'id' => $id,
                'title' => $this->request->getVar('title'),
                'city' => $this->request->getVar('city'),
                'category' => $this->request->getVar('category'),
                'price' => $this->request->getVar('price'),
                'desc' => $this->request->getVar('desc'),
            ];

            $newPhoto = $this->request->getFile('photo');

            if ($newPhoto->isValid() && !$newPhoto->hasMoved()) {
                // Generate a unique name for the file
                $newName = $newPhoto->getRandomName();
                $newPhoto->move(WRITEPATH . 'uploads', $newName);
                $data['photo'] = $newName;
            } else {
                $response = [
                    'status' => 500,
                    'messages' => 'File upload failed',
                ];
                return $this->respond($response);
            }

            $proses = $productModel->save($data);

            if ($proses) {
                $response = [
                    'status' => 200,
                    'messages' => 'Data berhasil diubah',
                    'data' => $data,
                ];
            } else {
                $response = [
                    'status' => 200,
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
        $productModel = new \App\Models\ProductModel();
        $product = $productModel->find($id);

        if ($product) {
            // Get the filename of the photo
            $photoFilename = $product['photo'];

            // Attempt to delete the product
            $proses = $productModel->delete($id);

            if ($proses) {
                // Delete the associated photo file
                $photoPath = WRITEPATH . 'uploads/' . $photoFilename;
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }

                $response = [
                    'status' => 200,
                    'messages' => 'Data berhasil dihapus',
                ];
            } else {
                $response = [
                    'status' => 500,
                    'messages' => 'Gagal menghapus data',
                ];
            }

            return $this->respond($response);
        }

        return $this->failNotFound('Data tidak ditemukan');
    }
}