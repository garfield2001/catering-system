<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminUser;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        return view("admin.dashboard.index", [
            'title' => 'Dashboard',
            'user' => $user
        ]);
    }
}
