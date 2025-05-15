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
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Custom methods
    public function getPaginatedProducts($start, $length, $searchValue = null)
    {
        $builder = $this->builder();

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
}
