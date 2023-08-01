<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\GoodBuyRequest;
use App\Services\GoodService;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\GoodsBuyResource;

class GoodBuyController extends Controller
{

    public function __construct(
        private GoodService $goodService
    ) {}

    /**
     * Покупка товара
     * 
     * @request GoodBuyRequest $request
     */
    public function index(GoodBuyRequest $request): JsonResponse
    {
        try {
            $result = new GoodsBuyResource($this->goodService->buy($request));

            return response()->json([
                'success'   => true,
                'data'      => $result,
                'message'   => 'Товар был успешно куплен'
            ]);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }
}
