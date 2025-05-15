<?php

namespace App\Models;

use CodeIgniter\Model;

class Staff extends Model
{
    protected $table            = 'staffs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'email',
        'gender',
        'phone',
        'address',
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
    protected $validationRules = [
        'name'     => 'required|min_length[3]|max_length[50]',
        'email'    => 'required|valid_email',
        'gender' => 'required|in_list[Pria,Wanita]',
        'phone' => 'required|min_length[10]|max_length[15]',
        'address'  => 'required|min_length[5]|max_length[255]',
    ];
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
        $builder->where(['deleted_at' => null]);

        // Apply filtering
        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('name', $searchValue)
                ->orLike('email', $searchValue)
                ->orLike('gender', $searchValue)
                ->orLike('phone', $searchValue)
                ->orLike('address', $searchValue)
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
