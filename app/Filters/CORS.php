<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CORS implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Requested-Method, Authorization");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PATCH, PUT, DELETE");
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Max-Age: 86400');
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == "OPTIONS") {
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PATCH, PUT, DELETE");
      header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Requested-Method, Authorization");
      header('Access-Control-Max-Age: 86400');
      header('Content-Length: 0');
      header('Content-Type: application/json; charset=UTF-8');
      exit();
    }
  }
  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Terserah
  }
}