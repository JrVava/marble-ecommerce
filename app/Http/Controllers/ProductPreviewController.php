<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ProductPreviewController extends Controller
{
    public function index($product_id){
        $product = Product::where('id','=',$product_id)->with('images')->first();
        // dd("hello",$product);

        return view('product.preview',['product' => $product]);
    }

    public function sendProductPDF(Request $request){
        $product = Product::where('id','=',$request->product_id)->first();
        $productData = [];
        foreach($request->product_checkbox as $productKey) {
            $productData[$productKey] = $product->$productKey;
        }

        if(isset($request->images)){
            $productImages = ProductImage::whereIn('id',$request->images)->get();
    
            $productData['images'] = $productImages;
        }
        
        $pdf = Pdf::loadView('pdf.product', $productData);

        return $pdf->download('example.pdf');

    }
}
