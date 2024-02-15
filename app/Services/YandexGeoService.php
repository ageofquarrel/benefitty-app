<?php

namespace App\Services;

use App\Interfaces\GeoInterface;
use Exception;
use JsonException;
use Illuminate\Support\Facades\Http;
use App\Repositories\GeoRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressListRequest;

class YandexGeoService implements GeoInterface
{
    public function __construct(
        private GeoRepository $geoRepository
    ) {}

    /**
     * @param string $latitude
     * @param string $longitude
     * @param int $userId
     * @return void
     */
    public function receiveAddress(string $latitude, string $longitude, int $userId): void
    {
        try {
            $response = Http::get(env('YANDEX_API_URL'), [
                'apikey' => env('YANDEX_API_KEY'),
                'geocode' => $latitude . ',' . $longitude,
                'lang' => 'ru_RU',
                'sco' => 'latlong'
            ]);

            $address = (string)simplexml_load_string(
                                $response->getBody()->getContents())
                                ->GeoObjectCollection
                                ->featureMember
                                ->GeoObject
                                ->metaDataProperty
                                ->GeocoderMetaData
                                ->Address
                                ->formatted;

            $this->geoRepository->saveAddress($userId, $latitude, $longitude, $address);
        } catch (Exception $e) {
            throw new JsonException('Ошибка получения адреса', $e->getCode());
        }
    }

    /**
     * @param AddressListRequest $request
     * @return object
     */
    public function getPath(AddressListRequest $request): object
    {
        return $this->geoRepository->getPath($request->dateFrom, $request->dateTo);
    }
}
