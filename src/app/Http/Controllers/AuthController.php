<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class AuthController extends Controller
{
    public function index()
    {
        return view('/admin');
    }

}