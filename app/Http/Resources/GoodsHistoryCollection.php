<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GoodsHistoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id'            => $item->id,
                'user'          => $item->user,
                'good'          => $item->good,
                'propertyType'  => $item->propertyType,
                'rent_hours'    => $item->rent_hours,
                'code'          => $item->code
            ];
        });
    }
}
