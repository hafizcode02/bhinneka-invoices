<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Product;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this->model = model(Product::class);
    }

    // Endpoint return JSON
    public function getProducts(): ResponseInterface
    {
        $start = $this->request->getPost('start');
        $length = $this->request->getPost('length');
        $searchValue = $this->request->getPost('search')['value'];

        // Get total records
        $totalData = $this->model->getTotalProducts();

        // Get filtered data
        $result = $this->model->getPaginatedProducts($start, $length, $searchValue);
        $products = $result['data'];
        $totalFiltered = $result['totalFiltered'];

        // Return JSON response
        return $this->response->setJSON([
            'draw' => intval($this->request->getPost('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $products,
        ]);
    }

    public function index()
    {
        return view('pages/products/index', [
            'title' => 'Product List',
        ]);
    }

    public function store()
    {
        $data = [
            'code' => $this->request->getPost('code'),
            'name' => $this->request->getPost('name'),
            'unit' => $this->request->getPost('unit'),
            'price' => $this->request->getPost('price'),
        ];

        if ($this->model->insert($data)) {
            return redirect()->to('/product')->with('success', 'Product created successfully.');
        } else {
            return redirect()->to('/product')->with('error', 'Something went wrong.');
        }
    }
}
