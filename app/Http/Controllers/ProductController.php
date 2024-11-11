<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:product-delete', ['only' => ['delete']]);
    }
    public function index()
    {
        return view('admin.product.index');
    }

    public function create()
    {
        return view('admin.product.new-product');
    }

    public function edit()
    {
        return view('admin.product.edit-product');
    }
}
