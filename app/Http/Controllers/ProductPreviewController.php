<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductImage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductPreviewController extends Controller
{
    public function index($product_id)
    {
        $product = Product::where('id', '=', $product_id)->with('images')->first();

        $carts = [
            'product_name',
            'description',
            'product_origin'
        ];
        // $product = Product::where('id', '=',  $product_id)
        //     ->select($carts)
        //     ->first();
        // dd($product);
        return view('product.preview', ['product' => $product]);
    }

    public function sendProductPDF(Request $request)
    {
        $product = Product::where('id', '=', $request->product_id)->first();
        $productData = [];
        if (isset($request->product_checkbox)) {
            foreach ($request->product_checkbox as $productKey) {
                $productData[$productKey] = $product->$productKey;
            }
        }

        if (isset($request->images)) {
            $productImages = ProductImage::whereIn('id', $request->images)->get();

            $productData['images'] = $productImages;
        }

        $pdf = Pdf::loadView('pdf.product', $productData);
        // Define file path inside storage/app/public/
        // $pdfPath = 'pdfs/product_' . time() . '.pdf';

        // Save PDF to storage
        // Storage::disk('public')->put($pdfPath, $pdf->output());

        // Send PDF via WhatsApp
        // $this->sendWhatsAppPdf($request->whatsapp_number, $pdfPath);
        return $pdf->download('example.pdf');
    }

    /**
     * Send PDF via WhatsApp using Twilio
     */
    private function sendWhatsAppPdf($phone, $pdfPath)
    {
        // $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        // $twilio->messages->create(
        //     "whatsapp:$phone",
        //     [
        //         'from' => env('TWILIO_WHATSAPP_NUMBER'),
        //         'body' => "Here is your product PDF!",
        //         'mediaUrl' => [asset('storage/' . $pdfPath)] // Attach the PDF file
        //     ]
        // );
    }

    public function addToCart(Request $request)
    {

        $images = isset($request->images) && count($request->images) > 0 ?? 'images';
        $tableFields['fields'] = implode(',', $request['product_checkbox']);
        $tableFields['product_id'] = $request->product_id;
        $tableFields['user_id'] = Auth::id();

        if ($images) {
            $tableFields['image_id'] = implode(",", $request->images);
        }
        $cart = new Cart();
        $cart->fill($tableFields);
        $cart->save();

        return redirect()->route('preview-product.index', ['product_id' => $request->product_id])->with(['message' => "Item has been added to cart."]);
    }

    public function cart()
    {
        $carts = Cart::where('user_id', '=', Auth::id());
        $productIds = $carts->pluck('product_id');
        $products = Product::with('firstImage')->whereIn('id', $productIds)->get();

        $html = view('layouts.cart', [
            'cart_count' => $carts->count(),
            'products' => $products,
            'carts' => $carts
        ])->render();

        return response()->json(['html' => $html]);
    }

    public function getAllProducts()
    {
        $products = Product::with('firstImage')->get();
        return view('product.product-listing', ['products' => $products]);
    }
}
