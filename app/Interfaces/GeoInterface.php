<?php

namespace App\Interfaces;

interface GeoInterface
{
    /**
     * @param string $latitude
     * @param string $longitude
     * @param int $userId
     * @return mixed
     */
    public function receiveAddress(string $latitude, string $longitude, int $userId): void;
}