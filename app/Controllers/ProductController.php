<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{
    public function index()
    {
        return view('pages/products/index', [
            'title' => 'Product List',
        ]);
    }
}
