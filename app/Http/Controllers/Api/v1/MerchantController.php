<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexMerchantRequest;
use App\Http\Requests\StoreMerchantRequest;
use App\Models\Merchant;
use Illuminate\Http\JsonResponse;

class MerchantController extends Controller
{
    /**
     * Display a listing of Merchants.
     *
     * @param IndexMerchantRequest $request
     * @return JsonResponse
     */
    public function index(IndexMerchantRequest $request): JsonResponse
    {
        $pageSize = $request['page_size'] ?? config('api.page_size');

        return response()->json(Merchant::paginate($pageSize), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Merchant $merchant): JsonResponse
    {
        return response()->json($merchant);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMerchantRequest $request): JsonResponse
    {
        $merchant = Merchant::create($request->validated());

        return response()->json($merchant, 201);
    }
}
