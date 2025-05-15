<?php

namespace App\Models;

use CodeIgniter\Model;

class Product extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'code',
        'name',
        'unit',
        'price',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'code'  => 'required|is_unique[products.code]',
        'name'  => 'required',
        'unit'  => 'required',
        'price' => 'required|decimal',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['setInsertValidationRules'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['setUpdateValidationRules'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Custom methods
    protected function setInsertValidationRules(array $data)
    {
        $this->validationRules = [
            'code'  => 'required|is_unique[products.code]',
            'name'  => 'required',
            'unit'  => 'required',
            'price' => 'required|decimal',
        ];
        return $data;
    }

    protected function setUpdateValidationRules(array $data)
    {
        $this->validationRules = [
            'name'  => 'required',
            'unit'  => 'required',
            'price' => 'required|decimal',
        ];
        return $data;
    }

    public function getPaginatedProducts($start, $length, $searchValue = null)
    {
        $builder = $this->builder();
        $builder->where(['deleted_at' => null]);

        // Apply filtering
        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('code', $searchValue)
                ->orLike('name', $searchValue)
                ->orLike('unit', $searchValue)
                ->orLike('price', $searchValue)
                ->groupEnd();
        }

        // Count filtered results
        $totalFiltered = $builder->countAllResults(false);

        // Apply pagination
        $data = $builder->limit($length, $start)
            ->get()
            ->getResultArray();

        return [
            'data' => $data,
            'totalFiltered' => $totalFiltered,
        ];
    }

    public function getTotalProducts()
    {
        return $this->countAll();
    }

    public function generateCode()
    {
        $lastProduct = $this->orderBy('id', 'DESC')->first();
        $lastCode = $lastProduct ? $lastProduct['code'] : null;

        if ($lastCode) {
            // Extract the numeric part of the code after "PR"
            $lastNumber = (int) substr($lastCode, 2);
            // Increment the number and pad it to 2 digits
            $newNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);
            return 'PR' . $newNumber;
        }

        // Default code if no product exists
        return 'PR01';
    }
}
