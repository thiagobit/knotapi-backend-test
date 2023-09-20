<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCardRequest;
use App\Models\Card;
use Illuminate\Http\JsonResponse;

class CardController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCardRequest $request): JsonResponse
    {
        $card = Card::create($request->validated());

        return response()->json($card, 201);
    }
}
