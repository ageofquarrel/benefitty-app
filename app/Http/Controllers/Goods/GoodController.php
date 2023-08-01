<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\GoodBuyRequest;
use App\Services\GoodService;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\GoodStatusRequest;
use App\Http\Requests\GoodHistoryRequest;
use App\Http\Resources\GoodsHistoryCollection;

class GoodController extends Controller
{
    public function __construct(
        private GoodService $goodService
    ) {}

    /**
     * Проверка статуса товара по коду
     * 
     * @request GoodStatusRequest $request
     */
    public function status(GoodStatusRequest $request): JsonResponse
    {
        try {
            $result = $this->goodService->getStatus($request->code);

            return response()->json([
                'success'   => true,
                'data'      => [],
                'message'   => $result
            ]);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * Получение истории покупок и аренд пользователя
     * 
     * @param GoodHistoryRequest $request
     * @return JsonResponse 
     */
    public function history(GoodHistoryRequest $request): JsonResponse
    {
        try {
            $result = new GoodsHistoryCollection($this->goodService->getHistory($request->user_id));

            return response()->json([
                'success'   => true,
                'data'      => $result,
                'message'   => ''
            ]);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }
}
