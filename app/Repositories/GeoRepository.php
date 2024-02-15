<?php

namespace App\Repositories;

use Illuminate\Database\QueryException;
use App\Models\Coordinate;
use Illuminate\Support\Facades\Auth;

class GeoRepository
{
    const CHUNK_SIZE = 100;
    /**
    * Сохранение адреса пользователя
    *
    * @param int $userId
    * @param string $latitude
    * @param string $longitude
    * @param string $address
    * @return void
    */
    public function saveAddress(int $userId, string $latitude, string $longitude, string $address): void
    {
        try {
            $coordinate = new Coordinate;
            $coordinate->user_id = $userId;
            $coordinate->latitude = $latitude;
            $coordinate->longitude = $longitude;
            $coordinate->address = $address;
            $coordinate->save();

        } catch (QueryException $exception) {
            throw new QueryException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param string $dateFrom
     * @param string $dateTo
     * @return object
     */
    public function getPath(string $dateFrom, string $dateTo): object
    {
        return Coordinate::where('created_at', '>=', $dateFrom)
                            ->where('created_at', '<=', $dateTo)
                            ->where('user_id', Auth::user()->id)
                            ->get()
                            ->chunk(self::CHUNK_SIZE);
    }
}