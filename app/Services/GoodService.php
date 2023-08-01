<?php

namespace App\Services;

use Illuminate\Http\Response;
use Exception;
use JsonException;
use App\Http\Requests\GoodBuyRequest;
use App\Http\Requests\GoodRentRequest;
use App\Repositories\GoodRepository;
use App\Models\GoodUserProperty;
use App\Http\Requests\GoodStatusRequest;
use App\Models\PropertyType;

class GoodService
{
    public function __construct(
        private GoodRepository $goodRepository
    ) {}

    /**
    * Покупка товара
    *Exception
    * @param GoodBuyRequest $request
    * @return object|Exception
    */
    public function buy(GoodBuyRequest $request): object
    {
        try {
            if ($this->goodRepository->checkIfGoodBoughtOrRented($request->good_id)) {
                throw new JsonException('Товар уже куплен, либо взят в аренду', Response::HTTP_FORBIDDEN);
            }

            if (!$this->goodRepository->checkPrice(
                $request->good_id, 
                $request->user_id, 
                $request->price
            )) {
                throw new JsonException('Цена покупателя не соответствует цене товара', Response::HTTP_FORBIDDEN);
            }

            return $this->goodRepository->buy($request);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
    * Аренда товара
    *
    * @param GoodRentRequest $request
    * @return object|Exception
    */
    public function rent(GoodRentRequest $request): object
    {
        try {
            if ($this->goodRepository->checkIfGoodBoughtOrRented($request->good_id)) {
                throw new JsonException('Товар уже куплен, либо взят в аренду', Response::HTTP_FORBIDDEN);
            }

            if (!in_array($request->rent_hours, GoodUserProperty::RENT_HOURS)) {
                throw new JsonException('Неверное значение часов для аренды товара', Response::HTTP_BAD_REQUEST);
            }

            return $this->goodRepository->rent($request);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
    * Продление аренды товара
    *
    * @param GoodRentRequest $request
    * @return int|Exception
    */
    public function extend(GoodRentRequest $request): int
    {
        try {
            if (!$this->goodRepository->checkIfGoodIsRentedAndExists($request->good_id, $request->user_id)) {
                throw new JsonException('Товар уже куплен, либо взят в аренду другим покупателем', Response::HTTP_FORBIDDEN);
            }

            if ($this->goodRepository->getPossibleRentHours($request->good_id, $request->user_id) + $request->rent_hours > 24) {
                throw new JsonException('Общее количество часов для аренды превышает 24', Response::HTTP_FORBIDDEN);
            }

            return $this->goodRepository->extend($request);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
    * Получение статуса товара 
    *
    * @param GoodStatusRequest $request
    * @return int|Exception
    */
    public function getStatus(string $code): string
    {
        try {
            $result =  $this->goodRepository->getStatus($code);

            if ($result->propertyType->id == PropertyType::BUY) {
                return 'Товар куплен';
            } else if ($result->propertyType->id == PropertyType::RENT) {
                return 'Товар был арендован на ' . $result->rent_hours . ' часов, начиная с ' . $result->created_at;
            }
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
    * Получение истории покупок и аренд пользователя
    *
    * @param int $userId
    * @return int|Exception
    */
    public function getHistory(int $userId): object
    {
        try {
            return $this->goodRepository->getHistory($userId);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

}
