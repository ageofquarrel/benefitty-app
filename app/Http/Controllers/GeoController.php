<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressListResource;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CoordinateRequest;
use App\Jobs\ReceiveAddressByCoordinates;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressListRequest;
use App\Interfaces\GeoInterface;

class GeoController extends Controller
{
    public function __construct(
        private GeoInterface $yandexGeoService
    ) {}

    /**
     * @param CoordinateRequest $request
     * @return JsonResponse
     */
    public function saveCoordinates(CoordinateRequest $request): JsonResponse
    {
        try {
            ReceiveAddressByCoordinates::dispatch($request->latitude, $request->longitude, Auth::user()->id);

            return response()->json('Задача добавлена в очередь');
        } catch (Exception $e) {
            return response()->json('Ошибка постановки задачи в очередь');
        }
    }

    /**
     * @param AddressListRequest $request
     * @return JsonResponse
     */
    public function getPath(AddressListRequest $request): JsonResponse
    {
        try {
            $addressList = $this->yandexGeoService->getPath($request);

            return response()->json($addressList);
        } catch (Exception $e) {
            return response()->json('Ошибка получения маршрута');
        }
    }
}
