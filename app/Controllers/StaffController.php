<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Staff;
use CodeIgniter\HTTP\ResponseInterface;

class StaffController extends BaseController
{
    public function __construct()
    {
        $this->model = model(Staff::class);
    }

    // Endpoint return JSON
    public function getStaffList()
    {
        $draw = $this->request->getVar('draw');
        $start = $this->request->getVar('start');
        $length = $this->request->getVar('length');
        $searchValue = $this->request->getVar('search')['value'];

        $staffs = $this->model->getPaginatedProducts($start, $length, $searchValue);
        $totalRecords = count($staffs);
        $totalFilteredRecords = count($this->model->findAll());

        return $this->response->setJSON([
            'draw' => intval($draw),
            'recordsTotal' => intval($totalRecords),
            'recordsFiltered' => intval($totalFilteredRecords),
            'data' => $staffs,
        ]);
    }

    public function index()
    {
        return view('pages/staffs/index', [
            'title' => 'Staff List',
        ]);
    }

    public function store()
    {
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'gender' => $this->request->getPost('gender'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
        ];

        // Validate the data
        if (!$this->model->validate($data)) {
            $errors = $this->model->errors();
            session()->setFlashdata('errors', $errors);

            return redirect()->to('/staff')->with('errors', session()->getFlashdata('errors'));
        }

        if ($this->model->insert($data)) {
            return redirect()->to('/staff')->with('success', 'Staff Data created successfully.');
        } else {
            return redirect()->to('/staff')->with('error', 'Something went wrong.');
        }
    }

    public function update($id)
    {
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'gender' => $this->request->getPost('gender'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
        ];

        // Validate the data
        if (!$this->model->validate($data)) {
            $errors = $this->model->errors();
            session()->setFlashdata('errors', $errors);

            return redirect()->to('/staff')->with('errors', session()->getFlashdata('errors'));
        }

        if ($this->model->update($id, $data)) {
            return redirect()->to('/staff')->with('success', 'Staff Data updated successfully.');
        } else {
            return redirect()->to('/staff')->with('error', 'Something went wrong.');
        }
    }

    public function destroy($id)
    {
        if ($this->model->delete($id)) {
            return redirect()->to('/staff')->with('success', 'Staff Data deleted successfully.');
        } else {
            return redirect()->to('/staff')->with('error', 'Something went wrong.');
        }
    }
}
