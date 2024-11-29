<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CkeditorController extends Controller
{
    public function upload(Request $request): JsonResponse
    {
        if ($request->hasFile('upload')) {
            $image = base64_encode(file_get_contents($request->file('upload')->path()));
            return response()->json(['fileName' => "data:image/png;base64," . $image, 'uploaded' => 1, 'url' => "data:image/png;base64," . $image]);
        }
        // Handle the case where no file is uploaded
        return response()->json(['error' => 'No file uploaded.'], 400);
    }
}
