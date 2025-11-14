<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Core\Dashboard\Queries\GetDashboardDataQuery;

class DashboardController extends Controller
{
    /**
     * Exibe a página principal do dashboard.
     *
     * @param GetDashboardDataQuery $query
     * @return View
     */
    public function index(GetDashboardDataQuery $query): View
    {
        $data = $query->handle();
        return view('dashboard.index', $data);
    }
}