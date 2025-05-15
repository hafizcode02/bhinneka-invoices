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

    public function generateCode()
    {
        $code = $this->model->generateCode();
        return $this->response->setJSON(['code' => $code]);
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
            'code' => $this->model->generateCode(),
            'name' => $this->request->getPost('name'),
            'unit' => $this->request->getPost('unit'),
            'price' => $this->request->getPost('price'),
        ];

        // Validate the data
        if (!$this->model->validate($data)) {
            $errors = $this->model->errors();
            session()->setFlashdata('errors', $errors);

            return redirect()->to('/product')->with('errors', session()->getFlashdata('errors'));
        }

        if ($this->model->insert($data)) {
            return redirect()->to('/product')->with('success', 'Product created successfully.');
        } else {
            return redirect()->to('/product')->with('error', 'Something went wrong.');
        }
    }

    public function update($id)
    {
        $data = [
            'name' => $this->request->getPost('name'),
            'unit' => $this->request->getPost('unit'),
            'price' => $this->request->getPost('price'),
        ];

        // Validate the data
        if (!$this->model->validate($data)) {
            $errors = $this->model->errors();
            session()->setFlashdata('errors', $errors);

            return redirect()->to('/product')->with('errors', session()->getFlashdata('errors'));
        }

        if ($this->model->update($id, $data)) {
            return redirect()->to('/product')->with('success', 'Product updated successfully.');
        } else {
            return redirect()->to('/product')->with('error', 'Something went wrong.');
        }
    }

    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return redirect()->to('/product')->with('success', 'Product deleted successfully.');
        } else {
            return redirect()->to('/product')->with('error', 'Something went wrong.');
        }
    }
}
