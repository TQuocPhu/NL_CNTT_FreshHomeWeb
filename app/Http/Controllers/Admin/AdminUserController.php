<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request) {

        $query = User::with('role');
        $search = $request->input('search');

        if($search) {
            $query->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('phone_number', 'like', "%{$search}%");
        }
        
        $users = $query->paginate(9);

        return view('admin.pages.users', compact('users'));
    }
}
