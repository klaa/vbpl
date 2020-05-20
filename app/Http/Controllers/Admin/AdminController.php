<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    public function dashboard(Request $request) {
        $this->authorize('viewDashboard',User::class);
        return view('admin.dashboard');
    }
}
