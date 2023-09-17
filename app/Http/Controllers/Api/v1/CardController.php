<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCardRequest;
use App\Models\Card;

class CardController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCardRequest $request)
    {
        Card::create($request->validated());

        return response()->json('', 201);
    }
}
