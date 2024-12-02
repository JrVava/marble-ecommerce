<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
                    $btn .= '<i class="bx bx-trash me-1"></i>';
                    $btn .= '</a>';
                }
                $btn .= '<a href="javascript:;" title="QR Code of ' . $row['product_name'] . '" data-bs-toggle="modal" data-bs-target="#qrModal" data-id="' . $row['id'] . '">';
                $btn .= '<i class="bx bx-qr-scan me-1"></i></a>';
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
                $fileName = time() . '_' . $product->id . "_" . uniqid() . "." . $image->getClientOriginalExtension();
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
        $product = Product::where('id', '=', $product_id)->with('images')->first();
        return view('admin.product.new-product', ['product' => $product]);
    }

    public function update(Request $request)
    {
        $productId = $request->id;
        $data = $request->all();

        unset($data['images']);
        unset($data['_token']);
        // unset($data['id']);
        Product::where('id', '=', $productId)->update($data);
        if (isset($request->images)) {
            $imageData = [];
            $images = $request->images;
            foreach ($images as $image) {
                $fileName = time() . '_' . $productId . "_" . uniqid() . "." . $image->getClientOriginalExtension();
                $image->storeAs("public/product_images/$productId", $fileName);
                $imageData = [
                    'product_id' => $productId,
                    'image' => $fileName
                ];
                $image = new ProductImage;
                $image->fill($imageData);
                $image->save();
            }
        }
        return redirect()->route('products.list')->with('message', "Product Updated Successfully");
    }

    public function showQRCode($product_id)
    {
        $product = Product::findOrFail($product_id);

        // Generate QR Code with the base URL and product ID
        $qrCode = base64_encode(QrCode::size(200)->generate(route("products.qrcode", ['product_id' => $product->id])));

        // Embed the QR code as an HTML image tag
        $qrCodeHtml = '<img src="data:image/svg+xml;base64,' . $qrCode . '" alt="QR Code">';

        return response()->json(['qrCodeHtml' => $qrCodeHtml, 'productName' => $product->product_name]);
    }
}
