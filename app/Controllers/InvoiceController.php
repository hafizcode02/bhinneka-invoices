<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Staff;
use CodeIgniter\HTTP\ResponseInterface;

class InvoiceController extends BaseController
{
    protected $invoiceModel;
    protected $invoiceItemModel;
    protected $productModel;
    protected $staffModel;

    public function __construct()
    {
        $this->invoiceModel = model(Invoice::class);
        $this->invoiceItemModel = model(InvoiceItem::class);
        $this->productModel = model(Product::class);
        $this->staffModel = model(Staff::class);
    }

    public function index()
    {
        return view('pages/invoices/index', [
            'title' => 'Invoice',
            'page' => 'invoice',
        ]);
    }

    // Create Invoice
    public function create()
    {
        return view('pages/invoices/create', [
            'title' => 'Buat Invoice Baru',
            'page' => 'Tambah Invoice',
        ]);
    }

    // Store Invoice
    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'invoice_number' => 'required',
            'staff_id' => 'required|numeric',
            'company_to' => 'required',
            'company_address' => 'required',
            'attention_to' => 'required',
            'items' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Insert invoice
            $invoiceData = [
                'invoice_number' => $this->request->getPost('invoice_number'),
                'staff_id' => $this->request->getPost('staff_id'),
                'company_to' => $this->request->getPost('company_to'),
                'company_address' => $this->request->getPost('company_address'),
                'attention_to' => $this->request->getPost('attention_to'),
            ];

            $this->invoiceModel->insert($invoiceData);
            $invoiceId = $this->invoiceModel->getInsertID();

            // Debug log - Invoice created
            log_message('debug', 'Invoice created with ID: ' . $invoiceId);

            // Insert invoice items
            $items = $this->request->getPost('items');

