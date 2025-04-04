<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            $_histories = History::with('product');
            if ($user->getRoleNames()->count() < 0) {
                $_histories->where('user_id', '=', $user->id);
            }
            $_histories->select('id', 'product_id', 'mobile_number')
                ->get();
            $histories = $_histories;
            return Datatables::of($histories)
                ->addIndexColumn()
                ->addColumn('product_name', function ($history) {
                    return optional($history->product)->product_name; // Prevent null errors
                })
                ->addColumn('mobile_number', function ($history) {
                    return $history->mobile_number;
                })
                ->addColumn('send_at', function ($history) {
                    return Carbon::parse($history->created_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('download-history', ['id' => $row['id']]) . '" class="edit btn btn-primary btn-sm">Download<i class="bx bxs-download" ></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $bladePath = "";
        if ($user->getRoleNames()->count() < 0) {
            $bladePath = 'product.history';
        } else {
            $bladePath = 'admin.history';
        }
        return view($bladePath);
    }

    public function downloadPDF($id)
    {
        $history = History::where('id', '=', $id)->first();
        if (!$history) {
            abort(404, 'History record not found.');
        }
        $productData = [];
        // Convert fields to an array if they exist
        $fields = $history->fields ? explode(',', $history->fields) : [];

        $product = Product::where('id', '=',  $history->product_id)
            ->select($fields)
            ->first();

        // Convert stored image IDs into an array
        $imageIds = explode(',', $history->image_id);
        $productImages = ProductImage::whereIn('id', $imageIds)->get();

        if ($product) {
            $productData = $product->toArray();
        }

        if ($productImages->count() > 0) {
            $productData['images'] = $productImages;
        }

        $pdf = Pdf::loadView('pdf.product', $productData);
        return $pdf->download(time() . '.pdf');
    }
}
