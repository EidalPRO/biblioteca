<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        return redirect(route('catalogo'));
    }
}
