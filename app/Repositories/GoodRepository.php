<?php

namespace App\Repositories;

use App\Services\Service;
use Exception;
use Illuminate\Http\Response;
use App\Models\GoodUserProperty;
use App\Models\Good;
use App\Models\PropertyType;
use App\Http\Requests\GoodBuyRequest;
use App\Http\Requests\GoodRentRequest;
use App\Http\Requests\GoodStatusRequest;
use Illuminate\Support\Str;

class GoodRepository
{
    /**
    * Покупка товара
    *
    * @param GoodBuyRequest $request
    * @return object|QueryException
    */
    public function buy(GoodBuyRequest $request): object
    {
        try {
            return GoodUserProperty::create([
                'user_id'                       => $request->user_id,
                'good_id'                       => $request->good_id,
                'property_type_id'              => PropertyType::BUY,
                'code'                          => Str::random(10)
            ]);
        } catch (QueryException $exception) {
            throw new QueryException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
    * Аренда товара
    *
    * @param GoodRentRequest $request
    * @return object|QueryException
    */
    public function rent(GoodRentRequest $request): object
    {
        try {
            return GoodUserProperty::create([
                'user_id'                       => $request->user_id,
                'good_id'                       => $request->good_id,
                'property_type_id'              => PropertyType::RENT,
                'code'                          => Str::random(10),
                'rent_hours'                    => $request->rent_hours
            ]);
        } catch (QueryException $exception) {
            throw new QueryException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
    * Продление аренды товара
    *
    * @param GoodRentRequest $request
    * @return int|QueryException
    */
    public function extend(GoodRentRequest $request): int
    {
        try {
            $currentRentHours = GoodUserProperty::where('good_id', $request->good_id)
                                            ->where('user_id', $request->user_id)
                                            ->where('property_type_id', PropertyType::RENT)
                                            ->pluck('rent_hours')[0];

            return GoodUserProperty::where('good_id', $request->good_id)
                                    ->where('user_id', $request->user_id)
                                    ->where('property_type_id', PropertyType::RENT)
                                    ->update(['rent_hours' => (int)$currentRentHours + $request->rent_hours]);
            
        } catch (QueryException $exception) {
            throw new QueryException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
    * Получение статуса товара
    *
    * @param string $code
    * @return int|QueryException
    */
    public function getStatus(string $code): object
    {
        try {
            return GoodUserProperty::where('code', $code)
                                    ->first();
            
        } catch (QueryException $exception) {
            throw new QueryException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
    * Получение статуса товара
    *
    * @param int $userId
    * @return object|QueryException
    */
    public function getHistory(int $userId): object
    {
        try {
            return GoodUserProperty::where('user_id', $userId)
                                    ->get();
            
        } catch (QueryException $exception) {
            throw new QueryException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * Проверка на уже купленный товар
     */
    public function checkIfGoodBoughtOrRented(int $goodId): bool
    {
        return GoodUserProperty::where('good_id', $goodId)->exists();
    }

    /**
     * Проверка на наличие арендованного товара
     * 
     * @param int $goodId
     * @param int $userId
     * 
     * @return bool
     */
    public function checkIfGoodIsRentedAndExists(int $goodId, int $userId): bool
    {
        return GoodUserProperty::where('good_id', $goodId)
                                ->where('user_id', $userId)
                                ->where('property_type_id', PropertyType::RENT)
                                ->exists();
    }

    /**
     * Проверка, чтобы продление аренды не было более 24 часов
     * 
     * @param int $goodId
     * @param int $userId
     * 
     * @return int
     */
    public function getPossibleRentHours(int $goodId, int $userId): int
    {
        return GoodUserProperty::where('good_id', $goodId)
                                ->where('user_id', $userId)
                                ->where('property_type_id', PropertyType::RENT)
                                ->pluck('rent_hours')[0];
    }

    /**
     * Проверка соответствия цены
     * 
     * @param int $goodId
     * @param int $userId
     * @param float $price
     * 
     * @return bool
     */
    public function checkPrice(int $goodId, int $userId, float $price): bool
    {
        return Good::where('id', $goodId)
                    ->where('price', $price)
                    ->exists();
    }

}