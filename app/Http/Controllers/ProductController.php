<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

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

    public function getProducts()
    {
        $nonRoles = Product::get();

        return DataTables::of($nonRoles)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $status = $row['status'] == 1 ? 'checked' : "";
                $btn = '<div class="button-group d-flex">';
                if (auth()->user()->can('product-edit')) {

                    $btn .= '<a href="' . route('products.edit', ['product_id' => $row['id']]) . '" title="EDIT">';
                    $btn .= '<i class="bx bx-edit-alt me-1"></i>';
                    $btn .= '</a>';
                }
                if (auth()->user()->can('product-delete')) {
                    $btn .= '<form method="post" action="' . route('products.delete', ['product_id' => $row->id]) . '">' . csrf_field() . ' ' . method_field("DELETE") . '</form>';
                    $btn .= '<a href="javascript:;" class="delete-product">';
                    $btn .= '<i class="bx bx-trash"></i>';
                    $btn .= '</a>';
                }

                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('status', function ($row) {
                $statusLable = $row['status'] == 1 ? 'Active' : "Inactive";
                $statusClass = $row['status'] == 1 ? 'primary' : "danger";
                $btn = '';
                $btn .= "<span class='badge bg-label-$statusClass me-1'>$statusLable</span>";
                return $btn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.product.new-product');
    }

    public function store(Request $request)
    {

        $product = new Product;
        $data = $request->all();
        unset($data['images']);
        // dd($data);
        $product->fill($data);
        $product->save();

        if (isset($request->images)) {
            foreach ($request->images as $image) {
                $fileName = time() . '_' . $product->id . $image->getClientOriginalExtension();
                $image->storeAs("public/product_images/$product->id", $fileName);
                $imageData = [
                    'product_id' => $product->id,
                    'image' => $fileName
                ];
                $image = new ProductImage;
                $image->fill($imageData);
                $image->save();
            }
        }
        return redirect()->route('products.list')->with('message', "Product Added Successfully");
    }

    public function delete($product_id)
    {

        ProductImage::where('product_id', '=', $product_id)->delete();
        Product::where('id', '=', $product_id)->delete();

        $folderPath = 'public/product_images/' . $product_id;
        if (Storage::exists($folderPath)) {
            Storage::deleteDirectory($folderPath);
        }
        return redirect()->route('products.list')->with('message', "Product Delete Successfully");
    }

    public function edit($product_id)
    {
        $product = Product::where('id', '=', $product_id)->first();
        return view('admin.product.new-product', ['product' => $product]);
    }
}
