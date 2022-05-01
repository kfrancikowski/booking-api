<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'date_from' => $this->date_from->format('Y-m-d'),
            'date_to' => $this->date_to->format('Y-m-d'),
            'price' => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'links' => [
                'self' => route('bookings.show', ['booking' => $this->uuid]),
            ],
        ];
    }
}