            foreach ($items as $item) {
                if (!empty($item['product_id'])) {
                    $itemData = [
                        'invoice_id' => $invoiceId,
                        'product_id' => $item['product_id'],
                        'staff_id' => $invoiceData['staff_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                    ];

                    // Insert the item
                    $result = $this->invoiceItemModel->insert($itemData);

                    if ($result === false) {
                        log_message('error', 'Failed to insert invoice item: ' . json_encode($db->error()));
                    } else {
                        log_message('debug', 'Invoice item inserted with ID: ' . $result);
                    }
                }
            }

            $db->transCommit();
            return redirect()->to('/invoice')->with('success', 'Invoice berhasil dibuat.');
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error in store method: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Edit Invoice
    public function edit($id)
    {
        $invoice = $this->invoiceModel->find($id);

        if (!$invoice) {
            return redirect()->to('/invoice')->with('error', 'Invoice tidak ditemukan');
        }

        // Get all invoice items with product details for this invoice
        $items = $this->invoiceItemModel->select('invoice_items.*, products.name as product_name, products.code as product_code')
            ->join('products', 'products.id = invoice_items.product_id', 'left')
            ->where('invoice_id', $id)
            ->findAll();

        return view('pages/invoices/edit', [
            'title' => 'Edit Invoice',
            'page' => 'invoice',
            'invoice' => $invoice,
            'items' => $items,
        ]);
    }

    // Update Invoice
    public function update($id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'invoice_number' => 'required',
            'staff_id' => 'required|numeric',
            'company_to' => 'required',
            'company_address' => 'required',
            'attention_to' => 'required',
            'items' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('errors', $validation->getErrors());
        }

        $invoice = $this->invoiceModel->find($id);
        if (!$invoice) {
            return redirect()->to('/invoice')->with('error', 'Invoice tidak ditemukan');
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Update invoice
            $invoiceData = [
                'staff_id' => $this->request->getPost('staff_id'),
                'company_to' => $this->request->getPost('company_to'),
                'company_address' => $this->request->getPost('company_address'),
                'attention_to' => $this->request->getPost('attention_to'),
            ];

            $this->invoiceModel->update($id, $invoiceData);

            // Process items
            $items = $this->request->getPost('items');
            // Existing item IDs
            $existingItemIds = [];

            foreach ($items as $item) {
                if (!empty($item['product_id'])) {
                    // Item data
                    $itemData = [
                        'invoice_id' => $id,
                        'product_id' => $item['product_id'],
                        'staff_id' => $invoiceData['staff_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                    ];

                    // Update existing or insert new item
                    if (isset($item['id']) && !empty($item['id'])) {
                        $result = $this->invoiceItemModel->update($item['id'], $itemData);
                        $existingItemIds[] = $item['id'];
                    } else {
                        $check = $this->invoiceItemModel->where('invoice_id', $id)
                            ->where('product_id', $item['product_id'])
                            ->first();

                        if ($check) {
                            $itemData['id'] = $check['id'];
                            $result = $this->invoiceItemModel->update($check['id'], [
                                'quantity' => $check['quantity'] + $item['quantity'],
                                'subtotal' => $check['subtotal'] + $item['subtotal'],
                            ]);
                            $existingItemIds[] = $check['id'];
                        } else {
                            $result = $this->invoiceItemModel->insert($itemData);

                            // Get the ID of the newly inserted item and add to existingItemIds
                            if (is_numeric($result) && $result > 0) {
                                $newItemId = $this->invoiceItemModel->getInsertID();
                                $existingItemIds[] = $newItemId;
                            } else if ($this->invoiceItemModel->getInsertID() > 0) {
                                $newItemId = $this->invoiceItemModel->getInsertID();
                                $existingItemIds[] = $newItemId;
                            }

                            // Check for errors
                            if ($result === false) {
                                log_message('error', 'Failed to insert new invoice item: ' . json_encode($this->invoiceItemModel->errors()));
                            }
                        }
                    }
                }
            }

            // Delete removed items
            if (!empty($existingItemIds)) {
                $removedItems = $this->invoiceItemModel->where('invoice_id', $id)
                    ->whereNotIn('id', $existingItemIds)
                    ->findAll();

                if (!empty($removedItems)) {
                    foreach ($removedItems as $removedItem) {
                        $this->invoiceItemModel->delete($removedItem['id']);
                    }
                }
            }

            $db->transCommit();
            return redirect()->to('/invoice')->with('success', 'Invoice berhasil diupdate.');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Delete Invoice
    public function destroy($id)
    {
        try {
            // Delete invoice items first
            $this->invoiceItemModel->where('invoice_id', $id)->delete();

            // Then delete the invoice
            $this->invoiceModel->delete($id);

            return redirect()->to('/invoice')->with('success', 'Invoice berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/invoice')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Print Invoice
    public function print($id)
    {
        $invoice = $this->invoiceModel->select('invoices.*, staffs.name as staff_name')
            ->join('staffs', 'staffs.id = invoices.staff_id', 'left')
            ->find($id);

        if (!$invoice) {
            return redirect()->to('/invoice')->with('error', 'Invoice tidak ditemukan');
        }

        $items = $this->invoiceItemModel->select('invoice_items.*, products.name as product_name, products.code as product_code, products.unit')
            ->join('products', 'products.id = invoice_items.product_id')
            ->where('invoice_id', $id)
            ->findAll();

        $totalAmount = array_sum(array_column($items, 'subtotal'));

        $data = [
            'invoice' => $invoice,
            'items' => $items,
            'totalAmount' => $totalAmount,
            'title' => 'Print Invoice',
        ];

        return view('pages/invoices/print', $data);
    }

    // Endpoint return JSON
    // Get All Invoices
    public function getInvoices()
    {
        if ($this->request->isAJAX()) {
            $builder = $this->invoiceModel->builder();
            $builder->select('invoices.*, staffs.name as staff_name')
                ->join('staffs', 'staffs.id = invoices.staff_id', 'left')
                ->where('invoices.deleted_at', null);

            $data = [];
            $start = $this->request->getPost('start');
            $length = $this->request->getPost('length');
            $draw = $this->request->getPost('draw');
            $order = $this->request->getPost('order')[0];
            $dir = $this->request->getPost('order')[0]['dir'];
            $search = $this->request->getPost('search')['value'];

            // Search
            if (!empty($search)) {
                $builder->groupStart()
                    ->like('invoice_number', $search)
                    ->orLike('company_to', $search)
                    ->orLike('attention_to', $search)
                    ->orLike('staffs.name', $search)
                    ->groupEnd();
            }

            // Order
            $columns = ['', 'invoice_number', 'staffs.name', 'company_to', 'attention_to', 'created_at', ''];
            if (isset($columns[$order['column']])) {
                $orderColumn = $columns[$order['column']];
                if (!empty($orderColumn)) {
                    $builder->orderBy($orderColumn, $dir);
                }
            }

            // Pagination
            $totalRecords = $builder->countAllResults(false);
            $builder->limit($length, $start);
            $records = $builder->get()->getResultArray();

            foreach ($records as $record) {
                $data[] = $record;
            }

            return $this->response->setJSON([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $data,
            ]);
        }
    }

    // Generate Invoice Number
    public function generateNumber()
    {
        if ($this->request->isAJAX()) {
            // Generate invoice number format: INV-YYYYMMDD-XXXX
            $date = date('Ymd');
            $lastInvoice = $this->invoiceModel->like('invoice_number', "INV-$date")
                ->orderBy('id', 'DESC')
                ->first();

            $sequence = 1;
            if ($lastInvoice) {
                $parts = explode('-', $lastInvoice['invoice_number']);
                $sequence = intval(end($parts)) + 1;
            }

            $invoiceNumber = sprintf("INV-%s-%04d", $date, $sequence);

            return $this->response->setJSON([
                'number' => $invoiceNumber,
            ]);
        }
    }

    // Get All Staffs
    public function getAllStaffs()
    {
        $staffs = $this->staffModel->findAll();
        return $this->response->setJSON($staffs);
    }

    // Get All Products
    public function getAllProducts()
    {
        $products = $this->productModel->findAll();
        return $this->response->setJSON($products);
    }

    // Get Invoice Detail
    public function detail($id)
    {
        if ($this->request->isAJAX()) {
            $invoice = $this->invoiceModel->select('invoices.*, staffs.name as staff_name')
                ->join('staffs', 'staffs.id = invoices.staff_id', 'left')
                ->find($id);

            if (!$invoice) {
                return $this->response->setJSON(['error' => 'Invoice tidak ditemukan']);
            }

            $items = $this->invoiceItemModel->select('invoice_items.*, products.name as product_name, products.code as product_code, products.unit')
                ->join('products', 'products.id = invoice_items.product_id')
                ->where('invoice_id', $id)
                ->findAll();

            $totalAmount = array_sum(array_column($items, 'subtotal'));

            $html = view('pages/invoices/detail', [
                'invoice' => $invoice,
                'items' => $items,
                'totalAmount' => $totalAmount,
            ]);

            return $this->response->setBody($html);
        }
    }
}
