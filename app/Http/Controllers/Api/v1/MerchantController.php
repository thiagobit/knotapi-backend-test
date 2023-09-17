<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\JsonResponse;

class MerchantController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Merchant $merchant): JsonResponse
    {
        return response()->json($merchant);
    }
}
