<?php

namespace App\Http\Controllers;



use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        $request->validate(['nome' => 'required|max:100']);
        return Category::create($request->all());
    }
}
