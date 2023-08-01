<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\GoodRentRequest;
use App\Services\GoodService;
use App\Http\Resources\GoodsRentResource;
use Exception;

class GoodRentController extends Controller
{
    public function __construct(
        private GoodService $goodService
    ) {}

    /**
     * Аренда товара
     * 
     * @param GoodRentRequest $request
     */
    public function index(GoodRentRequest $request)
    {
        try {
            $result = new GoodsRentResource($this->goodService->rent($request));

            return response()->json([
                'success'   => true,
                'data'      => $result,
                'message'   => 'Товар был успешно арендован'
            ]);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * Продление аренды товара
     * 
     * @param GoodRentRequest $request
     */
    public function extend(GoodRentRequest $request)
    {
        try {
            $this->goodService->extend($request);

            return response()->json([
                'success'   => true,
                'data'      => '',
                'message'   => 'Аренда товара была успешно продлена на ' . $request->rent_hours . ' часов'
            ]);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }
}
