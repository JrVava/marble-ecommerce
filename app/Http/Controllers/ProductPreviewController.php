<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\History;
use App\Models\Product;
use App\Models\ProductImage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'mobile_number' => 'required|digits:10', // Ensures the number is exactly 10 digits
            'product_checkbox' => 'required|array|min:1', // Ensures at least one checkbox is selected
        ], [
            'mobile_number.required' => 'The mobile number is required.',
            'mobile_number.digits' => 'The mobile number must be exactly 10 digits.',
            'product_checkbox.required' => 'At least one checkbox must be selected.',
            'product_checkbox.min' => 'At least one checkbox must be selected.',
        ]);

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
        // Save PDF temporarily to storage
        $pdfPath = 'pdfs/product_' . time() . '.pdf';
        $pdfPath = storage_path('app/public/temp_pdf_' . time() . '.pdf');
        file_put_contents($pdfPath, $pdf->output());

        // Send WhatsApp with PDF
        $whatsAppStatus = $this->sendWhatsAppMessage($request->mobile_number, $pdfPath);

        // Optional: delete the PDF after sending
        if ($whatsAppStatus['status'] == 200) {
            unlink($pdfPath);
        }

        $images = isset($request->images) && count($request->images) > 0 ?? 'images';
        $tableFields['fields'] = implode(',', $request['product_checkbox']);
        $tableFields['product_id'] = $request->product_id;
        $tableFields['user_id'] = Auth::id();
        $tableFields['mobile_number'] = $request->mobile_number;

        if ($images) {
            $tableFields['image_id'] = implode(",", $request->images);
        }

        $this->saveHistory($tableFields);
        return back()->with("success", "Product PDF has been sent.");
    }

    public function sendWhatsAppMessage($mobileNumber, $filePath)
    {
        $whatsAppResponse = Http::asMultipart()
            ->attach('myfile', fopen($filePath, 'r'), basename($filePath))
            ->post(env('WHATSAPP_URL'), [
                [
                    'name' => 'authToken',
                    'contents' => env('WHATSAPP_AUTH_TOKEN'),
                ],
                [
                    'name' => 'sendto',
                    'contents' => $mobileNumber,
                ],
                [
                    'name' => 'originWebsite',
                    'contents' => env('WHATSAPP_ORIGIN_WEBSITE'),
                ],
                [
                    'name' => 'templateName',
                    'contents' => env('WHATSAPP_TEMPLATE_NAME'),
                ],
                [
                    'name' => 'data',
                    'contents' => json_encode(['message' => 'Hello Dear']),
                ],
                [
                    'name' => 'language',
                    'contents' => env('WHATSAPP_LANGUAGE'),
                ],
                [
                    'name' => 'buttonValue',
                    'contents' => env('WHATSAPP_BUTTON_VALUE'),
                ],
                [
                    'name' => 'isTinyURL',
                    'contents' => env('WHATSAPP_IS_TINY_URL'),
                ],
            ]);
        $responseData = $whatsAppResponse->json();
        return [
            'message' => $responseData['Message'] ?? 'No message',
            'status' => $responseData['Status'] ?? 500,
            'messageId' => $responseData['Data']['messageId'] ?? null,
            'isSuccess' => $responseData['IsSuccess'] ?? false,
        ];
    }

    private function saveHistory($data)
    {
        $history = new History();
        $history->fill($data);
        $history->save();
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
