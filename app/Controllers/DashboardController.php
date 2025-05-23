<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('pages/dashboard/index', [
            'title' => 'Dashboard',
            'page' => 'dashboard',
        ]);
    }
}
