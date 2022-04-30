<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VacancyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'number_of_vacancies' => $this->number_of_vacancies,
            'price' => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'links' => [
                'self' => route('vacancies.show', ['vacancy' => $this->uuid]),
            ],
        ];
    }
}
